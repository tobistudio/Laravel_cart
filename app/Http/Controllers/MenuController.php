<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\LanguagePage;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function menus(): JsonResponse
    {
        $menus = (new Menu)->where('language_id', 3)->get(['id', 'name']);

        return response()->json([
            'menus' => $menus,
        ]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function menu($id): JsonResponse
    {
        $menu = (new Menu)->where('id', $id)->first(['id', 'name', 'key']);

        if(!$menu){
            return response()->json([
                'message' => 'menu_does_not_exist',
                'redirect' => '/system/menus',
            ], 403);
        }

        $languages = Language::all(['id', 'locale']);

        $translations = [];
        $menu_tree = [];
        $menus = (new Menu)->where('key', $menu->key)->with('language:id,locale')->get(['id', 'name', 'language_id']);
        foreach($menus as $menu_trans){
            $translations[] = [
                'id' => $menu_trans->id,
                'name' => $menu_trans->name,
                'locale' => $menu_trans->language->locale,
                'language_id' => $menu_trans->language_id,
            ];

            $menu_items = MenuItem::where('menu_id', $menu_trans->id)->get();

            $menu_tree[$menu_trans->language->locale] = $this->getMenuTree($menu_items, null);
        }

        $pages = [];
        foreach ($languages as $language) {
            $_pages = (new LanguagePage)->where('language_id', $language->id)->where('status', 1)->get();
            $language_pages = [];
            foreach ($_pages as $page) {
                $language_pages[] = [
                    'item_id' => $page['id'],
                    'text' => $page['name'],
                    'url' => env('APP_URL') . '/' . $page->slug,
                    'type' => 'page'
                ];
            }
            $pages[$language->locale] = $language_pages;
        }

        return response()->json([
            'menus' => $menu_tree,
            'translations' => $translations,
            'pages' => $pages
        ]);
    }

    /**
     * @param $menu_items
     * @param $parent_id
     * @return array
     */
    protected function getMenuTree($menu_items, $parent_id = null): array
    {
        $menu_tree = [];
        foreach ($menu_items as $item_index => $item) {
            if($item['item_id']){
                $language_page = (new LanguagePage)->where('id', $item['item_id'])->first();
                if($language_page) {
                    $original_title = $language_page->name;
                    $url = env('APP_URL') . '/' . $item->url;
                } else {
                    unset($menu_items[$item_index]);
                }
            } else {
                $original_title = '';
                $url = $item['url'];
            }

            if ($item['parent_id'] == $parent_id) {
                $children = $this->getMenuTree($menu_items, $item['id']);
                if ($children) {
                    $item['children'] = $children;
                }

                if ($item['children']) {
                    $menu_tree[] = [
                        'id' => $item['id'],
                        'item_id' => $item['item_id'],
                        'old_text' => $item['text'],
                        'text' => $item['text'],
                        'original_title' => $original_title,
                        'old_url' => $url,
                        'url' => $url,
                        'old_open_in_new_tab' => $item['open_in_new_tab'],
                        'open_in_new_tab' => $item['open_in_new_tab'],
                        'type' => $item['type'],
                        'children' => $item['children']
                    ];
                } else {
                    $menu_tree[] = [
                        'id' => $item['id'],
                        'item_id' => $item['item_id'],
                        'old_text' => $item['text'],
                        'text' => $item['text'],
                        'original_title' => $original_title,
                        'old_url' => $url,
                        'url' => $url,
                        'old_open_in_new_tab' => $item['open_in_new_tab'],
                        'open_in_new_tab' => $item['open_in_new_tab'],
                        'type' => $item['type'],
                    ];
                }

            }
        }

        return $menu_tree;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function save(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'menus.*.name' => 'required',
        ], [
            'menus.*.name.required' => 'name_required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $menu = (new Menu)->where('id', $request['id'])->first();

        if (!$menu) {
            return response()->json(['message' => 'menu_not_found'], 422);
        }

        foreach ($request['menus'] as $m) {
            $_m = Menu::where('id', $m['id'])->where('key', $menu->key)->first();
            if ($_m) {
                $_m->update([
                    'name' => $m['name']
                ]);

                //delete all menu items
                MenuItem::where('menu_id', $_m->id)->delete();

                if (count($m['menu']) > 0) {
                    foreach ($m['menu'] as $item) {
                        $menu_item = MenuItem::create([
                            'menu_id' => $_m->id,
                            'parent_id' => null,
                            'item_id' => $item['item_id'],
                            'text' => $item['text'],
                            'url' => $item['url'],
                            'open_in_new_tab' => $item['open_in_new_tab'],
                            'type' => $item['type'],
                        ]);

                        if (isset($item['children'])) {
                            $this->storeMenuItems($_m->id, $menu_item->id, $item['children']);
                        }
                    }
                }
            }
        }

        return response()->json([
            'message' => 'menu_saved',
            'type' => 'system',
        ], 200);
    }

    /**
     * @param $menu_id
     * @param $parent_id
     * @param $children
     * @return void
     */
    protected function storeMenuItems($menu_id, $parent_id, $children): void
    {
        foreach ($children as $item) {
            $menu_item = MenuItem::create([
                'menu_id' => $menu_id,
                'parent_id' => $parent_id,
                'item_id' => $item['item_id'],
                'text' => $item['text'],
                'url' => $item['url'],
                'open_in_new_tab' => $item['open_in_new_tab'],
                'type' => $item['type'],
            ]);

            if (isset($item['children'])) {
                $this->storeMenuItems($menu_id, $menu_item->id, $item['children']);
            }
        }
    }
}
