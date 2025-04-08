<?php

namespace App\Http\Controllers\Forms;

use Illuminate\Http\Request;

class TrainingsReportController extends Controller
{
    public function index()
    {
        // Fetch data for the trainings report
        $trainings = Training::all();
        return view('reports.trainings' , compact('trainings') );
    }
}