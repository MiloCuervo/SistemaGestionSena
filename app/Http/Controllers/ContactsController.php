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

    public function create(Request $request)
    {
        $returnTo = $request->query('return_to', route('user.contacts'));
        return view('user.contacts-create', compact('returnTo'));
    }
    

    public function show($id)
    {
        $contact = $this->contactService->find($id);
        return view('user.contacts', compact('contact'));
    }

    public function store(CreateContactsRequest $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'identification_number' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|max:15',
            'position' => 'nullable|string|max:255',
        ]);

        $contact = Contact::create([
            'full_name' => $request->full_name,
            'identification_number' => $request->identification_number,
            'email' => $request->email,
            'phone' => $request->phone,
            'position' => $request->position
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'id' => $contact->id,
                'full_name' => $contact->full_name,
            ]);
        }

        $returnTo = $request->input('return_to');
        if ($returnTo) {
            $separator = str_contains($returnTo, '?') ? '&' : '?';
            return redirect()->to($returnTo . $separator . 'contact_id=' . $contact->id)
                ->with('success', 'Contacto creado correctamente.');
        }

        return redirect()->route('user.contacts')->with('success', 'Contacto creado correctamente.');
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
