<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CasesController extends Controller
{
    public function __invoke()
    {
        $cases = Cases::with('contact', 'process', 'user')->get();
        return view('admin.cases', compact('cases'));
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
        $cases->case_number = "CAS-" . date("Ymd") . rand(1000, 9999);
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
        $case = Cases::with('contact', 'process', 'user')->find($id);
        return view('user.cases', compact('case'));
    }


}
