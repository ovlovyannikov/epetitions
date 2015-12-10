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

		$pets_by_status = DB::table('mg_petitions')
		->select(DB::raw('(Select Count(*) From mg_petitions where status=1 and checked=1) as s_1,
	 	(Select Count(*) From mg_petitions where status=2 and checked=1) as s_2,
	 	(Select Count(*) From mg_petitions where status=3 and checked=1) as s_3' ))
		->first();

		$petitions = DB::table('mg_petitions')
							 ->select(DB::raw('case when (' . env('DAYS_REVIEW') . ' - datediff(now(),created_at))<0 then 0 else (' . env('DAYS_REVIEW') . ' - datediff(now(),created_at)) end as days,title,done, body,created_at,id,
							 (Select Count(*) From mg_signs where mg_petitions.id = mg_signs.signable_id) as count_signs' ))
							 ->where('status', 1)
							 ->where('checked', 1)
							 ->orderBy('created_at','desc')
							 ->paginate(env('ITEMS_ON_PAGE'));


		if(Auth::user()) {
					 			$user = Auth::user();
								if ($user->is('moderator')) {
										$petitions = DB::table('mg_petitions')
													 ->select(DB::raw('case when (' . env('DAYS_REVIEW') . ' - datediff(now(),created_at))<0 then 0 else (' . env('DAYS_REVIEW') . ' - datediff(now(),created_at)) end as days,title,done, body,created_at,id,
													 (Select Count(*) From mg_signs where mg_petitions.id = mg_signs.signable_id) as count_signs' ))
													 /*->where(DB::raw( '90 - datediff(now(),created_at)' ),'>','0')*/
													 ->where('checked', 0)
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
			->with('petitions',$petitions )
			->with('pets_by_status',$pets_by_status);
	}




}
