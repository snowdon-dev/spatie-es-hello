<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use InvalidArgumentException;
use App\Models\Profile;

class DashboardController extends Controller
{
    public function show()
    {
        $profile = Profile::where('userId', auth()->user()->id)->first();

        if (empty($profile)) {
            throw new InvalidArgumentException("No profile projection - possible invalid request");
        }
        return view('dashboard', $profile->only('username'));
    }


    public function store() {
        // update the event stream for user, not the active record
    }
}
