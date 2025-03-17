<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManagerUser extends Controller
{
    public function Login(){
        return view('client.form.login');
    }
    public function Register(){
        return view('client.form.register');
    }
    public function Forgot(){
        return view('client.form.forgot');
    }
    public function Confirm(){
        return view('client.form.confirm');
    }
}
