<?php

namespace Modules\Auth\Repositories\User;
namespace Modules\Auth\App\Models\User;



use Modules\Auth\Repositories\User\UserRepositoryInterface;



class UserRepository implements UserRepositoryInterface
{

  


    public function getAllUsers()
    {

        return User::all();
    }


}
