<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\RegisterRequest;
use App\Http\Resources\Website\CategoryResource;
use App\Http\Resources\Website\AreaResource;
use App\Http\Resources\Website\CountryResource;
use App\Models\Area;
use App\Models\Category;
use App\Models\CompanyProfile;
use App\Models\Country;
use App\Models\PersonProfile;
use App\Models\StudioProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RegisterController extends Controller
{

    public function index()
    {
        return view('website.register');
    }

    public function login()
    {
        return view('website.login');
    }

    public function profile(Request $request)
    {
        $user = auth('user')->user();

        return view('website.profile', compact('user'));
    }


    public function getCategoriesOfParticipation()
    {
        $categories = Category::whereStatus(1)->latest()->get();
        return responseJson(CategoryResource::collection($categories),'',200);
    }

    public function getAreas()
    {
        $areas = Area::whereStatus(1)->latest()->get();
        return responseJson(AreaResource::collection($areas),'',200);
    }

    public function getCountries()
    {
        $countries = Country::whereStatus(1)->latest()->get();
        return responseJson(CountryResource::collection($countries),'',200);
    }

    /**
     * Register a new user account
     *
     * Supports three user types: person, company, studio
     * Creates user record and corresponding profile based on user_type
     * Handles file uploads for ID cards and business documents
     */
    public function register(RegisterRequest $request){
        try {
            DB::beginTransaction();

            // Create user with common fields
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'whatsapp' => $request->whatsapp,
                'password' => bcrypt($request->password),
                'user_type' => $request->user_type,
                'how_did_you_hear_about_us' => $request->how_did_you_hear_about_us,
            ];

            $user = User::create($userData);

            DB::commit();

            // Login user after successful registration
            auth('user')->login($user);

            // Mail::to($user->email)->send(new NewRegisterMail($user->name));
            return responseJson($user, __('messages.Created Successfully'), 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return responseJson(null, __('messages.Database error'), 500);
        }
    }

    public function logout(){
        auth('user')->logout();
        return redirect()->route('web.home');
    }

    /**
     * Handle user login form submission
     *
     * Validates credentials and logs in the user
     * Supports remember me functionality
     */
    public function loginForm(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
            'remember_me' => 'nullable|boolean',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember_me', false);

        if (auth('user')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            session()->flash('success', __('messages.Logged in Successfully'));
            return responseJson(auth('user')->user(), __('messages.Logged in Successfully'), 200);
        }

        session()->flash('error', __('messages.Invalid Credentials'));
        return responseJson(null, __('messages.Invalid Credentials'), 400);
    }
    /**
     * Show forgot password page
     */
    public function forgot()
    {
        return view('website.forgot');
    }

    /**
     * Send password reset link to user's email
     *
     * Uses Laravel's built-in password reset system
     * Sends email with reset link containing token
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Generate password reset token using Laravel's Password broker
        $status = Password::broker('users')->sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return responseJson(null, __('passwords.sent'), 200);
        }

        return responseJson(null, __('passwords.user'), 400);
    }

    /**
     * Show password reset form
     *
     * Displays form where user can enter new password
     * Token is validated before showing the form
     */
    public function showResetForm(Request $request)
    {
        // Get token and email from query parameters
        $token = $request->query('token');
        $email = $request->query('email');

        // Validate token and email exist
        if (!$token || !$email) {
            return redirect()->route('web.forgot')->with('error', __('passwords.token'));
        }

        return view('website.reset-password', [
            'token' => $token,
            'email' => $email
        ]);
    }

    /**
     * Reset user's password
     *
     * Validates token and updates password
     * Logs user in automatically after successful reset
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|max:50|confirmed',
        ]);

        // Reset password using Laravel's Password broker
        $status = Password::broker('users')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->setRememberToken(Str::random(60));
                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            // Login user automatically after password reset
            $user = User::where('email', $request->email)->first();
            if ($user) {
                auth('user')->login($user);
            }

            return responseJson($user, __('passwords.reset'), 200);
        }

        // Handle different error statuses
        $errorMessage = __('passwords.token');
        if ($status === Password::INVALID_USER) {
            $errorMessage = __('passwords.user');
        } elseif ($status === Password::INVALID_TOKEN) {
            $errorMessage = __('passwords.token');
        }

        return responseJson(null, $errorMessage, 400);
    }




}

