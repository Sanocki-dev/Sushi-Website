<?php

namespace App\Http\Controllers;

use App\Promotions;
use Illuminate\Http\Request;

use App\User;

/**
 * User Registration Controller that will handle interactions of user login/signup
 */
class RegistrationController extends Controller
{
	/**
	 * Creates a new session when the user logs in
	 */
	public function create()
	{
		return view('sessions.create');
	}

	/**
	 * Stores the user information with validation in the table
	 */
	public function store()
	{
		// Server side validation of the form 
		$this->validate(request(), [
			'name' => 'required|min:3',
			'email' => 'required|unique:tbl_users,email|email',
			'phone' => 'required|regex:/[0-9]{10}/',
			'password' => 'required|confirmed|min:8',
		]);
		
		// Creates the user in the table
		$user = User::create(request(['email', 'password', 'name', 'phone']));

		// Logs in the user and redirects to index page
		auth()->login($user);
		return redirect()->home();
	}
}
