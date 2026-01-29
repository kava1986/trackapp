<x-app-layout>
<form action="{{ route('tracking.store') }}" method="POST" class="space-y-4 mt-4">
    @csrf
    
    <div>
        <label for="description_1" class="block text-sm font-medium text-gray-700 mb-1">
            Description 1
        </label>
        <input type="text" id="description_1" name="description_1" 
               class="border p-2 w-full rounded" placeholder="Enter description 1">
    </div>

    <div>
        <label for="description_2" class="block text-sm font-medium text-gray-700 mb-1">
            Description 2
        </label>
        <input type="text" id="description_2" name="description_2" 
               class="border p-2 w-full rounded" placeholder="Enter description 2">
    </div>

    <div>
        <label for="description_3" class="block text-sm font-medium text-gray-700 mb-1">
            Description 3
        </label>
        <input type="text" id="description_3" name="description_3" 
               class="border p-2 w-full rounded" placeholder="Enter description 3">
    </div>

    <div>
        <button type="submit" 
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Generate Tracking Code
        </button>
    </div>
</form>
</x-app-layout>