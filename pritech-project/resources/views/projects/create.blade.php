<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl p-8">

                <div class="mb-6 pb-5 border-b border-gray-100">
                    <h2 class="text-base font-semibold text-gray-900">New project</h2>
                    <p class="text-sm text-gray-400 mt-0.5">Fill in the details below to create a new project.</p>
                </div>

                <form method="POST" action="{{ route('projects.store') }}">
                    @csrf

                    <div class="flex flex-col gap-5">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Project name</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   placeholder="e.g. Marketing Site Redesign"
                                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
                            <textarea name="description" rows="4"
                                      placeholder="What is this project about?"
                                      class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-2 pt-4 border-t border-gray-100">
                            <button type="submit"
                                    class="inline-flex items-center justify-center h-9 px-4 text-sm font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                Create project
                            </button>
                            <a href="{{ route('dashboard') }}"
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