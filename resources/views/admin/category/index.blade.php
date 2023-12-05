<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-2">
                <x-primary-button class="ms-3" data-target="#category-modal" id="categoryModal" type="button">
                    {{ __('Add Category') }}
                </x-primary-button>
            </div>
            <div class="mb-2">
                <x-alert type="success" />
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Category name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <span class="sr-only">Edit</span>
                                <span class="sr-only">Delete</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $item)
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->name }}
                                </th>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end space-x-2">
                                        <a href="javascript:void(0)" data-target="#category-modal-update"
                                            data-url="{{ route('admin.category.update', ['category' => $item->id]) }}"
                                            data-item="{{ json_encode($item, JSON_HEX_QUOT) }}"
                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline update-category">
                                            Edit
                                        </a>

                                        <form method="POST" action="{{ route('admin.category.destroy', $item->id) }}"
                                            id="deleteForm">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this record !');"
                                                class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="my-2 px-2">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>

    </div>

    <x-slot name="modal">
        <!-- Main modal -->
        <div id="category-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full flex">
            <div class="relative p-4 w-full max-w-2xl max-h-full mx-auto mt-16">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Terms of Service
                        </h3>
                        <button type="button" data-target="#category-modal" id="category-modal-close"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="category-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 space-y-4">
                        <form method="POST" data-target="{{ route('admin.category.store') }}"
                            id="category-create-form">
                            @csrf
                            <div class="mb-4">
                                <x-input-label for="category" :value="__('Category')" />
                                <x-text-input id="category" class="block mt-1 w-full" type="text" name="category"
                                    required autofocus />
                                <x-input-error :messages="$errors->get('category')" class="mt-2" />

                            </div>
                            <x-primary-button>
                                {{ __('Submit') }}
                            </x-primary-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="category-modal-update" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full flex">
            <div class="relative p-4 w-full max-w-2xl max-h-full mx-auto mt-16">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Update Category
                        </h3>
                        <button type="button" data-target="#category-modal-update" id="category-modal-update-close"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="category-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 space-y-4">
                        <form method="POST" data-target="#" id="category-update-form">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <x-input-label for="update_category" :value="__('Category')" />
                                <x-text-input id="update_category" class="block mt-1 w-full" type="text"
                                    name="update_category" required autofocus />
                                <x-input-error :messages="$errors->get('update_category')" class="mt-2" />

                            </div>
                            <x-primary-button>
                                {{ __('Submit') }}
                            </x-primary-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
    <x-slot name="scripts">
        <script>
            $(document).ready(function() {

                const showModal = function(el) {
                    const modal = el.data('target');
                    $(modal).fadeIn().removeClass('hidden');
                    $("#backdrop").removeClass('hidden');
                    console.log(modal);
                }
                const closeModal = function(el) {
                    const modal = el.data('target');
                    $(modal).fadeOut(function() {
                        $("#backdrop").addClass('hidden');
                    }).addClass('hidden');
                }


                $('#categoryModal').on('click', function() {
                    showModal($(this));
                })

                $('#category-modal-close,#category-modal-update-close').on('click', function() {
                    closeModal($(this));
                });


                $('.update-category').on('click', function() {
                    const el = $(this);
                    const url = el.data('url');
                    const category = el.data('item');
                    $("#update_category").val(category.name);
                    $("#category-update-form").attr('data-target', url);
                    showModal(el);
                });

                // Create Ajax call
                $('#category-create-form').on('submit', function(e) {
                    e.preventDefault();
                    const el = $(this);
                    const url = el.data('target')
                    const formData = $(el).serialize();
                    console.log('formData', formData);
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: formData,
                        success: function(response) {
                            // Handle successful response
                            $('#category-modal-close').trigger('click');
                            Swal.fire({
                                text: response.message,
                            }).then((result) => {
                                window.location.reload();
                            });
                        },
                        error: function(error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: error.responseJSON.message,
                            });
                        }
                    });

                });


                // Update Ajax call
                $('#category-update-form').on('submit', function(e) {
                    e.preventDefault();
                    const el = $(this);
                    const url = el.data('target')
                    const formData = $(el).serialize();
                    console.log('formData', formData);
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: formData,
                        success: function(response) {
                            // Handle successful response
                            $('#category-modal-update-close').trigger('click');
                            Swal.fire({
                                text: response.message,
                            }).then((result) => {
                                window.location.reload();
                            });
                        },
                        error: function(error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: error.responseJSON.message,
                            });
                        }
                    });

                })
            });
        </script>
    </x-slot>

</x-app-layout>
