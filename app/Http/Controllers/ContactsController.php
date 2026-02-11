<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;


class ContactsController extends Controller
{
    public function __invoke()
    {
        $contacts = Contact::with('cases')->get();
        return view('user.contacts', compact('contacts'));
    }
    

   public function show($id)
    {
        $contact = Contact::find($id);
        return view('user.contacts', compact('contact'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'identification_number' => 'required|int|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|max:15',
            'position' => 'nullable|string|max:255',
        ]);

        Contact::create([
            'full_name' => $request->full_name,
            'identification_number' => $request->identification_number,
            'email' => $request->email,
            'phone' => $request->phone,
            'position' => $request->position
        ]);

        return redirect()->route('user.contacts')->with('success', 'Contacto creado correctamente.');
    }
    public function update(Request $request, $id)
    {
        $contact = Contact::find($id);
        $contact->full_name = $request->full_name;
        $contact->identification_number = $request->identification_number;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->position = $request->position;
        $contact->save();
        return redirect()->route('user.contacts')->with('success', 'Contacto actualizado correctamente.');
    }

    public function destroy($id)
    {
        $contact = Contact::find($id);
        $contact->delete();
        return redirect()->route('user.contacts')->with('success', 'Contacto eliminado correctamente.');
    }

    public function cases_count($id)
    {
        $contact = Contact::find($id);
        return $contact->cases()->count();
    }
}
