<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Member;
use App\Models\Savings;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalGroups = Group::count(); // Assuming you have a Group model
        $totalMembers = Member::count(); // Assuming you have a Member model
        $totalActiveMembers = Member::where('status', 'Active')->count(); // Assuming you have a Member model

        $savings = Savings::select('amount', 'date_of_deposit')->get();
        $savingsDates = $savings->pluck('date_of_deposit')->map(function($date) {
            return Carbon::parse($date)->format('Y-m-d');
        });
        $savingsAmounts = $savings->pluck('amount');

        return view('home', compact('totalGroups', 'totalMembers', 'totalActiveMembers', 'savingsDates', 'savingsAmounts'));
    }
}
