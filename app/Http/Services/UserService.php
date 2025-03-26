<?php

namespace App\Http\Services;

use App\Models\User;
use App\Http\Requests\UserFormRequest;
use App\Http\Actions\User\UpdateUserAction;

class UserService
{
    public function __construct(
        public UpdateUserAction $action
    ){}

    public function make(UserFormRequest $request, User $user)
    {
        $result = ($this->action)($user, $request->validated());
        if($result) {
            return true;
        }
        return false;
    }
}
