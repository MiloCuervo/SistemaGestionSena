<?php

namespace App\Services\Users;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class UserService
{
    protected function getBaseQuery(): Builder
    {
        return User::with('configuration')
            ->whereHas('configuration', function ($query) {
                $query->where('active', true);
            });
    }    
    
    public function query(): Builder
    {
        return $this->getBaseQuery();
    }

    public function getAll(): LengthAwarePaginator
    {
        $query = $this->getBaseQuery()->latest();
        return $query->paginate(10);
    }

    public function find(int $id): User
    {
        return $this->getBaseQuery()->findOrFail($id);
    }

    public function create(array $data)
    {
        
        $user = DB::transaction(function () use ($data) {
            
            // 1. Crear el usuario
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                //hashear la contraseña 
                'password' => Hash::make(Str::random(20)), 
            ]);

            // 2. Crear la configuración base usando la relación
            $defaultConfig = [
            'role_id' => 2,
            'dark_mode' => false,
            'report_frequency' => 'monthly',
            'active' => true,
            'expires_at' => now()->addYear(2),
            'deactivated_reason' => null,
            ];

            // Crear la configuración asociada
            $user->configuration()->create($defaultConfig);


            // 3. Retornar el usuario creado recargando la relación para incluir la configuración
            return $user;
        });
         // Fuera de la transaction de creacion, Esto garantiza que si el correo falla, el usuario de todas formas se creó en BD.
        Password::sendResetLink($user->only('email'));       
        return $user->fresh('configuration');
    }

    public function update(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $user = $this->find($id);

            // Actualizar el usuario
            $user->update([
                'name'  => $data['name'],
                'email' => $data['email'],
            ]);

            // Opcionalmente también puedes actualizar configuraciones
            if (isset($data['configuration'])) {
                $user->configuration->update($data['configuration']);
            }

            return $user->fresh('configuration');
        });
    }

    public function delete(int $id): void
    {
        DB::transaction(function () use ($id) {
            $user = $this->getBaseQuery()->findOrFail($id);

            // Validar si el usuario y su configuración existen
            if (!$user || !$user->configuration) {
                throw new \Exception('User or configuration not found');
            }

            // Desactivar la configuración
            $user->configuration->update(['active' => false]);
        });
    }

    public function getRoleInt(int $id): int
    {
        $configuration = $this->getBaseQuery()->findOrFail($id)->configuration;
        return $configuration->role_id ?? 0; // Retorna 0 si no tiene rol
    }

}