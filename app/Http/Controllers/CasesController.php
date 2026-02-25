<?php

namespace App\Http\Controllers;

use App\Models\cases;
use App\Models\Contact;
use App\Models\OrganizationProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CasesController extends Controller
{
    public function __invoke()
    {
        $cases = cases::with('contact', 'organizationProcess', 'user')->get();
        if (Auth::user()->role_id != 1) {
            return view('user.cases', compact('cases'));
        } else {
            return view('admin.cases', compact('cases'));
        }
    }


    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'case_evidence' => 'nullable|string',
            'contact_id' => 'required|exists:contacts,id',
            'process_id' => 'required|exists:organization_processes,id',
            'type' => 'required|string',
        ]);

        $cases = new Cases();
        $cases->case_number = "CAD-" . date('YmdHis') . '-' . rand(1000, 9999);
        $cases->description = $request->description;
        $cases->case_evidence = $request->case_evidence;
        $cases->status = "in_progress";
        $cases->type = $request->type;
        $cases->contact_id = $request->contact_id;
        $cases->process_id = $request->process_id;
        $cases->user_id = Auth::id();
        $cases->save();

        return redirect()->route('user.cases')->with('success', 'Caso creado correctamente.');
    }

    public function show($id)
    {
        $case = Cases::where('user_id', Auth::id())
            ->with(['contact', 'organizationProcess'])
            ->findOrFail($id);

        return view('user.cases-show', compact('case'));
    }

    public function tracking($id)
    {
        $case = Cases::where('user_id', Auth::id())
            ->with([
                'contact',
                'organizationProcess',
                'followUps' => function ($query) {
                    $query->latest();
                },
            ])
            ->findOrFail($id);

        $userCases = Cases::where('user_id', Auth::id())
            ->latest()
            ->get(['id', 'case_number', 'status']);

        return view('user.cases-tracking', compact('case', 'userCases'));
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
        $case = cases::where('user_id', Auth::id())->findOrFail($id);

        $data = $request->validate([
            'description' => 'required|string',
            'type' => 'required|in:denunciation,request,right_of_petition,tutelage',
            'status' => 'required|in:attended,in_progress,not_attended',
            'contact_id' => 'required|exists:contacts,id',
            'organization_process_id' => 'required|exists:organization_processes,id',
        ]);

        $case->fill($data);
        $case->save();

        return redirect()->route('user.cases')->with('success', 'Caso actualizado correctamente.');
    }

    public function updateStatus(Request $request, $id)
    {
        $case = Cases::where('user_id', Auth::id())->findOrFail($id);

        $data = $request->validate([
            'status' => 'required|in:attended,in_progress,not_attended,',
        ]);

        $case->status = $data['status'];
        $case->save();

        return redirect()->route('user.cases')->with('success', 'Estado actualizado correctamente.');
    }
}
