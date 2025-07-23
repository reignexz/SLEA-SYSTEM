<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        // if not using Auth yet, you can stub a user:
         $user = (object)[
          'name'=>'Edryan S. Manocay',
          'phone'=>'09991752790',
          'admin_id'=>'2022-00216',
          'email'=>'esmanocay00216@usep.edu.ph',
           'position'=>'Stage Manager President'
        ];
        return view('profile', compact('user'));

        // once you have Auth set up:
        //$user = Auth::user();
        //return view('profile', compact('user'));
    }
}
