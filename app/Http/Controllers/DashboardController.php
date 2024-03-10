<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    ///another way to make middleware
    public function __construct()
    {
        // $this->middleware(['auth']);
        // $this->middleware(['auth'])->except('index');
        // $this->middleware(['auth'])->only('index');
    }

    //actions
    public function index()
    {
        $title = 'Store';
        // $user = Auth::user();
        // Return response: view, josn, redirect, file
        return view('dashboard.index', [
            'user' => 'Abdelrahmman',
            'title' => $title
        ]);
    }
}