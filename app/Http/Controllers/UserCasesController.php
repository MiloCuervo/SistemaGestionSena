<?php

namespace App\Http\Controllers;

use App\Models\cases;
use App\Models\Contact;
use App\Models\OrganizationProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCasesController extends Controller
{
    public function __invoke()
    {
        $cases = cases::with(['contact', 'organizationProcess'])
            ->where('user_id', Auth::id())
            ->get();
        $contacts = Contact::all();
        $processes = OrganizationProcess::all();

        return view('user.cases', compact('cases', 'contacts', 'processes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'case_evidence' => 'nullable|string',
            'contact_id' => 'required|exists:contacts,id',
            'organization_process_id' => 'required|exists:organization_processes,id',
            'type' => 'required|string',
            'status' => 'nullable|string',
        ]);

        $case = new cases();
        $case->case_number = "CAS-" . date("Ymd") . rand(1000, 9999);
        $case->description = $request->description;
        $case->case_evidence = $request->case_evidence;
        $case->status = $request->status ?? "in_progress";
        $case->type = $request->type;
        $case->contact_id = $request->contact_id;
        $case->organization_process_id = $request->organization_process_id;
        $case->user_id = Auth::id();
        $case->save();

        return redirect()->route('user.cases')->with('success', 'Caso creado correctamente.');
    }

    public function show($id)
    {
        $case = cases::with(['contact', 'organizationProcess'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);
        $contacts = Contact::all();
        $processes = OrganizationProcess::all();

        return view('user.cases', compact('case', 'contacts', 'processes'));
    }

    public function edit($id)
    {
        $case = cases::where('user_id', Auth::id())->findOrFail($id);
        $contacts = Contact::all();
        $processes = OrganizationProcess::all();

        return view('user.cases-edit', compact('case', 'contacts', 'processes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'required|string',
            'contact_id' => 'required|exists:contacts,id',
            'organization_process_id' => 'required|exists:organization_processes,id',
            'type' => 'required|string',
            'status' => 'nullable|string',
        ]);

        $case = cases::where('user_id', Auth::id())->findOrFail($id);
        $case->description = $request->description;
        $case->status = $request->status ?? $case->status;
        $case->type = $request->type;
        $case->contact_id = $request->contact_id;
        $case->organization_process_id = $request->organization_process_id;
        $case->save();

        return redirect()->route('user.cases')->with('success', 'Caso actualizado correctamente.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $case = cases::where('user_id', Auth::id())->findOrFail($id);
        $case->status = $request->status;
        $case->save();

        return redirect()->route('user.cases')->with('success', 'Estado actualizado correctamente.');
    }
}
