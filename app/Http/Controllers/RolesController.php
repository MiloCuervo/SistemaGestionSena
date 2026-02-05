<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RolesController extends Controller
{
    public function __invoke()
    {
        $roles = Role::all();
        return view("admin.roles", compact("roles"));
    }
}
