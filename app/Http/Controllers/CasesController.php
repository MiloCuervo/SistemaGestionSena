<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cases\AddFollowUpRequest;
use App\Http\Requests\Cases\StoreCaseRequest;
use App\Http\Requests\Cases\UpdateCaseRequest;
use App\Http\Requests\Cases\UpdateCaseStatusRequest;
use App\Models\Cases;
use App\Models\Contact;
use App\Models\OrganizationProcess;
use App\Models\User;
use App\Services\Cases\CasesService;
use Illuminate\Support\Facades\Auth;

class CasesController extends Controller
{
    public function __construct(protected CasesService $casesService){}

    public function __invoke()
    {
        $user = Auth::user();
        $cases = $this->casesService->getIndexCases($user);

        if (!$user->isAdmin()) {
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

    public function store(StoreCaseRequest $request)
    {
        $this->casesService->create($request->validated(), Auth::user());

        return redirect()->route('user.dashboard')->with('success', 'Caso creado correctamente.');
    }

    public function show($id)
    {
        $case = $this->casesService->findForUserOrAdmin($id, Auth::user(), [
            'contact',
            'organizationProcess',
            'followUps' => function ($query) {
                $query->latest();
            },
        ]);

        $processes = OrganizationProcess::all();
        $contacts = Contact::all();

        return view('user.cases-show', compact('case', 'processes', 'contacts'));
    }

    public function editStatus($id)
    {
        $case = $this->casesService->findForUser($id, Auth::id(), ['contact', 'organizationProcess']);

        return view('user.cases-status-edit', compact('case'));
    }

    public function tracking($id)
    {
        $case = $this->casesService->findForUser($id, Auth::id(), [
            'contact',
            'organizationProcess',
            'followUps' => function ($query) {
                $query->latest();
            },
        ]);

        $userCases = Cases::where('user_id', Auth::id())
            ->latest()
            ->get(['id', 'case_number', 'status']);

        return view('user.cases-tracking', compact('case', 'userCases'));
    }

    public function createFollowUp($id)
    {
        $case = $this->casesService->findForUser($id, Auth::id(), ['contact', 'organizationProcess']);

        return view('user.cases-followup-create', compact('case'));
    }

    public function updateStatus(UpdateCaseStatusRequest $request, $id)
    {
        $this->casesService->updateStatus($id, $request->validated(), Auth::user());

        return redirect()->route('user.dashboard')->with('success', 'Estado actualizado correctamente.');
    }

    public function deactivate($id)
    {
        $this->casesService->deactivate($id, Auth::user());

        return redirect()->back()->with('message', 'Caso desactivado correctamente.');
    }



    public function addFollowUp(AddFollowUpRequest $request, $id)
    {
        $evidencePaths = [];
        if ($request->hasFile('follow_up_evidence')) {
            foreach ($request->file('follow_up_evidence') as $file) {
                $evidencePaths[] = $file->store('follow-ups', 'public');
            }
        }

        $this->casesService->addFollowUp($id, $request->validated(), Auth::user(), $evidencePaths);

        return redirect()
            ->route('user.cases.tracking', $id)
            ->with('success', 'Seguimiento creado correctamente.');
    }
}
