<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Project
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 shadow-sm rounded-lg">

                <form method="POST"
                      action="{{ route('projects.update', $project->id) }}">
                    @csrf
                    @method('PUT')

                    {{-- NAME --}}
                    <div class="mb-4">
                        <label class="block font-medium">Project Name</label>
                        <input type="text" name="name"
                               class="w-full border rounded p-2"
                               value="{{ old('name', $project->name) }}">

                        @error('name')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- DESCRIPTION --}}
                    <div class="mb-4">
                        <label class="block font-medium">Description</label>
                        <textarea name="description"
                                  class="w-full border rounded p-2">{{ old('description', $project->description) }}</textarea>

                        @error('description')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-2">
                        <button class="bg-green-600 text-white px-4 py-2 rounded">
                            Update
                        </button>

                        <a href="{{ route('dashboard') }}"
                           class="px-4 py-2 bg-gray-300 rounded">
                            Cancel
                        </a>
                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>