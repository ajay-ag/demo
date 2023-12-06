<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Question') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="handler()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-2">
                <x-link-button class="ms-3" href="{{ route('question.index') }}">
                    {{ __('Back') }}
                </x-link-button>

            </div>
            <form @submit.prevent="saveQuestion()">
                <div class="mb-2">
                    <x-alert type="success" />
                </div>
                <div class="mt-3 mb-2 flex space-x-5 ">
                    <div class="w-1/2">
                        <x-input-label for="question" :value="__('Question')" />
                        <x-text-input x-model="question" id="question" class="block mt-1 w-full" type="text"
                            name="question" required autofocus />
                    </div>
                    <div class="w-1/2">
                        <x-input-label for="category" :value="__('Category')" />
                        <select id="category" name="category"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                            placeholder="Select Category" x-model="category">
                            @foreach ($categories as $key => $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 w-1/2">
                                    Answer
                                </th>
                                <th scope="col" class="px-6 py-3 w-1/2">
                                    Date
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">#</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(field, index) in fields" :key="index">
                                <tr
                                    class="bg-white border-b  dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <x-text-input x-model="field.ans" class="block mt-1 w-full" type="text"
                                            required autofocus name="ans[]" />
                                    </td>
                                    <td scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <x-text-input x-model="field.date" name="date[]" class="block mt-1 w-full"
                                            type="date" required autofocus />
                                    </td>
                                    <td scope="row" class="px-6 py-3">
                                        <x-primary-button @click="removeField(index)" type="button">
                                            Delete
                                        </x-primary-button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>

                </div>
                <div class="mt-5 flex justify-end space-x-2">
                    <x-primary-button type="button" @click="addNewField()">Add</x-primary-button>
                    <x-primary-button type="submit">Save</x-primary-button>
                </div>
            </form>
        </div>
    </div>

    </div>


    <x-slot name="scripts">
        <script>
            function handler() {
                return {
                    fields: [{
                        ans: '',
                        date: ''
                    }],
                    question: "",
                    category: null,
                    addNewField() {
                        this.fields.push({
                            ans: '',
                            date: ''
                        });
                    },
                    removeField(index) {
                        this.fields.splice(index, 1);
                    },
                    saveQuestion() {
                        const data = {
                            fields: this.fields,
                            question: this.question,
                            category_id: this.category
                        };

                        fetch("{{ route('question.store') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                },
                                body: JSON.stringify(data),
                            })
                            .then((response) => response.json())
                            .then(function(res) {
                                Swal.fire({
                                    text: res.message,
                                }).then((result) => {
                                    window.location.href = res.back;
                                });
                            })
                    }
                }
            }
        </script>
    </x-slot>

</x-app-layout>
