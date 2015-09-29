<?php

namespace Mygov\Http\Controllers;

use Illuminate\Http\Request;
use Mygov\Models\Petition;
use DB;

class SearchController extends Controller
{
	public function getResults(Request $request)
	{
		$query = $request->input('query');

		if (!$query) {
			return redirect()->route('home');
		}


		$petitions = DB::table('mg_petitions')
									 ->select(DB::raw('case when (30 - datediff(now(),created_at))<0 then 0 else (30 - datediff(now(),created_at)) end as days,title, body,created_at,id,
									 (Select Count(*) From mg_signs where mg_petitions.id = mg_signs.signable_id) as count_signs' ))
									 ->where('check', 1)
									 ->where('title', 'LIKE', "%{$query}%")
									 ->orWhere('body', 'LIKE', "%{$query}%")
									 ->orderBy('created_at','desc')
									 ->get();

		return view('search.results')->with('petitions', $petitions);
	}


}
