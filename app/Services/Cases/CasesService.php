<?php

namespace App\Services\Cases;

use App\Models\Cases;
use App\Models\FollowUp;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CasesService
{
    protected function getBaseQuery(User $user): Builder
    {
        return Cases::with(['contact', 'organizationProcess', 'user'])
        ->where('user_id', $user->id);
    }

    public function query(User $user): Builder
    {
        return $this->getBaseQuery($user);
    }

    public function getAll(User $user): LengthAwarePaginator
    {
        $query = $this->getBaseQuery($user)->latest();
        return $query->paginate(Cases::PAGINATE);
    }

    public function find(User $user, int $id): Cases
    {
        return $this->getBaseQuery($user)->findOrFail($id);
    }

    public function getUserCases(User $user): Builder
    {
        return $this->getBaseQuery($user);
    }

    public function getIndexCases(User $user): LengthAwarePaginator
    {
        return $this->getBaseQuery($user)->latest()->paginate(Cases::PAGINATE);
    }

    public function create(array $data, User $user, ?array $evidencePaths = null): Cases
    {
        return DB::transaction(function () use ($data, $user, $evidencePaths) {
            $type = $data['type'] === 'denunciation' ? 'complaint' : $data['type'];

            return Cases::create([
                'case_number' => 'SGS-' . date('YmdHis') . '-' . rand(1, 99),
                'sena_number' => $data['sena_number'] ?? null,
                'description' => $data['description'],
                'status' => 'in_progress',
                'type' => $type,
                'contact_id' => $data['contact_id'],
                'organization_process_id' => $data['organization_process_id'],
                'case_evidence' => $evidencePaths,
                'user_id' => $user->id,
                'closed_date' => now()->addMonths(2),
            ]);
        });
    }

    public function updateStatus(int $id, array $data, User $user): Cases
    {
        $case = $this->getBaseQuery($user)->findOrFail($id);
        $case->status = $data['status'];
        $case->save();

        return $case;
    }

    public function deactivate(int $id, User $user): Cases
    {
        $case = $this->getBaseQuery($user)->findOrFail($id);
        $case->active = false;
        $case->save();

        return $case;
    }

    public function addFollowUp(int $id, array $data, User $user, ?array $evidencePaths = null): FollowUp
    {
        $case = $this->getBaseQuery($user)->findOrFail($id);

        $nextFollowUpNumber = ((int) $case->followUps()->max('follow_up_number')) + 1;

        return FollowUp::create([
            'case_id' => $case->id,
            'description' => $data['description'],
            'follow_up_evidence' => empty($evidencePaths) ? null : $evidencePaths,
            'follow_up_number' => $nextFollowUpNumber,
        ]);
    }
}
