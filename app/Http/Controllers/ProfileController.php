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
				'email'	 => 'required|unique:mg_users|email|max:255',
			]);

			Auth::user()->update([
					'first_name'=> $request->input('first_name'),
					'middle_name'=> $request->input('middle_name'),
					'last_name'=> $request->input('last_name'),
					'email'=> $request->input('email'),
				]);

				return redirect()
					->route('profile.edit')
					->with('info','Профіль оновлено');
	}
}
