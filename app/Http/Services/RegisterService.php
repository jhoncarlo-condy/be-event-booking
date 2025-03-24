<?php

namespace App\Http\Services;

use App\Http\Actions\User\StoreUserAction;
use App\Http\Requests\RegisterFormRequest;

class RegisterService
{
    public function __construct(
        public StoreUserAction $action
    ){}

    public function make(RegisterFormRequest $request)
    {
        $result = ($this->action)($request->validated());
        if($result) {
            return true;
        }
        return false;
    }
}
