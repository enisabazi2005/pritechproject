<x-app-layout>

    <div class="py-12 px-4 sm:px-6 lg:px-8 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto">
            <div style="padding:20px" class="bg-white rounded-2xl shadow-lg border border-gray-100 p-3">    
                <div class="pb-6 mb-8 border-b border-gray-100">
                    <h2 class="text-xl font-semibold text-gray-900">
                        Project Details
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Update the name and description for this project.
                    </p>
                </div>
    
                <form method="POST" action="{{ route('projects.update', $project->id) }}">
                    @csrf
                    @method('PUT')
    
                    <div class="space-y-6">
    
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Project Name
                            </label>
    
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $project->name) }}"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                            >
    
                            @error('name')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
    
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Description
                            </label>
    
                            <textarea
                                name="description"
                                rows="5"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 resize-none focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                            >{{ old('description', $project->description) }}</textarea>
    
                            @error('description')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
    
                        <div style="display:flex; column-gap:30px;" class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100">
    
                            <a style="padding:5px"
                                href="{{ route('dashboard') }}"
                                class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition rounded"
                            >
                                Cancel
                            </a>
    
                            <button style="padding:5px;"
                                type="submit"
                                class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition shadow-sm border border-gray-300 rounded"
                            >
                                Save Changes
                            </button>
    
                        </div>
    
                    </div>
                </form>
    
            </div>
        </div>
    </div>
</x-app-layout>