<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\UserAccount;
use App\Models\UserInformation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    
    public function showLogin()
    {
        return view('admin.login');
    }

    public function processLogin(Request $request)
    {
        // Temporary Navigation (no authentication yet)
        // Simply redirect to the dashboard
        return redirect()->route('admin.dashboard');
    }

    
    public function dashboard()
    {
        return view('admin.dashboard'); // Adjust the view name if needed
    }


    public function bookInventory()
    {
        return view('admin.book_inventory');
    }


    public function userManagement()
    {
        return view('admin.user_management');
    }

    public function reports()
    {
        return view('admin.reports');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login'); // Ensure this route exists
    }

    
}

 // Show the dashboard page
    // Show the dashboard page
   
