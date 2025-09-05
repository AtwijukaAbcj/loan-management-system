<x-filament::page>
    <div class="max-w-2xl mx-auto bg-white shadow rounded-lg p-8">
        <h2 class="text-3xl font-bold mb-6 text-gray-800 flex items-center">
            <x-filament::icon name="heroicon-o-cog" class="w-7 h-7 mr-2 text-primary-600" /> Pesapal API Settings
        </h2>
        @if(session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>
        @endif
        <form wire:submit.prevent="save" class="space-y-6">
            <div>
                <label for="consumer_key" class="block font-semibold text-gray-700">Consumer Key</label>
                <input type="text" id="consumer_key" wire:model.defer="consumer_key" class="form-input w-full border-gray-300 rounded" required>
            </div>
            <div>
                <label for="consumer_secret" class="block font-semibold text-gray-700">Consumer Secret</label>
                <input type="text" id="consumer_secret" wire:model.defer="consumer_secret" class="form-input w-full border-gray-300 rounded" required>
            </div>
            <div class="flex gap-4">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" wire:click="testKeys" class="btn btn-secondary">Test Keys</button>
            </div>
        </form>
        @if($test_result)
            <div class="mt-6 p-3 rounded bg-blue-100 text-blue-800">{{ $test_result }}</div>
        @endif
    </div>
</x-filament::page>
