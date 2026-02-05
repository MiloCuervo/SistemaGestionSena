<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserConfiguration;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __invoke()
    {
        $configuration = UserConfiguration::with('role', 'user')->orderBy("id", "asc")->get();
        return view("admin.users", compact("configuration"));
    }
    public function show($id)
    {
        $user = User::find($id);
        $configuration = UserConfiguration::where("user_id", $user->id)->first();
        return view("admin.showUser", compact("user", "configuration"));
    }
    public function store(array $data)
    {
        // Crear Request internamente para validación
        $request = Request::create('/', 'POST', $data);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'second_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'second_last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'email_verified_at' => ['nullable', 'date'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        // Crear el usuario
        $user = new User();
        $user->name = $validated['name'];
        $user->second_name = $validated['second_name'];
        $user->last_name = $validated['last_name'];
        $user->second_last_name = $validated['second_last_name'];
        $user->email = $validated['email'];
        $user->email_verified_at = $validated['email_verified_at'] ?? null;
        $user->password = bcrypt($validated['password']);
        $user->save();

        UserConfiguration::create([
            'user_id' => $user->id,
            'role_id' => 2,
            'dark_mode' => false,
            'report_frequency' => 'monthly',
        ]);

    }
    public function update($data, $id)
    {
        $user = User::findOrFail($id);
        $configuration = UserConfiguration::where("user_id", $user->id)->firstOrFail();

        // Si $data es un Request, obtener los datos validados
        if ($data instanceof Request) {
            $validated = $data->validate([
                'name' => ['required', 'string', 'max:255'],
                'second_name' => ['nullable', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'second_last_name' => ['nullable', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:users,email,' . $user->id],
                'role_id' => ['required', 'integer'],
            ]);
        } else {
            // Si es un array (desde Livewire)
            $validated = $data;
        }

        $user->name = $validated['name'];
        $user->second_name = $validated['second_name'];
        $user->last_name = $validated['last_name'];
        $user->second_last_name = $validated['second_last_name'];
        $user->email = $validated['email'];
        $user->save();

        $configuration->role_id = $validated['role_id'];
        $configuration->save();

        if ($data instanceof Request) {
            return redirect()->route('admin.users.show', $user->id)->with('success', 'User updated successfully');
        }

        return true;
    }
    public function destroy($id)
    {
        $user = User::find($id);
        $configuration = UserConfiguration::where("user_id", $user->id)->first();
        if (!$user || !$configuration) {
            return redirect()->route('admin.users.index')->with('error', 'User not found');
        }

        $user->delete();
        $configuration->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }

}
