<x-guest-layout>
    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf

        <!-- subject -->
        <div>
            <x-input-label for="subject" :value="__('Subject')" />
            <x-text-input id="subject" class="block mt-1 w-full" type="text" name="subject" :value="old('subject')" required autofocus autocomplete="subject" />
            <x-input-error :messages="$errors->get('subject')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="description" :value="__('Description')" />
            <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description')" required autocomplete="description" />
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="deadline" :value="__('Deadline')" />
            <x-text-input id="deadline" class="block mt-1 w-full" type="datetime-local" name="deadline" required autocomplete="deadline" />
            <x-input-error :messages="$errors->get('deadline')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Create') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
