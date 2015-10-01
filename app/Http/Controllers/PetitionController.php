<?php

namespace Mygov\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;
use Mygov\Models\User;
use Mygov\Models\Petition;
use Mygov\Models\Sign;

class PetitionController extends Controller
{
	public function postPetition(Request $request)
	{
		$this->validate($request,[
			'title' => 'required|max:255',
			'body' => 'required',
			/*'g-recaptcha-response' => 'required|captcha',*/
			]);

			Petition::create([
				'title' => $request->input('title'),
				'body' => $request->input('body'),
				'status' => '1',
				'check' => '0',
				'user_id' => Auth::user()->id,
			]);

			return redirect()
				->route('home')
				->with('info','Петицію додано! Після перевірки вона з’явиться на сайті.');
	}

	public function getPetition()
	{

			return view('petition.add');
	}

	public function getItem($petitionId)
	{
			$petition = DB::table('mg_petitions')
				->join('mg_users', 'mg_petitions.user_id', '=', 'mg_users.id')
										 ->select(DB::raw('case when (30 - datediff(now(),mg_petitions.created_at))<0 then 0 else (30 - datediff(now(),mg_petitions.created_at)) end as days,title, mg_petitions.user_id,body,
										 concat(mg_users.first_name, " ", mg_users.middle_name, " ", mg_users.last_name) as author,
										 CASE status WHEN 1 THEN "триває збір підписів"
       			 				WHEN 2 THEN "на розгляді" ELSE "з відповіддю"
                     END as status_name,mg_petitions.created_at,mg_petitions.id,answer'))
                     ->where('mg_petitions.id', $petitionId)
                     ->first();
			$signs = DB::table('mg_signs')
				->join('mg_users', 'mg_signs.user_id', '=', 'mg_users.id')
				->select(DB::raw('concat(mg_users.first_name, " ", mg_users.middle_name, " ", mg_users.last_name) as author, user_id, mg_signs.created_at'))
				->where('mg_signs.signable_id', $petitionId)
				->get();

			$pet = Petition::find($petitionId);

			return view('petition.item')
				->with('count_signs',$pet->signs()->count())
				->with('signs',$signs)
				->with('petition',$petition );
	}

	public function getSign($petitionId)
	{
				$petition = Petition::find($petitionId);

				if (!$petition) {
					return redirect()->route('home');
				}

				if (Auth::user()->hasSignPetition($petition)) {					
					return redirect()->back()->with('info','Ви вже підписали!');;
				}

				$sign = $petition->signs()->create([]);
				Auth::user()->signs()->save($sign);

				return redirect()->back()->with('info','Вітаю. Ви підписали петицію!' );
	}

	public function getPetsByStatus($statusId)
	{
			$petitions = DB::table('mg_petitions')
										 ->select(DB::raw('case when (30 - datediff(now(),created_at))<0 then 0 else (30 - datediff(now(),created_at)) end as days,title,
										 (Select Count(*) From mg_signs where mg_petitions.id = mg_signs.signable_id) as count_signs,
										 created_at,id,status'))
                     ->where('status', $statusId)
										 ->where('check', 1)
                     ->get();

			return view('petition.index')
				->with('petitions',$petitions );
	}

}
