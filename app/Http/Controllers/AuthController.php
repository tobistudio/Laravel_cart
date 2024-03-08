<?php

namespace App\Http\Controllers;

use App\Events\ForgotPasswordProcessed;
use App\Models\AuthConfirm;
use App\Models\BackendMenuItem;
use App\Models\BackendMenuItemPermission;
use App\Models\Language;
use App\Models\PasswordReset;
use App\Models\Role;
use App\Models\User;
use App\Models\UserSettings;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

class AuthController extends Controller
{
    // use AuthenticatesUsers;

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'email_required',
            'email.email' => 'email_format',
            'password.required' => 'password_required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        //get credentials from vue form/endpoint and attempt log in
        $credentials = ['email' => $request['email'], 'password' => $request['password']];
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'auth_invalid_credentials',
                'message_type' => 'login'
            ], 401);
        }

        //get authorized user instance
        $user = new User();
        $user = $user->where('email', $request['email'])->first();
        //check if user is verified, if not redirect user to confirm page and send email
        if ($user->email_verified_at === null) {
            //generate confirm data
            $confirm = $this->createAuthConfirm($user->id, AuthConfirm::TYPE_REGISTER);

            $response = $this->sendEmail($confirm, $user, 1);
            if ($response['status'] === 400) {
                $confirm->delete();
            }

            return response()->json($response['data'], $response['status']);
        }

        $user->remember_token = Str::random(20);
        $user->save();

        //create token for user
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        $token->save();

        $user = $this->getUser(false);

        //return data back for frontend handling
        return response()->json([
            'message' => 'successfully_logged_in',
            'message_type' => 'system',
            'redirect' => 'system/dashboard',
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
            'user' => $user,
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function user(): JsonResponse
    {
        $user = $this->getUser(false);

        $sidebar_menu = [];
        $_sidebar_menu = BackendMenuItem::where('parent_id', null)->with('sub:id,parent_id,icon,name,link,disabled')->orderBy('order')->get(['id', 'icon', 'parent_id', 'name', 'link', 'disabled']);

        foreach($_sidebar_menu as $item){
            $view_item = $this->permissionEdit('view', $user['role']['id'], $item->id);

            $sub_permissions = [];
            foreach($item->sub as $sub_item){
                $view_sub_item = $this->permissionEdit('view', $user['role']['id'], $sub_item->id);

                $sub_permissions[] = [
                    'id' => $sub_item->id,
                    'parent_id' => $sub_item->parent_id,
                    'icon' => $sub_item->icon,
                    'name' => $sub_item->name,
                    'link' => $sub_item->link,
                    'disabled' => $sub_item->disabled,
                    'view' => $user['role']['super'] === 1 ? 1 : ($view_sub_item->perm ? $view_sub_item->perm->allow : 0)
                ];
            }

            $sidebar_menu[] = [
                'id' => $item->id,
                'parent_id' => $item->parent_id,
                'icon' => $item->icon,
                'name' => $item->name,
                'link' => $item->link,
                'disabled' => $item->disabled,
                'view' => $user['role']['super'] === 1 ? 1 : ($view_item->perm ? $view_item->perm->allow : 0),
                'sub' => $sub_permissions
            ];
        }

        return response()->json([
            'user' => $user,
            'sidebar_menu' => $sidebar_menu,
        ]);
    }

    protected function permissionEdit($type, $role_id, $item_id)
    {
        return BackendMenuItemPermission::where('permission', $type)
            ->where('menu_item_id', $item_id)
            ->with(['perm' => function ($q) use ($role_id) {
                $q->where('role_id', $role_id);
            }])->whereHas('perm', function ($q) use ($role_id) {
                $q->where('role_id', $role_id);
            })->first();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function changeTheme(Request $request): JsonResponse
    {
        $auth_user = (new User)->where('id', Auth::id())->first();

        if($auth_user && $auth_user->administrator === 1){
            $user_settings = UserSettings::where('user_id', $auth_user->id)->first();
            $user_settings->theme = $request['theme'];
            $user_settings->save();

            return response()->json([
                'theme' => $user_settings->theme,
                'message' => 'theme_changed'
            ]);
        } else {
            return response()->json([
                'message' => 'permission_denied'
            ]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function toggleSidebar(Request $request): JsonResponse
    {
        $auth_user = (new User)->where('id', Auth::id())->first();

        if($auth_user && $auth_user->administrator === 1){
            $user_settings = UserSettings::where('user_id', $auth_user->id)->first();
            $user_settings->sidebar_collapsed = $request['sidebar_collapsed'];
            $user_settings->save();

            return response()->json([
                'sidebar_collapsed' => $user_settings->sidebar_collapsed,
                'message' => 'theme_changed'
            ]);
        } else {
            return response()->json([
                'message' => 'permission_denied'
            ]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'email_required',
            'email.email' => 'email_format',
            'email.exists' => 'email_not_exist',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = new User();
        $user = $user->where('email', $request['email'])->first();

        $password_reset = new PasswordReset();
        $password_reset = $password_reset->where('email', $user->email)->where('used', PasswordReset::NOT_USED)->where('active', PasswordReset::ACTIVE)->first();
        if ($password_reset) {
            $password_reset->active = PasswordReset::NOT_ACTIVE;
            $password_reset->save();
        }

        $token = sha1(time());

        $password_reset = new PasswordReset();
        $password_reset->email = $user->email;
        $password_reset->token = $token;
        $password_reset->created_at = Carbon::now();
        $password_reset->save();

        $response = $this->sendEmail($token, $user, 0);

        return response()->json($response['data'], $response['status']);
    }

    /**
     * @param null $user_id
     * @return array
     */
    protected function getUser($user_id = null): array
    {
        $user = new User();
        $user = $user->where('id', $user_id ?: Auth::id())->with('role:id,name,super')->first(['id', 'first_name', 'last_name', 'email', 'email_verified_at', 'role_id', 'created_at']);

        $user_settings = UserSettings::where('user_id', $user->id)->first();

        return [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at,
            'created_at' => $user->created_at,
            'role' => $user->role,
            'settings' => [
                'theme' => $user_settings->theme,
                'sidebar_collapsed' => $user_settings->sidebar_collapsed
            ]
        ];
    }

    /**
     * Logout /api/auth/logout
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'logout_success',
            'message_type' => 'login',
            'redirect' => 'system/login',
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @param Request $request
     * @return string
     */
    public function username(Request $request): string
    {
        return 'email';
    }

    /**
     * @param $token
     * @return JsonResponse
     */
    public function getResetPassword($token): JsonResponse
    {
        $reset_password = new PasswordReset();
        $reset_password = $reset_password->where('token', $token)->validToken()->first();
        if (!$reset_password) {
            return response()->json([
                'message' => 'auth_reset_password_invalid_token',
                'redirect' => 'system/login',
                'message_type' => 'login'
            ], 422);
        }

        $user = new User();
        $user = $user->where('email', $reset_password->email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'auth_reset_password_user_not_found',
                'redirect' => 'system/login',
                'message_type' => 'login'
            ], 422);
        }

        return response()->json([
            'token' => $reset_password->token,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:new_password',
        ], [
            'new_password.required' => 'new_password_is_required',
            'new_password.min' => 'new_password_min',
            'confirm_password.required' => 'confirm_password_is_required',
            'confirm_password.min' => 'confirm_password_min',
            'confirm_password.same' => 'confirm_password_not_same'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $reset_password = new PasswordReset();
        $reset_password = $reset_password->where('token', $request['token'])->validToken()->first();
        if (!$reset_password) {
            return response()->json([
                'message' => 'auth_reset_password_invalid_token',
                'message_type' => 'reset_password'
            ], 422);
        }

        $user = new User();
        $user = $user->where('email', $reset_password->email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'auth_reset_password_user_not_found',
                'message_type' => 'login'
            ], 422);
        }

        $user->password = Hash::make($request['new_password']);
        if ($user->email_verified_at === null) {
            $user->email_verified_at = Carbon::now();
        }
        $user->save();

        $reset_password->used = PasswordReset::USED;
        $reset_password->save();

        return response()->json([
            'message' => 'reset_password_successfully_changed',
            'message_type' => 'login',
            'redirect' => 'system/login',
        ]);
    }

    /**
     * @param $token
     * @param $user
     * @param $resend
     * @return array
     */
    #[ArrayShape(['data' => "array", 'status' => "int"])]
    protected function sendEmail($token, $user, $resend): array
    {
        $email_subject = 'Password recovery';
        $email_body = 'We sent code below to confirm password recovery';
        $email_body_confirm_text = 'If u closed confirm page or its no longer available, please click or copy the link below';

        $success_message = 'auth_confirm_forgot_password_confirmation_code_sent';
        $message_type = 'forgot_password';

        $footer = [
            'contact_us_text_2' => 'If you have any questions please',
            'contact_us_text_1' => 'we are always happy to help.',
            'cheers' => 'Cheers',
            'privacy_policy' => 'Privacy Policy',
            'contact_us' => 'Contact Us',
            'read_our_blog' => 'Read our Blog',
            'copyright' => 'Copyright'
        ];

        $data = [
            'subject' => $email_subject,
            'user' => [
                'name' => $user->name ?: null,
                'email' => $user->email,
            ],
            'email' => [
                'body' => $email_body,
                'body_confirm_text' => $email_body_confirm_text,
                'footer' => $footer,
                'color' => '#00B3DC',
                'app_url' => env('APP_URL'),
                'logo' => env('APP_URL') . '/images/logos/email_logo.png',
            ],
            'confirm' => [
                'url' => '/system/reset-password/' . $token,
            ],
        ];

        ForgotPasswordProcessed::dispatch($data);

        return [
            'data' => [
                'message' => $success_message,
                'message_type' => $message_type,
            ],
            'status' => 200
        ];
    }
}
