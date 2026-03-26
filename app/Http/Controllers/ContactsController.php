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

    public function create(Request $request)
    {
        $returnTo = $request->query('return_to', route('user.contacts'));
        return view('user.contacts-create', compact('returnTo'));
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
