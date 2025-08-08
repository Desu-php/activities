<?php

namespace App\Http\Controllers;

use App\Models\Activity\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::with('activityType', 'participant')
            ->latest('id')
            ->paginate();

        return view('index', compact('activities'));
    }
}
