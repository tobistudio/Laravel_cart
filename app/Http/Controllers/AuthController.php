<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailVerifiedMail;
use App\Jobs\SendRemindPasswordMail;
use App\Models\AuthConfirm;
use App\Models\BackendMenuItem;
use App\Models\BackendMenuItemPermission;
use App\Models\PasswordReset;
use App\Models\User;
use App\Models\UserSettings;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

class AuthController extends Controller
{
    // use AuthenticatesUsers;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function customerRegister(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'confirmed',
                Password::min(8),
                'regex:/[a-z]/', // at least one lowercase letter
                'regex:/[A-Z]/', // at least one uppercase letter
                'regex:/[0-9]|[@$!%*?&#]/', // at least one digit or 1 special character
            ],
            'password_confirmation' => 'required',
        ], [
            'name.required' => 'name_required',
            'email.required' => 'email_required',
            'email.email' => 'email_format',
            'email.unique' => 'email_unique',
            'password.required' => 'password_required',
            'password.confirmed' => 'password_does_not_match',
            'password.min' => 'password_strength',
            'password.regex' => 'password_strength',
            'password_confirmation.required' => 'password_confirmation_required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = new User();
        $user->first_name = $request['name'];
        $user->email = $request['email'];
        $user->password = Hash::make($request['password']);
        $user->email_verification_token = sha1(time());
        $user->save();

        $response = $this->sendEmail('register', $user->email_verification_token, $user, 1);

        return response()->json($response['data'], $response['status']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function customerLogin(Request $request): JsonResponse
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

        $admin_user = (New User)->where('email', $request['email'])->where('administrator', 1)->first();
        if ($admin_user) {
            return response()->json(['errors' => [
                'email' => [
                    'not_customer'
                ]
            ]], 422);
        }

        //get credentials from vue form/endpoint and attempt log in
        $credentials = ['email' => $request['email'], 'password' => $request['password']];
        if (!Auth::attempt($credentials)) {
            return response()->json(['errors' => [
                'email' => [
                    'auth_invalid_credentials'
                ]
            ]], 422);
        }

        //get authorized user instance
        $user = new User();
        $user = $user->where('email', $request['email'])->first();
        //check if user is verified, if not redirect user to confirm page and send email
//        if ($user->email_verified_at === null) {
//            $response = $this->sendEmail($confirm, $user, 1);
//            if ($response['status'] === 400) {
//                $confirm->delete();
//            }
//
//            return response()->json($response['data'], $response['status']);
//        }

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
            'message_type' => 'front',
            'redirect' => '/profils',
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
            'user' => $user,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function customerRemindPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'email_required',
            'email.email' => 'email_format',
            'email.exists' => 'user_not_exists',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = (new User)->where('email', $request['email'])->first();

        $password_reset = (new PasswordReset)->where('email', $user->email)->where('used', 0)->where('active', 1)->first();
        if(!$password_reset) {
            $password_reset = new PasswordReset();
            $password_reset->email = $user->email;
            $password_reset->token = sha1(time());
            $password_reset->active = true;
            $password_reset->created_at = Carbon::now();
            $password_reset->save();
        }

        $response = $this->sendEmail('remind_password', $password_reset->token, $user, 1);

        return response()->json($response['data'], $response['status']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function customerResetPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'new_password' => [
                'required',
                'confirmed',
                Password::min(8),
                'regex:/[a-z]/', // at least one lowercase letter
                'regex:/[A-Z]/', // at least one uppercase letter
                'regex:/[0-9]|[@$!%*?&#]/', // at least one digit or 1 special character
            ],
            'new_password_confirmation' => 'required',
        ], [
            'token.required' => 'token_required',
            'new_password.required' => 'password_required',
            'new_password.confirmed' => 'password_does_not_match',
            'new_password.min' => 'password_strength',
            'new_password.regex' => 'password_strength',
            'new_password_confirmation.required' => 'password_confirmation_required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $password_reset = (new PasswordReset)->where('token', $request['token'])->where('used', 0)->where('active', 1)->first();
        if($password_reset) {
            $user = (new User)->where('email', $password_reset->email)->first();
            $user->password = Hash::make($request['password']);
            $user->save();

            $password_reset->used = 1;
            $password_reset->active = 0;
            $password_reset->save();
        }

        return response()->json([
            'message' => 'password_successfully_reset',
            'message_type' => 'front',
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function customer(): JsonResponse
    {
        $user = $this->getUser(false);

        return response()->json([
            'user' => $user
        ]);
    }

    /**
     * Logout /api/auth/logout
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function customerLogout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'logout_success',
            'message_type' => 'front',
            'redirect' => '/',
        ]);
    }

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

        $admin_user = (New User)->where('email', $request['email'])->where('administrator', 1)->first();
        if (!$admin_user) {
            return response()->json([
                'message' => 'not_admin',
                'message_type' => 'front'
            ], 401);
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

    /**
     * @param $type
     * @param $role_id
     * @param $item_id
     * @return mixed
     */
    protected function permissionEdit($type, $role_id, $item_id): mixed
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
        $user = $user->where('id', $user_id ?: Auth::id())->with('role:id,name,super')->first(['id', 'first_name', 'last_name', 'email', 'email_verified_at', 'administrator', 'role_id', 'created_at']);

        if($user->administrator === User::ADMINISTRATOR) {
            $user_settings = UserSettings::where('user_id', $user->id)->first();
            $user_settings = [
                'theme' => $user_settings->theme,
                'sidebar_collapsed' => $user_settings->sidebar_collapsed
            ];
        }

        return [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at,
            'created_at' => $user->created_at,
            'role' => $user->role,
            'settings' => $user_settings ?? null
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
            'new_password' => [
                'required',
                'confirmed',
                Password::min(8),
                'regex:/[a-z]/', // at least one lowercase letter
                'regex:/[A-Z]/', // at least one uppercase letter
                'regex:/[0-9]|[@$!%*?&#]/', // at least one digit or 1 special character
            ],
            'new_password_confirmation' => 'required',
        ], [
            'new_password.required' => 'password_required',
            'new_password.confirmed' => 'password_does_not_match',
            'new_password.min' => 'password_strength',
            'new_password.regex' => 'password_strength',
            'new_password_confirmation.required' => 'password_confirmation_required',
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
     * @param $user_id
     * @param $type
     * @return AuthConfirm
     * @throws Exception
     */
    protected function createAuthConfirm($user_id, $type): AuthConfirm
    {
        $confirm = new AuthConfirm();
        $confirm = $confirm->where('user_id', $user_id)->where('type', $type)->where('used', AuthConfirm::NOT_USED)->where('active', AuthConfirm::ACTIVE)->first();
        if ($confirm) {
            if ($confirm->type === AuthConfirm::TYPE_REGISTER) {
                $confirm->code = random_int(0, 9) . random_int(0, 9) . random_int(0, 9) . random_int(0, 9) . random_int(0, 9) . random_int(0, 9);
                $confirm->save();

                return $confirm;
            }

            $confirm->active = AuthConfirm::NOT_ACTIVE;
            $confirm->save();
        }

        $confirm = new AuthConfirm();
        $confirm->user_id = $user_id;
        $confirm->type = $type;
        $confirm->token = sha1(time());
        $confirm->code = random_int(0, 9) . random_int(0, 9) . random_int(0, 9) . random_int(0, 9) . random_int(0, 9) . random_int(0, 9);
        $confirm->save();

        return $confirm;
    }

    /**
     * @param $type
     * @param $token
     * @param $user
     * @return array
     */
    #[ArrayShape(['data' => "array", 'status' => "int"])]
    protected function sendEmail($type, $token, $user): array
    {
        if($type === 'register'){
            $email_subject = 'E-pasta verifikācija';
            $email_body = 'Lūdzu piespiediet uz linka zemāk lai apstiprinātu E-pastu.';
            $confirm_button_text = 'APSTIPRINĀT E-PASTU';
            $confirm_url = '/?emailVerificationToken=';
            $success_message = 'successfully_registered';
            $message_type = 'front';
        } else if($type === 'remind_password'){
            $email_subject = 'Paroles atgūšana';
            $email_body = 'Lūdzu piespiediet uz linka zemāk lai turpinātu paroles atgūšanas procesu.';
            $confirm_button_text = 'MAINĪT PAROLI';
            $confirm_url = '/?passwordResetToken=';
            $success_message = 'successfully_reminded_password';
            $message_type = 'front';
        } else {
            return [
                'data' => [
                    'message' => 'something_went_wrong',
                    'message_type' => 'front',
                ],
                'status' => 500
            ];
        }


//        $footer = [
//            'contact_us_text_2' => 'If you have any questions please',
//            'contact_us_text_1' => 'we are always happy to help.',
//            'cheers' => 'Cheers',
//            'privacy_policy' => 'Privacy Policy',
//            'contact_us' => 'Contact Us',
//            'read_our_blog' => 'Read our Blog',
//            'copyright' => 'Copyright'
//        ];

        $data = [
            'subject' => $email_subject,
            'user' => [
                'name' => $user->name ?: null,
                'email' => $user->email,
            ],
            'email' => [
                'title' => $email_subject,
                'body' => $email_body,
//                'body_confirm_text' => $email_body_confirm_text,
//                'footer' => $footer,
                'color' => '#00B3DC',
                'app_url' => env('APP_URL'),
                'logo' => env('APP_URL') . '/images/front/email-logo.png',
            ],
            'confirm' => [
                'button_text' => $confirm_button_text,
                'url' => env('APP_URL') . $confirm_url . $token,
            ],
        ];

        if($type === 'register'){
            SendEmailVerifiedMail::dispatch($data);
        } else if($type === 'remind_password'){
            SendRemindPasswordMail::dispatch($data);
        }


        //TODO: REMOVE THIS TIS LATER
        $test = $token;

        return [
            'data' => [
                'message' => $success_message,
                'message_type' => $message_type,
                //        TODO: REMOVE THIS TIS LATER
                'test' => $test,
            ],
            'status' => 200
        ];
    }
}
