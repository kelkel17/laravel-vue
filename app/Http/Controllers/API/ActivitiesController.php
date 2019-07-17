<?php

namespace App\Http\Controllers\API;

use App\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActivitiesController extends Controller
{
    public function index()
    {
        return Activity::with('user')->orderBy('created_at', 'DESC')->get();
    }
}
