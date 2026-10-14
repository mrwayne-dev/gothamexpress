<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function comingSoon(): Response
    {
        return Inertia::render('Marketing/ComingSoon');
    }
}
