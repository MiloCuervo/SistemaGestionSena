<?php

namespace App\Services\Contact;
use App\Models\Contact;
use Illuminate\Pagination\LengthAwarePaginator;

class ContactService
{
    public function getAll(): LengthAwarePaginator
    {
        $query = Contact::latest();
        return $query->paginate(Contact::PAGINATE); 
    }

    public function find(int $id): Contact
    {
        return Contact::findOrFail($id);
    }

    public function create(array $data) : Contact
    {
        return Contact::create($data);
    }

    public function update(int $id, array $data) : bool
    {
        return Contact::where('id', $id)->update($data);
    }

    public function delete(int $id) : bool
    {
        return Contact::where('id', $id)->delete();
    }
}
