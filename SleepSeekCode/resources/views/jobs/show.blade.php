<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Show Job') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="mb-6 flex justify-between">
                        <h2>Show Job</h2>
                        <a style="background-color: #007BFF; color: white; padding: 10px 24px; border-radius: 50px; text-decoration: none; display: inline-block;" href="{{ route('jobs.index') }}">
                            Back
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <strong>Title:</strong>
                            {{ $job->title }}
                        </div>
                        <div class="form-group">
                            <strong>Description:</strong>
                            {{ $job->description }}
                        </div>
                        <div class="form-group">
                            <strong>Location:</strong>
                            {{ $job->location }}
                        </div>
                        <div class="form-group">
                            <strong>Start Date:</strong>
                            {{ $job->start_date }}
                        </div>
                        <div class="form-group">
                            <strong>End Date:</strong>
                            {{ $job->end_date }}
                        </div>
                        <div class="form-group">
                            <strong>Status:</strong>
                            {{ $job->status }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
