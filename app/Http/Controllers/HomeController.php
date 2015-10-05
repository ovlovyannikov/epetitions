<?php

namespace Mygov\Http\Controllers;

use Auth;
use DB;
use Mygov\Models\Petition;

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

		/*$pet = Petition::find($petitionId);*/

		return view('petition.index')
			->with('petitions',$petitions );
	}




}
