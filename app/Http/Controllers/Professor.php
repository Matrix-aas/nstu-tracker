<?php

namespace App\Http\Controllers;

class Professor extends Controller
{
    public function findAll()
    {
        return \App\Models\Users\Professor::all();
    }
}
