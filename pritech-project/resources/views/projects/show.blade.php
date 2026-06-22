<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            {{ $project->name }}
        </h2>
    </x-slot>

    <div class="p-6">

        <p class="mb-4">{{ $project->description }}</p>

        <a href="{{ route('issues.create', ['project_id' => $project->id]) }}"
           class="bg-blue-600 text-black px-4 py-2 rounded border border-gray-300">
            + Create Issue
        </a>

        <hr class="my-4">

        @if($project->issues->isEmpty())
            <p>No issues yet.</p>
        @else
            @foreach($project->issues as $issue)
                <div class="border p-3 mb-2">
                    <h3 class="font-bold">{{ $issue->title }}</h3>

                    <p>Status: {{ ucwords(str_replace('_', ' ', $issue->status)) }}</p>
                    <p>Priority: {{ $issue->priority }}</p>

                    <a href="{{ route('issues.show', $issue->id) }}"
                       class="text-blue-600">
                        View
                    </a>
                    <a href="{{ route('issues.edit', $issue) }}"
                        class="px-3 py-1 bg-yellow-500 text-blue rounded border border-gray-300">
                        Edit
                    </a>
                
                    <form action="{{ route('issues.destroy', $issue) }}"
                        method="POST"
                        onsubmit="return confirm('Delete this issue?')">
                
                        @csrf
                        @method('DELETE')
                
                        <button
                            class="px-3 py-1 bg-red-600 text-white rounded">
                            Delete
                        </button>
                    </form>
                </div>
            @endforeach
        @endif

    </div>
</x-app-layout>