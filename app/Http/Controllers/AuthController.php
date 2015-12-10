<?php

namespace Mygov\Http\Controllers;

use Auth;
use Mygov\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
	public function getSignup()
	{
		return view('auth.signup');
	}

	public function postSignup(Request $request)
	{
		$this->validate($request,[
			'first_name' => 'required|max:255',
			'middle_name' => 'required|max:255',
			'last_name' => 'required|max:255',
			'g-recaptcha-response' => 'required|captcha',
			'email'	 => 'required|unique:mg_users|email|max:255',
			'password' => 'required|min:6',			
			'password_confirm' => 'required|min:6|same:password',
			'phone' => 'required|unique:mg_users|max:10|digits:10',
			'organization' => 'max:255',
			]);

			User::create([
				'email' => $request->input('email'),
				'first_name' => $request->input('first_name'),
				'middle_name' => $request->input('middle_name'),
				'last_name' => $request->input('last_name'),
				'password' => bcrypt($request->input('password')),
				'phone'=> $request->input('phone'),
				'pd'=> $request->input('pd'),
				'organization'=> $request->input('organization'),
			]);

			return redirect()
				->route('auth.signin')
				->with('info','Ваш акаунт створено. Зараз ви можете увійти.');
	}

	public function getSignin()
	{
		return view('auth.signin');
	}

	public function postSignin(Request $request)
	{
		$this->validate($request,[
			'email' => 'required',
			'password' => 'required',
			]);

		if (!Auth::attempt($request->only(['email', 'password']), $request->has('remember') )) {
			return redirect()
				->back()
				->with('info','Невірно введено логін або електронна пошта.');
		}

		return redirect()->route('home')->with('info','Ви увійшли.');

	}

	public function getSignout()
	{
		Auth::logout();
		return redirect()->route('home');
	}

}
