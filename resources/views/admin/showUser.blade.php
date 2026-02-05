<x-layouts::app>


    <div class="flex items-start max-md:flex-col">
        <div class="flex items-start max-md:flex-col">
            <div class="me-10 w-full pb-4 md:w-[220px]">
                <flux:navlist aria-label="{{ __('Settings') }}">
                    <flux:navlist.item :href="route('admin.users.show', $user->id)" wire:navigate>{{ __('Profile') }}
                    </flux:navlist.item>
                    <livewire:change-password-modal :user="$user" />
                </flux:navlist>
            </div>
        </div>

        <flux:separator vertical />

        <div class="w-full p-4 mb-4">
            <flux:heading size="xl" variant="strong"
                style="font-family: 'DM Serif Display', serif; font-style: italic;">{{ __('Profile') }}</flux:heading>

            <flux:separator variant="subtle" />


            <div class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2  p-4">
                <div>
                    <flux:heading level="3" size="sm" class="mb-1">{{ __('Name') }}</flux:heading>
                    <flux:text>{{ $user->name }}</flux:text>
                </div>
                <div>
                    <flux:heading level="3" size="sm" class="mb-1">{{ __('Second Name') }}</flux:heading>
                    <flux:text>{{ $user->second_name ?? '-' }}</flux:text>
                </div>
                <div>
                    <flux:heading level="3" size="sm" class="mb-1">{{ __('Last Name') }}</flux:heading>
                    <flux:text>{{ $user->last_name }}</flux:text>
                </div>
                <div>
                    <flux:heading level="3" size="sm" class="mb-1">{{ __('Second Last Name') }}</flux:heading>
                    <flux:text>{{ $user->second_last_name ?? 'N/A' }}</flux:text>
                </div>
                <div>
                    <flux:heading level="3" size="sm" class="mb-1">{{ __('Email') }}</flux:heading>
                    <flux:text>{{ $user->email }}</flux:text>
                </div>
                <div>
                    <flux:heading level="3" size="sm" class="mb-1">{{ __('Role') }}</flux:heading>
                    <flux:text>{{ $configuration->role->name }}</flux:text>
                </div>
            </div>
        </div>

        <flux:separator vertical />

        <div class="w-full p-4">
            <flux:heading size="xl" variant="strong"
                style="font-family: 'DM Serif Display', serif; font-style: italic;">
                Edición de perfil
            </flux:heading>

            <flux:separator variant="subtle" />

            <livewire:update-user-form :user="$user" />
        </div>

    </div>
    </div>
</x-layouts::app>