<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class PublicController extends Controller
{
    public function home(): Response
    {
        return Inertia::render('Marketing/Home');
    }

    public function about(): Response
    {
        return Inertia::render('Marketing/About');
    }

    public function services(): Response
    {
        return Inertia::render('Marketing/Services');
    }

    public function policy(): Response
    {
        return Inertia::render('Marketing/Policy');
    }

    public function terms(): Response
    {
        return Inertia::render('Marketing/Terms');
    }
}
