<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LockPageController extends Controller
{
    // Lock Page Index
    public function index()
    {
        return view('user.lock.index');
    }
}
