<?php

namespace App\Http\Controllers;

use App\Models\cases;
use App\Models\User;
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
 
    
    public function getAdminCases($id){
        $case = Cases::where('id', $id)->with('user','contact', 'organizationProcess')->first();
        return view('admin.showCase', compact('case'));
    }

    public function adminDashboard()
    {
        $stats = [
            'total' => Cases::count(),
            'attended' => Cases::where('status', 'attended')->count(),
            'in_progress' => Cases::where('status', 'in_progress')->count(),
            'not_attended' => Cases::where('status', 'not_attended')->count(),
        ];

        $chartData = [
            'series' => [
                $stats['attended'],
                $stats['in_progress'],
                $stats['not_attended'],
            ],
            'labels' => [
                __('Resueltos'),
                __('En Proceso'),
                __('No Solucionados'),
            ]
        ];

        // Fetch workload per commissioner (including those with 0 cases)
        $commissioners = User::whereHas('configuration', function($query) {
            $query->where('role_id', 2);
        })
        ->withCount('cases')
        ->orderBy('cases_count', 'desc')
        ->get();

        $commissionerStats = [
            'series' => $commissioners->pluck('cases_count')->toArray(),
            'labels' => $commissioners->pluck('name')->toArray(),
        ];

        return view('admin.dashboard', compact('stats', 'chartData', 'commissionerStats'));
    }
}
