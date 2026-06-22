<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- HEADER --}}
                    <div class="mb-6 flex justify-between items-center">
                        <h1 class="text-lg font-bold">
                            Welcome back, {{ auth()->user()->name }} 👋
                        </h1>

                        <a href="{{ route('projects.create') }}"
                           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            + Create Project
                        </a>
                    </div>

                    {{-- EMPTY STATE --}}
                    @if($projects->isEmpty())
                        <div class="p-8 border rounded bg-gray-50 text-center">
                            <p class="text-gray-600 mb-4">
                                No projects yet.
                            </p>

                            <a href="{{ route('projects.create') }}"
                               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                Create your first project
                            </a>
                        </div>
                    @else

                        {{-- PROJECTS --}}
                        <div class="space-y-4">

                            @foreach($projects as $project)

                                <div class="p-5 border rounded flex justify-between items-center bg-white hover:shadow transition">

                                    <div>
                                        <h3 class="font-bold text-lg">
                                            {{ $project->name }}
                                        </h3>

                                        <p class="text-sm text-gray-600 mt-1">
                                            {{ $project->description ?: 'No description provided.' }}
                                        </p>

                                        <p class="text-xs text-gray-500 mt-2">
                                            Issues: {{ $project->issues->count() }}
                                        </p>

                                        <a href="{{ route('projects.show', $project) }}"
                                           class="text-blue-600 text-sm mt-2 inline-block">
                                            Open Project →
                                        </a>
                                    </div>

                                    {{-- ACTIONS --}}
                                    <div class="flex gap-2">

                                        <a href="{{ route('projects.edit', $project) }}"
                                           class="px-3 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                            Edit
                                        </a>

                                        <form action="{{ route('projects.destroy', $project) }}"
                                              method="POST"
                                              onsubmit="return confirm('Delete this project?')">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                class="px-3 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                                Delete
                                            </button>
                                        </form>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>