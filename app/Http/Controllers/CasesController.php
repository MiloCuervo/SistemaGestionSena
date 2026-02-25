<?php

namespace App\Http\Controllers;

use App\Models\cases;
use Illuminate\Support\Facades\Cache;
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
            'description'              => 'required|string',
            'type'                     => 'required|in:denunciation,request,right_of_petition,tutelage',
            'status'                   => 'required|in:attended,in_progress,not_attended,closed',
            'contact_id'               => 'required|exists:contacts,id',
            'organization_process_id'  => 'required|exists:organization_processes,id',
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
        // ── 1. Stats: una sola query groupBy en vez de 4 COUNT separados ──
        $statusCounts = Cases::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status'); // Collection keyed by status

        $stats = [
            'total'        => $statusCounts->sum(),
            'attended'     => $statusCounts->get('attended', 0),
            'in_progress'  => $statusCounts->get('in_progress', 0),
            'not_attended' => $statusCounts->get('not_attended', 0),
        ];

        // ── 2. ChartData para RadialBar (reutiliza $stats, sin queries extra) ──
        $chartData = [
            'series' => [
                $stats['attended'],
                $stats['in_progress'],
                $stats['not_attended'],
            ],
            'labels' => [
                __('attended'),
                __('in_progress'),
                __('not_attended'),
            ],
        ];

        // ── 3. Comisionados: withCount genera LEFT JOIN, 1 sola query ──
        $commissioners = User::whereHas('configuration', fn($q) => $q->where('role_id', 2))
            ->withCount('cases')
            ->orderBy('cases_count', 'desc')
            ->get(['id', 'name']);

        $commissionerStats = [
            'series' => $commissioners->pluck('cases_count')->toArray(),
            'labels' => $commissioners->pluck('name')->toArray(),
        ];

        // ── 4. Mensuales: 1 query agrupada por (mes, status), pivotada en PHP ──
        $monthlyRaw = Cases::selectRaw('MONTH(created_at) as month, status, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->whereIn('status', ['attended', 'in_progress', 'not_attended'])
            ->groupBy('month', 'status')
            ->get();

        $byMonth = $monthlyRaw->groupBy('month');
        $monthlySeries = ['attended' => [], 'in_progress' => [], 'not_attended' => []];

        foreach (range(1, 12) as $m) {
            $group = $byMonth->get($m, collect());
            foreach (array_keys($monthlySeries) as $status) {
                $monthlySeries[$status][] = (int) ($group->firstWhere('status', $status)?->total ?? 0);
            }
        }

        return view('admin.dashboard', compact('stats', 'chartData', 'commissionerStats', 'monthlySeries'));
    }
}
