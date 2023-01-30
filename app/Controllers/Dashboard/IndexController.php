<?php

namespace App\Controllers\Dashboard;

use App\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * Display index
     *
     * @return void
     */
    public function index()
    {
        return $this->render("dashboard/index");
    }
}
