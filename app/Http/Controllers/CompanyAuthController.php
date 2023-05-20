<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyAuthController extends Controller
{
    public function index(){
        return view('company.login');
    }

    public function store(){
          $attribute = request()->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|max:32',
        ]);

        if (Auth::guard('company_web')->attempt($attribute))
        {
            return redirect()->route('dashboard')->withSuccess('Welcome to the board');
        }
        return redirect()->back()->with('error','invalid credentials');
    }


}
