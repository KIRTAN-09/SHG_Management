<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IgasController extends Controller
{
    // ...existing code...

    public function activities()
    {
        // Example variable that might be causing the issue
        $activities = $this->getActivities(); // Ensure this method returns an array or object

        // Initialize $activities if it's null
        if (is_null($activities)) {
            $activities = [];
        }

        // Your logic for activities
        return view('igas.activities', compact('activities'));
    }

    private function getActivities()
    {
        // Fetch activities from the database or other source
        // Ensure this method returns an array or object
        return []; // Example return value
    }

    // ...existing code...
}
