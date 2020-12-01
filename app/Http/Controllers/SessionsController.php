<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionsController extends Controller
{
	public function __construct()
	{
		$this->middleware('guest', ['except' => 'destroy']);
	}

    public function create()
    {
    	return view('sessions.login');
    }

    public function store()
   	{
   		if (! auth()->attempt(request(['email', 'password']))) {

   			return back();

   		}

   		return redirect()->home();
   	}

    public function destroy()
    {
    	auth()->logout();

    	return redirect()->home();
    }   

    public function forgotPassword()
    {
        return view('sessions.forgotPassword');
    }   
}
