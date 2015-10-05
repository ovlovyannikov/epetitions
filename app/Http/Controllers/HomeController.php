<?php

namespace Mygov\Http\Controllers;

use Auth;
use DB;
use Mygov\Models\Petition;
use Mygov\Models\User;
use Bican\Roles\Models\Role;

class HomeController extends Controller
{
	public function index()
	{



		$petitions = DB::table('mg_petitions')
							 ->select(DB::raw('case when (' . env('DAYS_REVIEW') . ' - datediff(now(),created_at))<0 then 0 else (' . env('DAYS_REVIEW') . ' - datediff(now(),created_at)) end as days,title, body,created_at,id,
							 (Select Count(*) From mg_signs where mg_petitions.id = mg_signs.signable_id) as count_signs' ))
							 /*->where(DB::raw( '90 - datediff(now(),created_at)' ),'>','0')*/
							 ->where('check', 1)
							 ->orderBy('created_at','desc')
							 ->paginate(env('ITEMS_ON_PAGE'));


		if(Auth::user()) {
					 			$user = Auth::user();
								if ($user->is('moderator')) {
										$petitions = DB::table('mg_petitions')
													 ->select(DB::raw('case when (' . env('DAYS_REVIEW') . ' - datediff(now(),created_at))<0 then 0 else (' . env('DAYS_REVIEW') . ' - datediff(now(),created_at)) end as days,title, body,created_at,id,
													 (Select Count(*) From mg_signs where mg_petitions.id = mg_signs.signable_id) as count_signs' ))
													 /*->where(DB::raw( '90 - datediff(now(),created_at)' ),'>','0')*/
													 ->where('check', 0)
													 ->orderBy('created_at','desc')
													 ->paginate(env('ITEMS_ON_PAGE'));
								}
		}







		/*$pet = Petition::find($petitionId);*/

		/*$adminRole = Role::create([
    'name' => 'Admin',
    'slug' => 'admin',
    'description' => '',
    'level' => 1,
		]);

		$moderatorRole = Role::create([
    'name' => 'Moderator',
    'slug' => 'moderator',
		]);*/

		return view('petition.index')
			->with('petitions',$petitions );
	}




}
