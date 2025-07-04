<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Il s\'agit d\'une zone sécurisée de l\'application. Veuillez confirmer votre mot de passe avant de continuer.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Mot de passe -->
        <div>
            <x-input-label for="password" :value="__('Mot de passe')" />

            <x-text-input id="password" class="block w-full mt-1" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4" style="background-color: #ffb700;">
            <x-primary-button>
                {{ __('Confirmer') }}
            </x-primary-button>
        </div>
    </form>

    <div class="text-center mt-8 mb-4">
        <small>Developed by Ray Ague, with Project Manager and Business Developer Abdalah KH AGUESSY-VOGNON.</small>
    </div>
</x-guest-layout>
