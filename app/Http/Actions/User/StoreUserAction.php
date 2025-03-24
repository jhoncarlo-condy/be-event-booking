<?php

namespace App\Http\Actions\User;

use App\Models\User;
use App\Models\UserRole;

class StoreUserAction
{
    public function __invoke($response)
    {
        return User::create(array_merge(
            $response,
            ['user_role_id' => UserRole::where('name', 'user')->first()->id]
        ));
    }
}
