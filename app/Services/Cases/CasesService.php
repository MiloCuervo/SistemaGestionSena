<?php

namespace App\Services\Cases;

use App\Models\Cases;
use App\Models\FollowUp;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CasesService
{
    protected function baseQuery(): Builder
    {
        return Cases::with(['contact', 'organizationProcess', 'user']);
    }

    public function getIndexCases(User $user)
    {
        if ($user->isAdmin()) {
            return $this->baseQuery()->latest()->get();
        }

        return $this->baseQuery()
            ->where('user_id', $user->id)
            ->latest()
            ->get();
    }

    public function findForUserOrAdmin(int $id, User $user, array $with = []): Cases
    {
        $query = Cases::query()->with($with);

        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        return $query->findOrFail($id);
    }

    public function findForUser(int $id, int $userId, array $with = []): Cases
    {
        return Cases::with($with)
            ->where('user_id', $userId)
            ->findOrFail($id);
    }

    public function create(array $data, User $user): Cases
    {
        return DB::transaction(function () use ($data, $user) {
            $type = $data['type'] === 'denunciation' ? 'complaint' : $data['type'];

            return Cases::create([
                'case_number' => 'SGS-' . date('YmdHis') . '-' . rand(1, 99),
                'sena_number' => $data['sena_number'] ?? null,
                'description' => $data['description'],
                'case_evidence' => $data['case_evidence'] ?? null,
                'status' => 'in_progress',
                'type' => $type,
                'contact_id' => $data['contact_id'],
                'organization_process_id' => $data['organization_process_id'],
                'user_id' => $user->id,
                'closed_date' => now()->addMonths(2),
            ]);
        });
    }

    public function updateStatus(int $id, array $data, User $user): Cases
    {
        $case = $this->findForUserOrAdmin($id, $user);
        $case->status = $data['status'];
        $case->save();

        return $case;
    }

    public function deactivate(int $id, User $user): Cases
    {
        $case = $this->findForUserOrAdmin($id, $user);
        $case->active = false;
        $case->save();

        return $case;
    }

    public function addFollowUp(int $id, array $data, User $user, ?array $evidencePaths = null): FollowUp
    {
        $case = $this->findForUserOrAdmin($id, $user);

        $nextFollowUpNumber = ((int) $case->followUps()->max('follow_up_number')) + 1;

        return FollowUp::create([
            'case_id' => $case->id,
            'description' => $data['description'],
            'follow_up_evidence' => empty($evidencePaths) ? null : $evidencePaths,
            'follow_up_number' => $nextFollowUpNumber,
        ]);
    }
}
