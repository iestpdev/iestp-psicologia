<?php

namespace App\Controllers;

class DerivacionController extends BaseController
{
    public function index(): string
    {
        return view('modules/derivaciones/index');
    }
}
