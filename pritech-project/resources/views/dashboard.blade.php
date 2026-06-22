<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <div class="mb-6 flex justify-between items-center">
                        <div>
                            <h1 class="text-lg font-semibold text-gray-900">
                                Welcome back, {{ auth()->user()->name }} 👋
                            </h1>
                            <p class="text-sm text-gray-400 mt-0.5">Manage your projects below</p>
                        </div>

                        <a href="{{ route('projects.create') }}"
                           class="inline-flex items-center gap-1 bg-indigo-600 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                            + New project
                        </a>
                    </div>

                    @if($projects->isEmpty())
                        <div class="py-12 border border-dashed border-gray-200 rounded-xl text-center">
                            <p class="text-sm text-gray-400 mb-4">No projects yet.</p>
                            <a href="{{ route('projects.create') }}"
                               class="inline-flex items-center gap-1 bg-indigo-600 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                                + Create your first project
                            </a>
                        </div>
                    @else
                        <div class="flex flex-col gap-2">
                            @foreach($projects as $project)
                                <div style="padding: 30px;" class="flex items-center justify-between px-10 py-4 border border-gray-200 rounded-xl hover:border-gray-300 transition">

                                    <div class="flex flex-col gap-1 min-w-0 pr-6">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-block py-2 text-m font-semibold text-gray-900 truncate">
                                                {{ $project->name }}
                                            </span>
                                            <span class="text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full whitespace-nowrap flex-shrink-0">
                                                {{ $project->issues->count() }} issues
                                            </span>
                                        </div>

                                        <span class="inline-block py-2 text-sm font-semibold text-gray-900 truncate">
                                            {{ $project->description ?: 'No description provided.' }}
                                        </p>

                                        <a href="{{ route('projects.show', $project) }}"
                                           class="text-xs text-indigo-600 font-medium hover:text-indigo-800 w-fit transition">
                                            Open project →
                                        </a>
                                    </div>

                                    <div class="flex items-center gap-2 flex-shrink-0">
                                        <a href="{{ route('projects.edit', $project) }}"
                                           class="inline-flex items-center justify-center h-8 px-3 text-xs font-medium border border-gray-200 rounded-lg bg-gray-50 text-gray-600 hover:bg-gray-100 transition">
                                            Edit
                                        </a>

                                        <form action="{{ route('projects.destroy', $project) }}" method="POST"
                                              onsubmit="return confirm('Delete this project?')" class="contents">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center justify-center h-8 px-3 text-xs font-medium border border-red-200 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition">
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