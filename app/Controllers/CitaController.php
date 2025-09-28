<?php

namespace App\Controllers;

class CitaController extends BaseController
{
    public function index(): string
    {
        return view('modules/citas/index');
    }
}
