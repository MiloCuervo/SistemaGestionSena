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
        $case = cases::with('contact', 'process', 'user')->find($id);
        return view('user.cases', compact('case'));
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
        ]);

        $case->fill($data);
        $case->save();

        return redirect()->route('user.cases')->with('success', 'Caso actualizado correctamente.');
    }

    public function updateStatus(Request $request, $id)
    {
        $case = Cases::where('user_id', Auth::id())->findOrFail($id);

        $data = $request->validate([
            'status' => 'required|in:attended,in_progress,not_attended,closed',
        ]);

        $case->status = $data['status'];
        $case->save();

        return redirect()->route('user.cases')->with('success', 'Estado actualizado correctamente.');
    }

    public static function chart()
    {
        $order = [
            'in_progress' => 'En Progreso',
            'attended' => 'Atendidos',
            'not_attended' => 'No Atendidos',
            'closed' => 'Cerrados',
        ];

        $counts = Cases::whereIn('status', array_keys($order))
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $data = [];
        foreach (array_keys($order) as $key) {
            $data[] = $counts[$key] ?? 0;
        }

        return $data;
    }
}
