<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Make sure this is added

class AdminController extends Controller
{
    public function createAssessor()
    {
        // Generate the next password based on the latest user
        $lastUser = User::latest('id')->first();
        $nextId = $lastUser ? $lastUser->id + 1 : 1;
        $defaultPassword = 'AS' . $nextId . '_123';

        return view('admin.create_assessor', compact('defaultPassword'));
    }

    public function approveReject()
    {
        return view('admin.approve-reject');
    }

    public function manageAccount()
    {
        return view('admin.manage');
    }
}
