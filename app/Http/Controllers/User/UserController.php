<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Services\UserService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserFormRequest;

class UserController extends Controller
{
    public function index(User $user)
    {
        $per_page = request()->query('per_page') ? request()->query('per_page') : 10;


        $result = $user->simplePaginate($per_page);

        $result->data = UserResource::collection($result);

        return response()->json($result);
    }

    public function show(String $email)
    {
        $user = User::where('email', $email)->firstOrFail();

        return response()->json(new UserResource($user));
    }

    public function profile(Request $request)
    {
        $user = auth()->user();

        return response()->json([
            'success' => true,
            'data' => new UserResource($user)
        ]);
    }

    public function update(UserFormRequest $request, String $email, UserService $service)
    {
        $user = User::where('email', $email)->firstOrFail();

        $auth_user = auth()->user();
        if(($user->email == $auth_user->email) || ($auth_user->userRole->name == 'admin')) {
            return DB::transaction(function () use ($request, $service, $user){
                $result = $service->make($request, $user);
                if($result) {
                    return response()->json([
                        'success' => true,
                        'message' => 'User updated successfully',
                    ], Response::HTTP_OK);
                }
            });
        }

        return response()->json([
            'success' => false,
            'message' => 'Unable to update profile.'
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function changePassword(UserFormRequest $request, UserService $service)
    {
        $user = auth()->user();

        if(!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect old password'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return DB::transaction(function () use ($request, $service, $user){
            $result = $service->make($request, $user);
            if($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Password changed successfully',
                ], Response::HTTP_OK);
            }
        });
    }
}
