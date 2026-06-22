<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Issue
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl p-8">

                <div class="mb-6 pb-5 border-b border-gray-100">
                    <h2 class="text-base font-semibold text-gray-900">Edit issue</h2>
                    <p class="text-sm text-gray-400 mt-0.5">Update the details for this issue.</p>
                </div>

                <form action="{{ route('issues.update', $issue) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col gap-5">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Title</label>
                            <input type="text" name="title" value="{{ old('title', $issue->title) }}"
                                   placeholder="Short summary of the issue"
                                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            @error('title')
                                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
                            <textarea name="description" rows="4"
                                      placeholder="What's the issue about?"
                                      class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none">{{ old('description', $issue->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Status</label>
                                <select name="status"
                                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition bg-white">
                                    <option value="open" {{ old('status', $issue->status) === 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="in_progress" {{ old('status', $issue->status) === 'in_progress' ? 'selected' : '' }}>In progress</option>
                                    <option value="closed" {{ old('status', $issue->status) === 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Priority</label>
                                <select name="priority"
                                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition bg-white">
                                    <option value="low" {{ old('priority', $issue->priority) === 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ old('priority', $issue->priority) === 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ old('priority', $issue->priority) === 'high' ? 'selected' : '' }}>High</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Due date</label>
                            <input type="date" name="due_date" value="{{ old('due_date', $issue->due_date) }}"
                                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        </div>

                        <div class="flex items-center gap-2 pt-4 border-t border-gray-100">
                            <button type="submit"
                                    class="inline-flex items-center justify-center h-9 px-4 text-sm font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                Save changes
                            </button>
                            <a href="{{ route('projects.show', $issue->project) }}"
                               class="inline-flex items-center justify-center h-9 px-4 text-sm font-medium border border-gray-200 rounded-lg bg-gray-50 text-gray-600 hover:bg-gray-100 transition">
                                Cancel
                            </a>
                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>