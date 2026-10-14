<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class DevController extends Controller
{
    public function components(): Response
    {
        return Inertia::render('Dev/Components');
    }
}
