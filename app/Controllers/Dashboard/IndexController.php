<?php

namespace App\Controllers\Dashboard;

use App\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends Controller 
{
    /**
     * Display index
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        return $this->render("dashboard/index");
    }
}