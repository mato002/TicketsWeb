<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * Display the FAQ page.
     */
    public function faq()
    {
        return view('public.pages.faq');
    }

    /**
     * Display the Terms of Service page.
     */
    public function terms()
    {
        return view('public.pages.terms');
    }

    /**
     * Display the Privacy Policy page.
     */
    public function privacy()
    {
        return view('public.pages.privacy');
    }

    /**
     * Display the Refund Policy page.
     */
    public function refund()
    {
        return view('public.pages.refund');
    }
}
