<x-app-layout>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col gap-5">

            {{-- ISSUE HEADER --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-8">
                <div class="flex items-start justify-between mb-6 pb-5 border-b border-gray-100">
                    <div>
                        <p class="text-xs text-gray-400 mb-1">
                            <a href="{{ route('projects.show', $issue->project) }}" class="hover:text-indigo-600 transition">
                                ← {{ $issue->project->name }}
                            </a>
                        </p>
                        <h2 class="text-base font-semibold text-gray-900">Issue: {{ $issue->title }}</h2>
                        <p class="text-sm text-gray-400 mt-0.5">Issue description: {{ $issue->description ?? 'No description provided.' }}</p>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0 ml-4">
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

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="bg-gray-50 border border-gray-100 rounded-xl px-4 py-3">
                        <p class="text-xs text-gray-400 mb-1">Status</p>
                        <span class="text-xs font-medium px-2 py-0.5 rounded-full
                            @if($issue->status === 'open') bg-green-50 text-green-600
                            @elseif($issue->status === 'in_progress') bg-amber-50 text-amber-600
                            @else bg-gray-100 text-gray-500
                            @endif">
                            {{ ucwords(str_replace('_', ' ', $issue->status)) }}
                        </span>
                    </div>

                    <div class="bg-gray-50 border border-gray-100 rounded-xl px-4 py-3">
                        <p class="text-xs text-gray-400 mb-1">Priority</p>
                        <span class="text-xs font-medium px-2 py-0.5 rounded-full
                            @if($issue->priority === 'high') bg-red-50 text-red-500
                            @elseif($issue->priority === 'medium') bg-amber-50 text-amber-600
                            @else bg-gray-100 text-gray-500
                            @endif">
                            {{ ucfirst($issue->priority) }}
                        </span>
                    </div>

                    <div class="bg-gray-50 border border-gray-100 rounded-xl px-4 py-3">
                        <p class="text-xs text-gray-400 mb-1">Due date</p>
                        <p class="text-xs font-medium text-gray-700">{{ $issue->due_date ? \Carbon\Carbon::parse($issue->due_date)->format('M d, Y') : '—' }}</p>
                    </div>

                    <div class="bg-gray-50 border border-gray-100 rounded-xl px-4 py-3">
                        <p class="text-xs text-gray-400 mb-1">Project</p>
                        <p class="text-xs font-medium text-gray-700 truncate">{{ $issue->project->name }}</p>
                    </div>
                </div>
            </div>

            {{-- TAGS --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-8">
                <div class="mb-5 pb-4 border-b border-gray-100">
                    <h3 class="text-base font-semibold text-gray-900">Tags</h3>
                    <p class="text-sm text-gray-400 mt-0.5">Create a new tag or attach an existing one to this issue.</p>
                </div>

                <form method="POST" action="{{ route('tags.store') }}" class="flex gap-2 mb-5">
                    @csrf
                    <input type="text" name="name" placeholder="New tag name"
                           class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                    <input type="color" name="color"
                           class="w-10 h-9 border border-gray-200 rounded-lg cursor-pointer p-0.5">
                    <button type="submit"
                            class="inline-flex items-center justify-center h-9 px-4 text-sm font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Create
                    </button>
                </form>

                <div class="flex flex-wrap gap-2 mb-5">
                    @forelse($issue->tags as $tag)
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium text-white"
                             style="background-color: {{ $tag->color ?? '#4f46e5' }}">
                            {{ $tag->name }}
                            <button onclick="detachTag({{ $tag->id }})"
                                    class="ml-0.5 opacity-75 hover:opacity-100 font-bold leading-none">×</button>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">No tags attached yet.</p>
                    @endforelse
                </div>

                <div class="flex gap-2">
                    <select id="tagSelect"
                            class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition bg-white">
                        @foreach(\App\Models\Tag::all() as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                    <button onclick="attachTag()"
                            class="inline-flex items-center justify-center h-9 px-4 text-sm font-medium border border-gray-200 rounded-lg bg-gray-50 text-gray-700 hover:bg-gray-100 transition">
                        Attach
                    </button>
                </div>
            </div>

            {{-- COMMENTS --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-8">
                <div class="mb-5 pb-4 border-b border-gray-100">
                    <h3 class="text-base font-semibold text-gray-900">Comments</h3>
                    <p class="text-sm text-gray-400 mt-0.5">Leave a comment on this issue.</p>
                </div>

                <div class="flex flex-col gap-3 mb-5">
                    <input id="author_name" type="text" placeholder="Your name"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                    <textarea id="comment_body" placeholder="Write a comment..." rows="3"
                              class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none"></textarea>
                    <div id="comment_errors" class="hidden">
                        <p id="author_error" class="text-red-500 text-xs hidden"></p>
                        <p id="body_error" class="text-red-500 text-xs hidden"></p>
                    </div>
                    <div>
                        <button onclick="sendComment()"
                                class="inline-flex items-center justify-center h-9 px-4 text-sm font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            Add comment
                        </button>
                    </div>
                </div>

                <div id="commentsList" class="flex flex-col gap-3"></div>
            </div>

        </div>
    </div>

</x-app-layout>

<script>
    function attachTag() {
        let tagId = document.getElementById('tagSelect').value;
        fetch(`/issues/{{ $issue->id }}/attach-tag`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ tag_id: tagId })
        }).then(() => location.reload());
    }

    function detachTag(tagId) {
        fetch(`/issues/{{ $issue->id }}/detach-tag`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ tag_id: tagId })
        }).then(() => location.reload());
    }

    function loadComments() {
        fetch(`/issues/{{ $issue->id }}/comments`)
            .then(res => res.json())
            .then(data => {
                const list = document.getElementById('commentsList');
                if (data.data.length === 0) {
                    list.innerHTML = '<p class="text-sm text-gray-400">No comments yet.</p>';
                    return;
                }
                list.innerHTML = data.data.map(comment => `
                    <div class="border border-gray-100 bg-gray-50 rounded-xl px-4 py-3">
                        <p class="text-xs font-semibold text-gray-700 mb-1">${comment.author_name}</p>
                        <p class="text-sm text-gray-600">${comment.body}</p>
                    </div>
                `).join('');
            });
    }

    function sendComment() {
        const author = document.getElementById('author_name').value.trim();
        const body = document.getElementById('comment_body').value.trim();
        const authorErr = document.getElementById('author_error');
        const bodyErr = document.getElementById('body_error');

        authorErr.classList.add('hidden');
        bodyErr.classList.add('hidden');

        let valid = true;
        if (!author) { authorErr.textContent = 'Name is required.'; authorErr.classList.remove('hidden'); valid = false; }
        if (!body) { bodyErr.textContent = 'Comment cannot be empty.'; bodyErr.classList.remove('hidden'); valid = false; }
        if (!valid) return;

        fetch(`/issues/{{ $issue->id }}/comments`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ author_name: author, body: body })
        })
        .then(res => res.json())
        .then(comment => {
            const newComment = `
                <div class="border border-gray-100 bg-gray-50 rounded-xl px-4 py-3">
                    <p class="text-xs font-semibold text-gray-700 mb-1">${comment.author_name}</p>
                    <p class="text-sm text-gray-600">${comment.body}</p>
                </div>
            `;
            document.getElementById('commentsList').insertAdjacentHTML('afterbegin', newComment);
            document.getElementById('author_name').value = '';
            document.getElementById('comment_body').value = '';
        });
    }

    loadComments();
</script>