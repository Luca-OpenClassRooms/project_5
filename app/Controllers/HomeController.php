<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller 
{
    public function index(Request $request)
    {
        return $this->render("index");
    }
}