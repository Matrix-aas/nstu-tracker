<?php

namespace App\Http\Controllers;

use App\Models\Users\Admin;
use App\Services\Users\IAdminService;
use App\Services\Users\IAuthService;
use App\Services\Users\IProfessorService;
use App\Services\Users\IStudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Authorization extends Controller
{
    private $authService;
    private $studentService;
    private $professorService;
    private $adminService;

    public function __construct(
        IAuthService $authService,
        IStudentService $studentService,
        IProfessorService $professorService,
        IAdminService $adminService
    )
    {
        $this->authService = $authService;
        $this->studentService = $studentService;
        $this->professorService = $professorService;
        $this->adminService = $adminService;
    }

    public function authStudent(Request $request)
    {

    }

    public function authProfessor(Request $request)
    {

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function authAdmin(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "login" => "required|string|min:3",
            "password" => "required|string|min:3"
        ]);
        if ($validator->fails()) {
            return response($validator->getMessageBag()->first(), 400);
        }

        $login = $request->post("login");
        $password = $request->post("password");

        $token = $this->adminService->authAdmin($login, $password, $request->ip(), false);

        return response()->json(['token' => $token]);
    }

    public function logout()
    {
        $this->authService->logout();
        return response("Goodby.");
    }

    public function getAllData(Request $request)
    {
        return $this->authService->getAllTokensData();
    }
}
