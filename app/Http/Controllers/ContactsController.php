<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Contacts\CreateContactsRequest;
use App\Http\Requests\Contacts\UpdateContactsRequest;
use App\Models\Contact;
use App\Services\Contact\ContactService;

class ContactsController extends Controller
{

    public function __construct(protected ContactService $contactService){}    

    public function index()
    {
        $contacts = $this->contactService->getAll();
        return view('user.contacts', compact('contacts'));
    }

    public function show($id)
    {
        $contact = $this->contactService->find($id);
        return view('user.contacts', compact('contact'));
    }

    public function store(CreateContactsRequest $request)
    {
        $this->contactService->create($request->validated());

        return redirect()->route('user.contacts')->with('message', 'Contacto creado correctamente.');
    }

    public function edit(int $id)
    {
        $contact = $this->contactService->find($id);
        return view('user.contacts.edit', compact('contact'));//debe retornar al ofrmulario de edicion de contactos con el contacto a editar
    }

    public function update(UpdateContactsRequest $request, int $id)
    {
        $this->contactService->update($id, $request->validated());
        return redirect()->route('user.contacts')->with('message', 'Contacto actualizado correctamente.');
    }

    public function destroy($id)
    {
        $this->contactService->delete($id);
        return redirect()->route('user.contacts')->with('message', 'Contacto eliminado correctamente.');
    }

    public function cases_count($id)
    {
        $contact = $this->contactService->find($id);
        return $contact->cases()->count();
    }
}
