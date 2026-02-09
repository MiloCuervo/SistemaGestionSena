<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function __invoke()
    {
        
        return view('user.contacts');
    }

    public function store(Request $request)
    {
        // Lógica para almacenar un nuevo contacto
    }

    public function show($id)
    {
        // Lógica para mostrar un contacto específico
    }
}
