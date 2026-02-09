<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use App\Models\Contact;
use App\Models\OrganizationProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CasesController extends Controller
{
    private function applyUserScope($query)
    {
        $user = Auth::user();

        if ($user && (int) $user->role_id === 2) {
            $query->where('user_id', $user->id);
        }

        return $query;
    }

    public function __invoke()
    {
        $cases = $this->applyUserScope(
            Cases::with('contact', 'organizationProcess', 'user')
        )
            ->latest()
            ->get();

        $contacts = Contact::orderBy('full_name')->get();
        $processes = OrganizationProcess::where('active', true)
            ->orderBy('name')
            ->get();

        return view('user.cases', compact('cases', 'contacts', 'processes'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'case_evidence' => 'nullable|string',
            'contact_id' => 'required|exists:contacts,id',
            'organization_process_id' => 'required|exists:organization_processes,id',
            'type' => 'required|in:denunciation,request,right_of_petition,tutelage',
            'status' => 'required|in:attended,in_progress,not_attended,closed',
        ]);

        $cases = new Cases();
        $cases->case_number = date("Ymd") . rand(1000, 9999);
        $cases->description = $request->description;
        $cases->case_evidence = $request->case_evidence;
        $cases->status = $request->status;
        $cases->type = $request->type;
        $cases->contact_id = $request->contact_id;
        $cases->organization_process_id = $request->organization_process_id;
        $cases->user_id = Auth::id();
        $cases->save();

        return redirect()->route('user.cases')->with('success', 'Caso creado correctamente.');
    }

    public function show($id)
    {
        $case = $this->applyUserScope(
            Cases::with('contact', 'organizationProcess', 'user')
        )->findOrFail($id);

        return view('user.cases', compact('case'));
    }

    public function edit($id)
    {
        $case = $this->applyUserScope(
            Cases::with('contact', 'organizationProcess', 'user')
        )->findOrFail($id);

        $contacts = Contact::orderBy('full_name')->get();
        $processes = OrganizationProcess::where('active', true)
            ->orderBy('name')
            ->get();

        return view('user.cases-edit', compact('case', 'contacts', 'processes'));
    }

    public function update(Request $request, $id)
    {
        $case = $this->applyUserScope(Cases::query())->findOrFail($id);

        $request->validate([
            'description' => 'required|string',
            'case_evidence' => 'nullable|string',
            'contact_id' => 'required|exists:contacts,id',
            'organization_process_id' => 'required|exists:organization_processes,id',
            'type' => 'required|in:denunciation,request,right_of_petition,tutelage',
            'status' => 'required|in:attended,in_progress,not_attended,closed',
        ]);

        $case->description = $request->description;
        $case->case_evidence = $request->case_evidence;
        $case->status = $request->status;
        $case->type = $request->type;
        $case->contact_id = $request->contact_id;
        $case->organization_process_id = $request->organization_process_id;
        $case->save();

        return redirect()->route('user.cases')->with('success', 'Caso actualizado correctamente.');
    }

    public function updateStatus(Request $request, $id)
    {
        $case = $this->applyUserScope(Cases::query())->findOrFail($id);

        $request->validate([
            'status' => 'required|in:attended,in_progress,not_attended,closed',
        ]);

        $case->status = $request->status;
        $case->save();

        return redirect()->route('user.cases')->with('success', 'Estado actualizado correctamente.');
    }

}
