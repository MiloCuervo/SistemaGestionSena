<?php

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\Computed;

new class extends Component {

    #[Computed]
    public function totalUsers()
    {
        return User::count();
    }

};
?>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">

    <flux:card>
        <div class="text-sm text-gray-500">Total usuarios</div>
        <div class="text-2xl font-bold">
            5
        </div>
    </flux:card>

</div>