<?php

use App\Concerns\ProfileValidationRules;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Profile settings')] class extends Component {
    use ProfileValidationRules;

    public string $name = '';
    public string $email = '';
    public string $role = '';
    public string $country = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->role = Auth::user()->role ?? '';
        $this->country = Auth::user()->country ?? '';
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate($this->profileRules($user->id));

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        Flux::toast(variant: 'success', text: __('Profile updated.'));
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Flux::toast(text: __('A new verification link has been sent to your email address.'));
    }

    #[Computed]
    public function hasUnverifiedEmail(): bool
    {
        return Auth::user() instanceof MustVerifyEmail && ! Auth::user()->hasVerifiedEmail();
    }

    #[Computed]
    public function showDeleteUser(): bool
    {
        return ! Auth::user() instanceof MustVerifyEmail
            || (Auth::user() instanceof MustVerifyEmail && Auth::user()->hasVerifiedEmail());
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Profile settings') }}</flux:heading>

    <x-pages::settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                @if ($this->hasUnverifiedEmail)
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>

                    </div>
                @endif
            </div>

            <!-- Roles -->
            <flux:select 
                wire:model="role"
                name="role"
                :label="__('Account role')"
                required
                placeholder="Select your role"
            >
                <option value="developer">Developer</option>
                <option value="client">Client</option>
            </flux:select>

            <!-- Country Selection -->
            <flux:select 
                wire:model="country"
                name="country" 
                :label="__('Your Country')"
                class="w-full rounded-lg border px-3 py-2 bg-white dark:bg-zinc-900"
                required
            >
                <option value="">Loading countries...</option>
            </flux:select>

            <div class="flex items-center gap-4">
                <flux:button variant="primary" type="submit" data-test="update-profile-button">
                    {{ __('Save') }}
                </flux:button>
            </div>
        </form>

        @if ($this->showDeleteUser)
            <livewire:pages::settings.delete-user-form />
        @endif
    </x-pages::settings.layout>

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
</section>
