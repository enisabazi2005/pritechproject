<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">
                {{ $issue->title }}
            </h2>

            <div class="flex gap-2">

                <a href="{{ route('issues.edit', $issue) }}"
                   class="bg-yellow-500 text-white px-3 py-2 rounded">
                    Edit
                </a>

                <form action="{{ route('issues.destroy', $issue) }}"
                      method="POST"
                      onsubmit="return confirm('Delete this issue?')">

                    @csrf
                    @method('DELETE')

                    <button class="bg-red-600 text-white px-3 py-2 rounded">
                        Delete
                    </button>

                </form>

            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto space-y-6">

        {{-- ISSUE INFO --}}
        <div class="bg-white p-6 rounded shadow">

            <p class="text-gray-600 mb-4">
                {{ $issue->description ?? 'No description provided.' }}
            </p>

            <div class="flex gap-4 text-sm text-gray-700">

                <div>
                    <span class="font-bold">Status:</span>
                    {{ ucfirst($issue->status) }}
                </div>

                <div>
                    <span class="font-bold">Priority:</span>
                    {{ ucfirst($issue->priority) }}
                </div>

                @if($issue->due_date)
                    <div>
                        <span class="font-bold">Due:</span>
                        {{ $issue->due_date }}
                    </div>
                @endif

            </div>

            <div class="mt-4">
                <a href="{{ route('projects.show', $issue->project) }}"
                   class="text-blue-600 text-sm">
                    ← Back to Project
                </a>
            </div>

        </div>

        <div class="bg-white p-6 rounded shadow">
            <h3 class="font-bold mb-2">Tags</h3>

            <p class="text-gray-500 text-sm">
                (Next step: AJAX attach/detach tags here)
            </p>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <h3 class="font-bold mb-4">Comments</h3>

            <p class="text-gray-500 text-sm">
                (Next step: AJAX comments with pagination)
            </p>
        </div>

    </div>
</x-app-layout>