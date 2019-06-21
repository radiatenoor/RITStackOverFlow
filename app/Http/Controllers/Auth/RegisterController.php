<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
//    protected function validator(array $data)
//    {
//        return Validator::make($data, [
//            'name' => ['required', 'string', 'max:255'],
//            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
//            'password' => ['required', 'string', 'min:6', 'confirmed'],
//        ]);
//    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
//    protected function create(array $data)
//    {
//        return Admin::create([
//            'name' => $data['name'],
//            'email' => $data['email'],
//            'password' => Hash::make($data['password']),
//        ]);
//    }

    public function showRegistrationForm()
    {

        return view('front/auth/register');
    }

    public function userRegister(Request $request){
         $this->validate($request,[
            'name'=>'required|min:6',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6',
            'title'=>'required',
            'location'=>'required'
        ]);

         // save data in database
         $user = new User();
         $user->name = $request->name;
         $user->email = $request->email;
         //$user->password = bcrypt($request->password);
         $user->password = Hash::make($request->password);
         $user->title = $request->title;
         $user->location = $request->location;
         $user->active = 1;
         $user->save();


         Session::flash('success','You Have Successfully Register');
         return redirect()->back();
     }
}
