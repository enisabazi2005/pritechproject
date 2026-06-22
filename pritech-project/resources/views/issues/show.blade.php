<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">
                {{ $issue->title }}
            </h2>

            <div class="flex gap-2">

                <a href="{{ route('issues.edit', $issue) }}" class="bg-yellow-500 text-black px-3 py-2 rounded">
                    Edit
                </a>

                <form action="{{ route('issues.destroy', $issue) }}" method="POST"
                    onsubmit="return confirm('Delete this issue?')">

                    @csrf
                    @method('DELETE')

                    <button class="bg-red-600 text-black px-3 py-2 rounded">
                        Delete
                    </button>

                </form>

            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto space-y-6">

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

                @if ($issue->due_date)
                    <div>
                        <span class="font-bold">Due:</span>
                        {{ $issue->due_date }}
                    </div>
                @endif

            </div>

            <div class="mt-4">
                <a href="{{ route('projects.show', $issue->project) }}" class="text-blue-600 text-sm">
                    ← Back to Project
                </a>
            </div>

        </div>

        <div class="bg-white p-6 rounded shadow">
            <h3 class="font-bold mb-3">Tags</h3>

            <form method="POST" action="{{ route('tags.store') }}" class="flex gap-2 mb-4">
                @csrf

                <input type="text" name="name" placeholder="New tag name" class="border p-2 rounded w-full">

                <input type="color" name="color" class="w-12 h-10 border rounded">

                <button class="bg-green-600 text-black px-4 py-2 rounded">
                    Create
                </button>
            </form>

            <div class="flex flex-wrap gap-2 mb-4">
                @foreach ($issue->tags as $tag)
                    <div class="flex items-center gap-1 px-3 py-1 rounded text-white"
                        style="background-color: {{ $tag->color ?? '#3490dc' }}">

                        <span>{{ $tag->name }}</span>

                        <button onclick="detachTag({{ $tag->id }})" class="ml-2 text-white font-bold">
                            ×
                        </button>

                    </div>
                @endforeach
            </div>

            <div class="flex gap-2">
                <select id="tagSelect" class="border p-2 w-full">
                    @foreach (\App\Models\Tag::all() as $tag)
                        <option value="{{ $tag->id }}">
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>

                <button onclick="attachTag()" class="bg-blue-600 text-black px-4 py-2 rounded border border-gray-300">
                    Attach
                </button>
            </div>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <h3 class="font-bold mb-4">Comments</h3>

            {{-- COMMENT FORM --}}
            <div class="space-y-2 mb-4">
                <input id="author_name" type="text" placeholder="Your name" class="border p-2 w-full">

                <textarea id="comment_body" placeholder="Write comment..." class="border p-2 w-full"></textarea>

                <button onclick="sendComment()" class="bg-blue-600 text-black px-4 py-2 rounded border border-gray-300">
                    Add Comment
                </button>
            </div>

            {{-- COMMENTS LIST --}}
            <div id="commentsList" class="space-y-3"></div>

            <button onclick="loadComments()" class="mt-4 text-blue-600">
                Load Comments
            </button>
        </div>

    </div>
</x-app-layout>

<script>
    function attachTag() {
        let tagId = document.getElementById('tagSelect').value;

        fetch(`/issues/{{ $issue->id }}/attach-tag`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    tag_id: tagId
                })
            })
            .then(res => res.json())
            .then(data => {
                location.reload();
            });
    }

    function detachTag(tagId) {
        fetch(`/issues/{{ $issue->id }}/detach-tag`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    tag_id: tagId
                })
            })
            .then(res => res.json())
            .then(() => {
                location.reload();
            });
    }

    function loadComments() {
        fetch(`/issues/{{ $issue->id }}/comments`)
            .then(res => res.json())
            .then(data => {
                let html = '';

                data.data.forEach(comment => {
                    html += `
                    <div class="border p-3 rounded">
                        <div class="font-bold">${comment.author_name}</div>
                        <div>${comment.body}</div>
                    </div>
                `;
                });

                document.getElementById('commentsList').innerHTML = html;
            });
    }

    function sendComment() {
        let author = document.getElementById('author_name').value;
        let body = document.getElementById('comment_body').value;

        fetch(`/issues/{{ $issue->id }}/comments`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    author_name: author,
                    body: body
                })
            })
            .then(res => res.json())
            .then(comment => {

                let newComment = `
            <div class="border p-3 rounded">
                <div class="font-bold">${comment.author_name}</div>
                <div>${comment.body}</div>
            </div>
        `;

                document.getElementById('commentsList')
                    .insertAdjacentHTML('afterbegin', newComment);

                document.getElementById('author_name').value = '';
                document.getElementById('comment_body').value = '';
            });
    }

    // auto load on page open
    loadComments();
</script>
