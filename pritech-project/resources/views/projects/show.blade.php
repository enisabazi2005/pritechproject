<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col gap-5">

            <div class="bg-white border border-gray-200 rounded-2xl p-8">

                <div class="flex items-start justify-between mb-6 pb-5 border-b border-gray-100">
                    <div>
                        <h2 class="text-base font-semibold text-gray-900">{{ $project->name }}</h2>
                        <p class="text-sm text-gray-400 mt-0.5">{{ $project->description ?: 'No description provided.' }}</p>
                    </div>
                    <a href="{{ route('issues.create', ['project_id' => $project->id]) }}"
                       class="inline-flex items-center justify-center h-9 px-4 text-sm font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex-shrink-0 ml-4">
                        + New issue
                    </a>
                </div>

                {{-- FILTERS --}}
                <div class="flex items-center gap-3 mb-5">

                    <select id="filterStatus"
                            class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition bg-white">
                        <option value="">All statuses</option>
                        <option value="open">Open</option>
                        <option value="in_progress">In progress</option>
                        <option value="closed">Closed</option>
                    </select>

                    <select id="filterPriority"
                            class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition bg-white">
                        <option value="">All priorities</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>

                    <select id="filterTag"
                            class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition bg-white">
                        <option value="">All tags</option>
                        @foreach(\App\Models\Tag::orderBy('name')->get() as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>

                    <button onclick="clearFilters()"
                            class="inline-flex items-center justify-center h-9 px-3 text-sm font-medium border border-gray-200 rounded-lg bg-gray-50 text-gray-500 hover:bg-gray-100 transition whitespace-nowrap">
                        Clear
                    </button>
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
                    <div id="issuesList" class="flex flex-col gap-2">
                        @foreach($project->issues as $issue)
                            <div class="issue-row flex items-center justify-between px-4 py-3 border border-gray-200 rounded-xl hover:border-gray-300 transition"
                                 data-status="{{ $issue->status }}"
                                 data-priority="{{ $issue->priority }}"
                                 data-tags="{{ $issue->tags->pluck('id')->join(',') }}">

                                <div class="flex flex-col gap-1 min-w-0 pr-6 pl-2">
                                    <span class="text-sm font-semibold text-gray-900 truncate">{{ $issue->title }}</span>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="text-xs px-2 py-0.5 rounded-full font-medium
                                            @if($issue->status === 'open') bg-green-50 text-green-600
                                            @elseif($issue->status === 'in_progress') bg-amber-50 text-amber-600
                                            @else bg-gray-100 text-gray-500
                                            @endif">
                                            {{ ucwords(str_replace('_', ' ', $issue->status)) }}
                                        </span>
                                        <span class="text-xs px-2 py-0.5 rounded-full font-medium
                                            @if($issue->priority === 'high') bg-red-50 text-red-500
                                            @elseif($issue->priority === 'medium') bg-amber-50 text-amber-600
                                            @else bg-gray-100 text-gray-500
                                            @endif">
                                            {{ ucfirst($issue->priority) }}
                                        </span>
                                        @foreach($issue->tags as $tag)
                                            <span class="text-xs px-2 py-0.5 rounded-full font-medium text-white"
                                                  style="background-color: {{ $tag->color ?? '#4f46e5' }}">
                                                {{ $tag->name }}
                                            </span>
                                        @endforeach
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

                    <p id="noResults" class="hidden text-sm text-gray-400 text-center py-8">No issues match your filters.</p>
                @endif

            </div>
        </div>
    </div>

    <script>
        const statusSelect   = document.getElementById('filterStatus');
        const prioritySelect = document.getElementById('filterPriority');
        const tagSelect      = document.getElementById('filterTag');
        const noResults      = document.getElementById('noResults');

        function applyFilters() {
            const status   = statusSelect.value;
            const priority = prioritySelect.value;
            const tag      = tagSelect.value;
            const rows     = document.querySelectorAll('.issue-row');
            let visible    = 0;

            rows.forEach(row => {
                const matchStatus   = !status   || row.dataset.status === status;
                const matchPriority = !priority || row.dataset.priority === priority;
                const matchTag      = !tag      || row.dataset.tags.split(',').includes(tag);

                if (matchStatus && matchPriority && matchTag) {
                    row.style.display = '';
                    visible++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (noResults) noResults.classList.toggle('hidden', visible > 0);
        }

        function clearFilters() {
            statusSelect.value   = '';
            prioritySelect.value = '';
            tagSelect.value      = '';
            applyFilters();
        }

        statusSelect.addEventListener('change', applyFilters);
        prioritySelect.addEventListener('change', applyFilters);
        tagSelect.addEventListener('change', applyFilters);
    </script>

</x-app-layout>