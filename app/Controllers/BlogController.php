<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;

class BlogController extends Controller 
{
    public function show(Request $request)
    {
        return $this->render("blog");
    }
}