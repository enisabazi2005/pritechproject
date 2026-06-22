<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white border border-gray-200 rounded-2xl p-8">

                <div class="flex items-start justify-between mb-6 pb-5 border-b border-gray-100">
                    <div>
                        <h2 class="text-base font-semibold text-gray-900">Project Name: {{ $project->name }}</h2>
                        <p class="text-sm text-gray-400 mt-0.5">Project Description: {{ $project->description ?: 'No description provided.' }}</p>
                    </div>
                    <a href="{{ route('issues.create', ['project_id' => $project->id]) }}"
                       class="inline-flex items-center justify-center h-9 px-4 text-sm font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex-shrink-0 ml-4">
                        + New issue
                    </a>
                </div>

                @if($project->issues->isEmpty())
                    <div class="py-12 border border-dashed border-gray-200 rounded-xl text-center">
                        <p class="text-sm text-gray-400 mb-4">No issues yet for this project.</p>
                        <a href="{{ route('issues.create', ['project_id' => $project->id]) }}"
                           class="inline-flex items-center justify-center h-9 px-4 text-sm font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            + Create first issue
                        </a>
                    </div>
                @else
                    <div class="flex flex-col gap-2">
                        @foreach($project->issues as $issue)
                            <div class="flex items-center justify-between px-4 py-3 border border-gray-200 rounded-xl hover:border-gray-300 transition">

                                <div class="flex flex-col gap-1 min-w-0 pr-6 pl-2">
                                    <span class="text-sm font-semibold text-gray-900 truncate">{{ $issue->title }}</span>
                                    <div class="flex items-center gap-2">

                                        <span class="text-xs px-2 py-0.5 rounded-full font-medium
                                            @if($issue->status === 'open') bg-green-50 text-green-600
                                            @elseif($issue->status === 'in_progress') bg-amber-50 text-amber-600
                                            @else bg-gray-100 text-gray-500
                                            @endif">
                                            Status: {{ ucwords(str_replace('_', ' ', $issue->status)) }}
                                        </span>

                                        <span class="text-xs px-2 py-0.5 rounded-full font-medium
                                            @if($issue->priority === 'high') bg-red-50 text-red-500
                                            @elseif($issue->priority === 'medium') bg-amber-50 text-amber-600
                                            @else bg-gray-100 text-gray-500
                                            @endif">
                                            Priority: {{ ucfirst($issue->priority) }}
                                        </span>

                                    </div>
                                </div>

                                <div class="flex items-center gap-2 flex-shrink-0">
                                    <a href="{{ route('issues.show', $issue->id) }}"
                                       class="inline-flex items-center justify-center h-8 px-3 text-xs font-medium border border-gray-200 rounded-lg bg-gray-50 text-gray-600 hover:bg-gray-100 transition">
                                        View
                                    </a>
                                    <a href="{{ route('issues.edit', $issue) }}"
                                       class="inline-flex items-center justify-center h-8 px-3 text-xs font-medium border border-gray-200 rounded-lg bg-gray-50 text-gray-600 hover:bg-gray-100 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('issues.destroy', $issue) }}" method="POST"
                                          onsubmit="return confirm('Delete this issue?')" class="contents">
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
</x-app-layout>