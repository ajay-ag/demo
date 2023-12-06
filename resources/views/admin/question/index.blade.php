<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Question') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-2">
                <x-link-button class="ms-3" href="{{ route('question.create') }}">
                    {{ __('Add Question') }}
                </x-link-button>

            </div>
            <div class="mb-2">
                <x-alert type="success" />
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Question
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <span class="sr-only">#</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($questions as $item)
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->question ?? 'N/A' }}
                                </th>
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">

                                    <span
                                        class="bg-indigo-100 text-indigo-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-indigo-900 dark:text-indigo-300">{{ $item->status }}</span>

                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('question.edit', ['question' => $item->id]) }}"
                                            class="font-medium text-indigo-600 dark:text-indigo-500 hover:underline update-category">
                                            Edit
                                        </a>

                                        <form method="POST" action="{{ route('question.destroy', $item->id) }}"
                                            id="deleteForm">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this record !');"
                                                class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="my-2 px-2">
                    {{ $questions->links() }}
                </div>
            </div>
        </div>
    </div>

    </div>


    <x-slot name="scripts">
    </x-slot>

</x-app-layout>
