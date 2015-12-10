<?php

namespace Mygov\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Mygov\Models\User;

class ProfileController extends Controller
{
	public function getProfile($username)
	{
			$user = User::where('username',$username)->first();

			if(!$user) {
					abort(404);
			}

			$statuses = $user->statuses()->notReply()->get();

			return view('profile.index')
					->with('user', $user)
					->with('statuses', $statuses)
					->with('authUserIsFriend', Auth::user()->isFriendWith($user));
	}

	public function getEdit()
	{
		return view('profile.edit');
	}

	public function postEdit(Request $request)
	{
		$this->validate($request, [
				'first_name'=> 'max:50',
				'last_name'=> 'max:50',
				'middle_name'=> 'max:50',
				'email'	 => 'required|email|max:255',
				'phone' => 'required|unique:mg_users|max:10|digits:10',
			]);

			Auth::user()->update([
					'first_name'=> $request->input('first_name'),
					'middle_name'=> $request->input('middle_name'),
					'last_name'=> $request->input('last_name'),
					'email'=> $request->input('email'),
					'phone'=> $request->input('phone'),					
				]);

				return redirect()
					->route('profile.edit')
					->with('info','Профіль оновлено');
	}
}
