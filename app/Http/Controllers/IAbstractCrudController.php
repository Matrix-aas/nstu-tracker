<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Router;

interface IAbstractCrudController
{
    public function findAll(Request $request);

    public function findById(Request $request, $id);

    public function create(Request $request);

    public function update(Request $request, $id);

    public function delete(Request $request, $id);

    public static function setupRouter(Router $router);
}