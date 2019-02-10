<?php

namespace App\Http\Controllers;

use App\Models\Users\Admin;
use App\Services\Users\IAdminService;
use App\Services\Users\IAuthService;
use App\Services\Users\IProfessorService;
use App\Services\Users\IStudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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

    /**
     * @param Request $request
     * @return array
     * @throws ValidationException
     */
    private function getAuthData(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "login" => "required|string|min:3",
            "password" => "required|string|min:3",
            "remember" => "sometimes|boolean",
            "ip_verify" => "sometimes|boolean"
        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $login = $request->post("login");
        $password = $request->post("password");

        $remember = $request->post("remember", false);
        $ip_verify = $request->post("ip_verify", true);

        return [$login, $password, $remember, $ip_verify];
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function authStudent(Request $request)
    {
        list($login, $password, $remember, $ip_verify) = $this->getAuthData($request);

        $token = $this->studentService->auth($login, $password, $ip_verify ? $request->ip() : null, $remember);

        return response()->json(['token' => $token]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function authProfessor(Request $request)
    {
        list($login, $password, $remember, $ip_verify) = $this->getAuthData($request);

        $token = $this->professorService->auth($login, $password, $ip_verify ? $request->ip() : null, $remember);

        return response()->json(['token' => $token]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function authAdmin(Request $request)
    {
        list($login, $password, $remember, $ip_verify) = $this->getAuthData($request);

        $token = $this->adminService->auth($login, $password, $ip_verify ? $request->ip() : null, $remember);

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
