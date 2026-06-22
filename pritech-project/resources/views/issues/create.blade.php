<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Create Issue
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <div class="bg-white p-6 rounded shadow">

            <form action="{{ route('issues.store') }}" method="POST">
                @csrf

                <input type="hidden"
                       name="project_id"
                       value="{{ $project->id }}">

                <div class="mb-4">
                    <label class="block font-medium mb-1">
                        Title
                    </label>

                    <input type="text"
                           name="title"
                           value="{{ old('title') }}"
                           class="w-full border rounded p-2">

                    @error('title')
                        <p class="text-red-500 text-sm">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">
                        Description
                    </label>

                    <textarea name="description"
                              rows="5"
                              class="w-full border rounded p-2">{{ old('description') }}</textarea>

                    @error('description')
                        <p class="text-red-500 text-sm">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">
                        Status
                    </label>

                    <select name="status"
                            class="w-full border rounded p-2">

                        <option value="open">Open</option>
                        <option value="in_progress">In Progress</option>
                        <option value="closed">Closed</option>

                    </select>
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">
                        Priority
                    </label>

                    <select name="priority"
                            class="w-full border rounded p-2">

                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>

                    </select>
                </div>

                <div class="mb-6">
                    <label class="block font-medium mb-1">
                        Due Date
                    </label>

                    <input type="date"
                           name="due_date"
                           value="{{ old('due_date') }}"
                           class="w-full border rounded p-2">
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                            class="bg-blue-600 text-black px-4 py-2 rounded border border-gray-300">
                        Create Issue
                    </button>

                    <a href="{{ route('projects.show', $project) }}"
                       class="bg-gray-300 px-4 py-2 rounded">
                        Cancel
                    </a>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>