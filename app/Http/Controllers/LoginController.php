<?php

namespace Mygov\Http\Controllers;

class LoginController extends Controller
{

	public function getLoginFacebook($auth=NULL)
	{
		if($auth=='auth') 
		{
			try {
				\Hybrid_Endpoint::process();
				} 
			catch (Exception $e) {
				return Redirect::to("home");
			}
			return;
		}
		
		$config= array(
			"base_url" => "http://laravel/public/",
			"providers" => array (
				"Facebook" => array (
					"enabled" => true,
					"keys" => array ( "id" => "488919314589569", "secret" => "2b8ab46fece7bef72c48abe0eaa664d0" ),
					"scope" => "public_profile,email", // optional
					"display" => "popup" // optional
					)
			)
		);
		
		$oauth=new \Hybrid_Auth($config);
		$provider=$oauth->authenticate("Facebook");
		$profile=$provider->getUserProfile();
		var_dump($profile);
		echo "FirstName:".$profile->firstName."<br>";
		echo "Email:".$profile->email;
		echo "<br><a href='logout'>Logout</a> ";
	}
	
	public function logout()
	{
		$oauth=new \Hybrid_Auth(base_path().'/app/config/fb_Auth.php');
		$oauth->logoutAllProviders();
		Session::flush();
		Auth::logout();
		return Redirect::to("home");
	}
}