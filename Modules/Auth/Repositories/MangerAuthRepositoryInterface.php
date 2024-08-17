<?php

namespace Modules\Auth\Repositories;


use Modules\Auth\App\Http\Requests\LoginRequest;



    interface MangerAuthRepositoryInterface
    {
        public function authenticate(LoginRequest $request);
        public function logout();
    }

