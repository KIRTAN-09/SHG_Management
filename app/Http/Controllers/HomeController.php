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

        $monthlySavings = Savings::selectRaw('SUM(amount) as total, MONTH(date_of_deposit) as month')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        $months = [];
        $savings = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[] = Carbon::create()->month($i)->format('F');
            $savings[] = $monthlySavings[$i] ?? 0;
        }

        return view('home', compact('totalGroups', 'totalMembers', 'totalActiveMembers', 'months', 'savings'));
    }
}
