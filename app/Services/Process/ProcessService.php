<?php

namespace App\Services\Process;

use App\Models\OrganizationProcess;
use Illuminate\Pagination\LengthAwarePaginator;

class ProcessService
{
    public function getAll(): LengthAwarePaginator
    {
        $query = OrganizationProcess::where('active', true)->latest();

        return $query->paginate(OrganizationProcess::PAGINATE);
    }

    public function find(int $id): OrganizationProcess
    {
        return OrganizationProcess::findOrFail($id);
    }

    public function create(array $data): OrganizationProcess
    {
        return OrganizationProcess::create($data);
    }

    public function update(int $id, array $data): bool
    {
        return OrganizationProcess::where('id', $id)->update($data);
    }

    public function delete(int $id): bool
    {
        return OrganizationProcess::where('id', $id)->update(['active' => false]);
    }
}
