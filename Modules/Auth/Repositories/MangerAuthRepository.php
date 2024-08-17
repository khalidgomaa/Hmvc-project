<?php

namespace Modules\Auth\Repositories;



use Illuminate\Support\Facades\Auth;
use Modules\Auth\App\Http\Requests\LoginRequest;
use Modules\Auth\Repositories\MangerAuthRepositoryInterface;

class MangerAuthRepository implements MangerAuthRepositoryInterface
{
    public function authenticate(LoginRequest $request)
    {
        
        if (Auth::guard('manger')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            $manger = auth()->guard('manger')->user();
            if ($manger->employee && $manger->employee->manager_id === null) {
                return redirect()->route('manger.dashboard');
            } else {
                auth()->guard('manger')->logout();
                return redirect()->route('manger.login')->with('error', 'You do not have authorization.');
            }
        } else {
            session()->flash('error', 'Either email/password is invalid');
            return redirect()->route('manger.login');        }
    }
    public function logout(){
       
        auth()->guard('manger')->logout();
        return redirect()->route('manger.login');
    }
}