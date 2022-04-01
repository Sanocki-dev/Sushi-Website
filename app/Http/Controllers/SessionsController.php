<?php

namespace App\Http\Controllers;

use App\Promotions;
use Illuminate\Http\Request;

/**
 * Handles the user session for the website
 */
class SessionsController extends Controller
{
	/**
	 * Default constructor creating a session for guest users
	 */ 
	public function __construct()
	{
		$this->middleware('guest', ['except' => 'destroy']);
	}

	/**
	 * Creates the session for user login
	 */
    public function create()
    {
    	return view('sessions.login');
    }

	/**
	 * Tries to log in user to site using validation
	 */
    public function store()
   	{
		// Validation required for sign up
		$this->validate(request(), [
			'email' => 'required|email',
			'password' => 'required',
		]);

		// Tries to log user in with entered information 
   		if (! auth()->attempt(request(['email', 'password']))) {
			// Redirect with error if invalid
   			return back()->with->withErrors('Incorrect Login Information!');
   		}
   		return redirect()->home();
   	}

	/**
	 * Destorys the session once the user logs out
	 */
    public function destroy()
    {
    	auth()->logout();
    	return redirect()->home();
    }   

	/**
	 * Sends the user to the forgot password page
	 */
    public function forgotPassword()
    {
        return view('sessions.forgotPassword');
    }   
}
