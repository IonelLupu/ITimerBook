<?php

namespace JCWolf\Dashboard\Http\Controllers;


use Dashboard;

class DashboardController extends Controller
{

    public function index(  ) {
        return view('Dashboard::main');
    }

}
