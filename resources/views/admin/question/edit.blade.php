<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Question : ' . $question->question) }}
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
                <div class="mt-3 mb-2">
                    <x-input-label for="update_category" :value="__('Category')" />
                    <x-text-input x-model="question" class="block mt-1 w-full" type="text" name="question" required
                        autofocus />
                </div>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 w-1/2">
                                    Question
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
                            question: this.question
                        };

                        fetch("{{ route('question.store') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(data),
                        })
                    }
                }
            }
        </script>
    </x-slot>

</x-app-layout>
