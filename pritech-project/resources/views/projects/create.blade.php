<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Project
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded shadow">

                <form method="POST" action="{{ route('projects.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label>Project Name</label>
                        <input name="name" class="w-full border p-2 rounded">
                    </div>

                    <div class="mb-4">
                        <label>Description</label>
                        <textarea name="description" class="w-full border p-2 rounded"></textarea>
                    </div>

                    <button class="bg-blue-600 text-black px-4 py-2 rounded border border-gray-200">
                        Create
                    </button>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>