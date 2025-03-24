<?php

namespace App\Http\Controllers\Login;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Services\RegisterService;
use App\Http\Requests\RegisterFormRequest;

class RegisterController extends Controller
{
    public function register(
        RegisterFormRequest $request,
        RegisterService $service
    ) {
        return DB::transaction(function () use ($request, $service) {
            $result = $service->make($request);
            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'User created successfully',
                ], Response::HTTP_CREATED);
            }

            return response()->json([
                'success' => false,
                'message' => 'User creation failed'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        });
    }
}
