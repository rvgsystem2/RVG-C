<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            {{ isset($career) ? 'Edit Job' : 'Add New Job' }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <form method="POST" action="{{ isset($career) ? route('careers.update', $career) : route('careers.store') }}">
    @csrf
   

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Title -->
        <div>
            <label class="block font-medium mb-1">Title</label>
            <input type="text" name="title" value="{{ old('title', $career->title ?? '') }}" required class="w-full px-4 py-2 border rounded">
        </div>

        <!-- Location -->
        <div>
            <label class="block font-medium mb-1">Location</label>
            <input type="text" name="location" value="{{ old('location', $career->location ?? 'Kanpur') }}" class="w-full px-4 py-2 border rounded">
        </div>

        <!-- Type -->
        <div>
            <label class="block font-medium mb-1">Type</label>
            <select name="type" class="w-full px-4 py-2 border rounded" required>
                @foreach(['Full Time', 'Part Time', 'Internship', 'Contract'] as $type)
                    <option value="{{ $type }}" @selected(old('type', $career->type ?? '') == $type)>{{ $type }}</option>
                @endforeach
            </select>
        </div>

        <!-- Experience -->
        <div>
            <label class="block font-medium mb-1">Experience (Years)</label>
            <input type="number" name="experience" min="0" value="{{ old('experience', $career->experience ?? '') }}" class="w-full px-4 py-2 border rounded">
        </div>

        <!-- Valid Through -->
        <div>
            <label class="block font-medium mb-1">Valid Through</label>
            <input type="date" name="valid_through" value="{{ old('valid_through', $career->valid_through ?? '') }}" class="w-full px-4 py-2 border rounded">
        </div>

        <!-- Status -->
        <div>
            <label class="block font-medium mb-1">Status</label>
            <select name="status" class="w-full px-4 py-2 border rounded" required>
                <option value="active" @selected(old('status', $career->status ?? '') == 'active')>Active</option>
                <option value="inactive" @selected(old('status', $career->status ?? '') == 'inactive')>Inactive</option>
            </select>
        </div>
    </div>

    <!-- Description -->
    <div class="mt-4">
        <label class="block font-medium mb-1">Description</label>
        <textarea name="description" rows="5" class="w-full px-4 py-2 border rounded">{{ old('description', $career->description ?? '') }}</textarea>
    </div>

    <!-- Submit Button -->
     <div class="mt-6">
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            {{ isset($career) ? 'Update Job' : 'Add Job' }}
        </button>
    </div>
</x-app-layout>
