<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use App\Models\Contact;
use App\Models\FollowUp;
use App\Models\OrganizationProcess;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function newCase()
    {
        $contacts = Contact::all();
        $processes = OrganizationProcess::all();
        $selectedContactId = request()->query('contact_id');
        
        return view('user.cases-create', compact('contacts', 'processes', 'selectedContactId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string',
            'case_evidence' => 'nullable|string',
            'contact_id' => 'required|exists:contacts,id',
            'organization_process_id' => 'required|exists:organization_processes,id',
            'type' => 'required|in:denunciation,complaint,request,right_of_petition,tutelage',
        ]);

       $type = $request->type === 'denunciation' ? 'complaint' : $request->type;

        $case = new Cases;
        $case->case_number = 'CAD-'.date('YmdHis').'-'.rand(1000, 9999);
        $case->description = $request->description;
        $case->case_evidence = $request->case_evidence;
        $case->status = 'in_progress';
        $case->type = $type;
        $case->contact_id = $request->contact_id;
        $case->organization_process_id = $request->organization_process_id;
        $case->user_id = Auth::id();
        $case->closed_date = now()->addMonths(2);
        $case->save(); 

        return redirect()->route('user.dashboard')->with('success', 'Caso creado correctamente.');
    }

    public function show($id)
    {
        $case = Cases::with([
            'contact',
            'organizationProcess',
            'followUps' => function ($query) {
                $query->latest();
            },
        ])->findOrFail($id);

        $processes = OrganizationProcess::all();
        $contacts = Contact::all();

        return view('user.cases-show', compact('case', 'processes', 'contacts'));
    }

    public function editStatus($id)
    {
        $case = Cases::where('user_id', Auth::id())
            ->with(['contact', 'organizationProcess'])
            ->findOrFail($id);

        return view('user.cases-status-edit', compact('case'));
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

    public function createFollowUp($id)
    {
        $case = Cases::where('user_id', Auth::id())
            ->with(['contact', 'organizationProcess'])
            ->findOrFail($id);

        return view('user.cases-followup-create', compact('case'));
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
            'status' => 'required|in:attended,in_progress,not_attended,closed',
            'contact_id' => 'required|exists:contacts,id',
            'organization_process_id' => 'required|exists:organization_processes,id',
            'description' => 'required|string',
            'type' => 'required|in:denunciation,complaint,request,right_of_petition,tutelage',
            'status' => 'required|in:attended,in_progress,not_attended,closed',
            'contact_id' => 'required|exists:contacts,id',
            'organization_process_id' => 'required|exists:organization_processes,id',
        ]);

        if ($data['type'] === 'denunciation') {
            $data['type'] = 'complaint';
        }

        $case->fill($data);
        $case->save();

        return redirect()->route('user.cases')->with('success', 'Caso actualizado correctamente.');
    }

    public function updateStatus(Request $request, $id)
    {
        $case = Cases::where('user_id', Auth::id())->findOrFail($id);

        $data = $request->validate([
            'status' => 'required|in:attended,not_attended,in_progress',
        ]);

        $case->status = $data['status'];
        $case->save();

        return redirect()->route('user.dashboard')->with('success', 'Estado actualizado correctamente.');
    }

    public function deactivate($id)
    {
        $case = Cases::where('user_id', Auth::id())->findOrFail($id);
        $case->active = false;
        $case->save();

        return redirect()->back()->with('message', 'Caso desactivado correctamente.');
    }



    public function addFollowUp(Request $request, $id)
    {
        $case = Cases::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'description' => 'required|string',
            'follow_up_evidence' => 'nullable|array',
            'follow_up_evidence.*' => 'file|mimes:pdf,png,jpg,jpeg|max:5120',
        ]);

        $evidencePaths = [];
        if ($request->hasFile('follow_up_evidence')) {
            foreach ($request->file('follow_up_evidence') as $file) {
                $evidencePaths[] = $file->store('follow-ups', 'public');
            }
        }

        $nextFollowUpNumber = ((int) $case->followUps()->max('follow_up_number')) + 1;

        FollowUp::create([
            'case_id' => $case->id,
            'description' => $validated['description'],
            'follow_up_evidence' => empty($evidencePaths) ? null : $evidencePaths,
            'follow_up_number' => $nextFollowUpNumber,
        ]);

        return redirect()
            ->route('user.cases.tracking', $case->id)
            ->with('success', 'Seguimiento creado correctamente.');
    }
}
