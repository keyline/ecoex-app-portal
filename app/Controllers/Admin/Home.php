<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        echo 'test';exit;
        return view('admin/login');
    }


}
