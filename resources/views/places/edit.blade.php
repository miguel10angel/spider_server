<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Places') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route("places.update", $place) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Name place</label>
                            <input type="text" class="form-control" name="title" required value="{{ $place->title }}">
                        </div>

                        <a href="{{ route("places") }}" class="btn btn-secondary mr-3">Back to list</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
