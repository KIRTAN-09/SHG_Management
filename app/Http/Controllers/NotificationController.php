<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        // Fetch notifications from the database or any other source
        $notifications = []; // Replace with actual data fetching logic

        return view('notifications.index', compact('notifications'));
    }
}
