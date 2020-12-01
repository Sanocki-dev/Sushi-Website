<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class RegistrationController extends Controller
{
    public function create()
    {
    	return view('sessions.create');
    }

    public function store()
    {
    	$this->validate(request(), [

    		'email' => 'required|email',

    		'password' => 'required'

    	]);

		$user = User::create(request(['email', 'password', 'name', 'phone', 'promotions']));

    	auth()->login($user);

    	return redirect()->home();
    }
}
