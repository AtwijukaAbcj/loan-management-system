<x-filament::page>
    <div class="max-w-xl mx-auto">
        <h2 class="text-2xl font-bold mb-4">Pesapal API Settings</h2>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form wire:submit.prevent="save">
            <div class="mb-4">
                <label for="consumer_key" class="block font-medium">Consumer Key</label>
                <input type="text" id="consumer_key" wire:model.defer="consumer_key" class="form-input w-full" required>
            </div>
            <div class="mb-4">
                <label for="consumer_secret" class="block font-medium">Consumer Secret</label>
                <input type="text" id="consumer_secret" wire:model.defer="consumer_secret" class="form-input w-full" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</x-filament::page>
