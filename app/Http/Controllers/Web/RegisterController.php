<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\RegisterRequest;
use App\Http\Resources\Website\CategoryResource;
use App\Http\Resources\Website\AreaResource;
use App\Http\Resources\Website\CountryResource;
use App\Models\Area;
use App\Models\Category;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;

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

    public function register(RegisterRequest $request){
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'email' => $request->email,
        ]);
        auth('user')->login($user);
        // Mail::to($user->email)->send(new NewRegisterMail($user->name));
        return responseJson($user,__('messages.Created Successfully'),200);
    }

    public function logout(){
        auth('user')->logout();
        return redirect()->route('web.home');
    }

    public function loginForm(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (auth('user')->attempt($credentials)) {
            $request->session()->regenerate();
            session()->flash('success', __('messages.Logged in Successfully'));
            return responseJson(auth('user')->user(),__('messages.Logged in Successfully'),200);
        }
        session()->flash('error', __('messages.Invalid Credentials'));
        return responseJson(null,__('messages.Invalid Credentials'),400);

    }

}

