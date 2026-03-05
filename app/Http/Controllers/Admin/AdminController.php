<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        // Auth middleware is now applied at route level
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
