<x-layouts::auth :title="__('Register')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />
        
        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
            @csrf
            <!-- Name -->
            <div class="sm:grid sm:grid-cols-2 flex flex-col gap-6">
                <div class="flex flex-col gap-4">
                    <flux:input
                        name="name"
                        :label="__('Name')"
                        :value="old('name')"
                        type="text"
                        required
                        autofocus
                        autocomplete="name"
                        :placeholder="__('Full name')"
                    />

                    <!-- Email Address -->
                    <flux:input
                        name="email"
                        :label="__('Email address')"
                        :value="old('email')"
                        type="email"
                        required
                        autocomplete="email"
                        placeholder="email@example.com"
                    />

                    <!-- Roles -->
                    <flux:select 
                        name="role"
                        :label="__('Account role')"
                        required
                        placeholder="Select your role"
                    >
                        <option value="developer">Developer</option>
                        <option value="client">Client</option>
                    </flux:select>
                </div>

                <div class="flex flex-col gap-4">
                    <!-- Password -->
                    <flux:input
                        name="password"
                        :label="__('Password')"
                        type="password"
                        required
                        autocomplete="new-password"
                        :placeholder="__('Password')"
                        viewable
                    />

                    <!-- Confirm Password -->
                    <flux:input
                        name="password_confirmation"
                        :label="__('Confirm password')"
                        type="password"
                        required
                        autocomplete="new-password"
                        :placeholder="__('Confirm password')"
                        viewable
                    />

                    <!-- Country Selection -->
                    <flux:select 
                        name="country" 
                        :label="__('Your Country')"
                        class="w-full rounded-lg border px-3 py-2 bg-white dark:bg-zinc-900"
                        required
                    >
                        <option value="">Loading countries...</option>
                    </flux:select>
                </div>
            </div>

            <div class="flex items-center justify-end mt-auto">
                <flux:button type="submit" variant="primary" class="w-full" data-test="register-user-button">
                    {{ __('Create account') }}
                </flux:button>
            </div>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Already have an account?') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
        </div>

        <!-- restcountries api -->
        <script>
            document.addEventListener('DOMContentLoaded', async () => {
                const select = document.querySelector('select[name="country"]');

                if (!select) {
                    console.error('Select not found');
                    return;
                }

                try {
                    const res = await fetch('https://restcountries.com/v3.1/all?fields=name');

                    if (!res.ok) {
                        throw new Error(`HTTP error: ${res.status}`);
                    }

                    const countries = await res.json();

                    countries.sort((a, b) =>
                        a.name.common.localeCompare(b.name.common)
                    );

                    select.innerHTML = '<option value="">Select country</option>';

                    countries.forEach(country => {
                        const option = document.createElement('option');
                        option.value = country.name.common;
                        option.textContent = country.name.common;
                        select.appendChild(option);
                    });

                } catch (error) {
                    console.error('FETCH ERROR:', error);
                    select.innerHTML = '<option>Error loading countries</option>';
                }
            });
        </script>
    </div>
</x-layouts::auth>
