<?php

namespace Modules\Auth\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Auth\App\Http\Requests\LoginRequest;
use Modules\Auth\Repositories\MangerAuthRepositoryInterface;

class AuthController extends Controller
{
    protected $authRepository;

    public function __construct(MangerAuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }


    public function index()
    {
        return view('auth::login');
    }
    public function authenticate(LoginRequest $request)
    {
        return $this->authRepository->authenticate($request);
    }

    public function logout(){
       
        return $this->authRepository->logout();
     
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('auth::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('auth::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
