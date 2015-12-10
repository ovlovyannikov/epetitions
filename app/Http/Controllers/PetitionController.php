<?php

namespace Mygov\Http\Controllers;

use Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
			'g-recaptcha-response' => 'required|captcha',
			]);

			$num = DB::table('mg_petitions')
						->select(DB::raw('IFNULL(MAX(num),0)+1 as num'))
						->where(DB::raw('YEAR(created_at)'), date('Y'))
						->first();

			Petition::create([
				'title' => $request->input('title'),
				'body' => $request->input('body'),
				'status' => '1',
				'check' => '0',
				'done' => '0',
				'user_id' => Auth::user()->id,
				'num' => $num->num
			]);

			Mail::send('home' ,['name' => 'Ispolkom'], function ($message)
				{
					$message->to('iv.kurtova@rada-berdyansk.gov.ua', 'Ispolkom')->cc('ov.lovyannikov@gmail.com')->subject('Додано нову петицію');
				}
			);

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
										 ->select(DB::raw('case when (' . env('DAYS_REVIEW') . ' - datediff(now(),mg_petitions.created_at))<0 then 0 else (' . env('DAYS_REVIEW') . ' - datediff(now(),mg_petitions.created_at)) end as days,title, mg_petitions.user_id,body,
										 concat(mg_users.first_name, " ", mg_users.middle_name, " ", mg_users.last_name) as author,
										 phone,email,num,done,
										 (Select Count(*) From mg_signs where mg_petitions.id = mg_signs.signable_id) as count_signs,
										 CASE status WHEN 1 THEN "триває збір підписів"
       			 				WHEN 2 THEN "на розгляді" ELSE "з відповіддю"
                     END as status_name,mg_petitions.created_at,mg_petitions.id,answer,mg_petitions.checked,mg_petitions.status'))
                     ->where('mg_petitions.id', $petitionId)
                     ->first();
			$signs = DB::table('mg_signs')
				->join('mg_users', 'mg_signs.user_id', '=', 'mg_users.id')
				->select(DB::raw('concat(mg_users.first_name, " ", mg_users.middle_name, " ", mg_users.last_name) as author, mg_signs.id as sign_id, phone, email, user_id, mg_signs.created_at'))
				->where('mg_signs.signable_id', $petitionId)
				->get();

			return view('petition.item')
				->with('signs',$signs)
				->with('petition',$petition );
	}

	public function createPDF($petitionId)
	{
			$petition = DB::table('mg_petitions')
				->join('mg_users', 'mg_petitions.user_id', '=', 'mg_users.id')
										 ->select(DB::raw('case when (' . env('DAYS_REVIEW') . ' - datediff(now(),mg_petitions.created_at))<0 then 0 else (' . env('DAYS_REVIEW') . ' - datediff(now(),mg_petitions.created_at)) end as days,title, mg_petitions.user_id,body,
										 concat(mg_users.first_name, " ", mg_users.middle_name, " ", mg_users.last_name) as author,
										 phone,email,num,
										 (Select Count(*) From mg_signs where mg_petitions.id = mg_signs.signable_id) as count_signs,
										 CASE status WHEN 1 THEN "триває збір підписів"
										WHEN 2 THEN "на розгляді" ELSE "з відповіддю"
										 END as status_name,mg_petitions.created_at,mg_petitions.id,answer,mg_petitions.checked,mg_petitions.status'))
										 ->where('mg_petitions.id', $petitionId)
										 ->first();

			$data =['petition' => $petition];
			$pdf = \PDF::loadView('petition.itempdf', $data);
			return $pdf->stream();
	}

	public function createPDFZG($petitionId)
	{
			$petition = DB::table('mg_petitions')
				->join('mg_users', 'mg_petitions.user_id', '=', 'mg_users.id')
										 ->select(DB::raw('case when (' . env('DAYS_REVIEW') . ' - datediff(now(),mg_petitions.created_at))<0 then 0 else (' . env('DAYS_REVIEW') . ' - datediff(now(),mg_petitions.created_at)) end as days,title, mg_petitions.user_id,body,
										 concat(mg_users.first_name, " ", mg_users.middle_name, " ", mg_users.last_name) as author,
										 phone,email,num,
										 (Select Count(*) From mg_signs where mg_petitions.id = mg_signs.signable_id) as count_signs,
										 CASE status WHEN 1 THEN "триває збір підписів"
										WHEN 2 THEN "на розгляді" ELSE "з відповіддю"
										 END as status_name,mg_petitions.created_at,mg_petitions.id,answer,mg_petitions.checked,mg_petitions.status'))
										 ->where('mg_petitions.id', $petitionId)
										 ->first();

			$data =['petition' => $petition];
			$pdf = \PDF::loadView('petition.itemzgpdf', $data);
			return $pdf->stream();
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

	public function delSign($signId)
	{
				$sign = Sign::find($signId);
				$sign->delete();
				return redirect()->back()->with('info','Підпис вилучено!');
	}

	public function getPetsByStatus($statusId,$orderId)
	{

			$pets_by_status = DB::table('mg_petitions')
		->select(DB::raw('(Select Count(*) From mg_petitions where status=1 and checked=1) as s_1,
	 	(Select Count(*) From mg_petitions where status=2 and checked=1) as s_2,
	 	(Select Count(*) From mg_petitions where status=3 and checked=1) as s_3' ))
		->first();

		if ($orderId == 'desc')
				$field_order = 'count_signs';
		else
				$field_order =  'created_at';

			$petitions = DB::table('mg_petitions')
										 ->select(DB::raw('case when (' . env('DAYS_REVIEW') . ' - datediff(now(),created_at))<0 then 0 else (' . env('DAYS_REVIEW') . ' - datediff(now(),created_at)) end as days,title,done,
										 (Select Count(*) From mg_signs where mg_petitions.id = mg_signs.signable_id) as count_signs,
										 created_at,id,status'))
                     ->where('status', $statusId)
					 				 	 ->where('checked', 1)
					 				 	 ->orderBy($field_order,'desc')
                     ->paginate(env('ITEMS_ON_PAGE'));

			return view('petition.index')
				->with('petitions',$petitions )
				->with('pets_by_status',$pets_by_status);
	}

	public function petitionEdit(Request $request, $petitionId)
	{
		$this->validate($request, [
				'checked'=> 'required',
			]);

			$petition = Petition::find($petitionId);
			$petition->checked = $request->input('checked');
			$petition->answer = $request->input('answer');
			$petition->status = $request->input('status');
			$petition->done = $request->input('done');

			if ($petition->checked == 1 && $petition->status == 1)
			{
					$petition->created_at = Carbon::now();
			}
			$petition->save();

				return redirect()
					->back()
					->with('info','Петиція перевірена (або додано відповідь, або оновлено статус)!' );;
	}


}
