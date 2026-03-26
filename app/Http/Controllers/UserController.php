<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\CreateUserRequests;
use App\Http\Requests\Users\UpdateUserRequests;
use App\Models\User;
use App\Models\UserConfiguration;
use App\Services\Users\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(protected UserService $userService){}

    public function index()
    {
        $users = $this->userService->getAll();
        return view('admin.users', compact('users'));
    }

    public function show($id)
    {
        $user = User::find($id);
        $configuration = UserConfiguration::where('user_id', $user->id)->first();

        return view('admin.showUser', compact('user', 'configuration'));
    }

    public function store(CreateUserRequests $request)
    {
        $user = $this->userService->create($request->validated());

        return redirect()->route('admin.users',$user)->with('success', 'Usuario creado exitosamente');

    }

    public function update($id, UpdateUserRequests $request)
    {
        $this->userService->update($id, $request->validated());
        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado exitosamente');
    }

    public function destroy($id)
    {
        $this->userService->delete($id);
        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado correctamente');
    }
}
