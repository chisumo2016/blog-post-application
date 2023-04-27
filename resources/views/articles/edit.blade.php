<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-bold text-xl mx-auto text-gray-900 dark:text-gray-100 pb-4">
                Edit Article
            </h2>

            <div class="w-full mx-auto mb-10">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <form method="post"
                          action=""
                          class="px-8  mt-6 space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="status" class="pb-2" :value="__('Status')" />

                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" value="" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            </label>
                        </div>

                        <div>
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" autocomplete="title" />
                        </div>

                        <div>
                            <x-input-label for="excerpt" :value="__('Excerpt')" />
                            <x-textarea-input id="excerpt" name="excerpt" type="text" class="mt-1 block w-full h-20" autocomplete="Excerpt" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <x-textarea-input id="description" name="description" type="text" class="mt-1 block w-full h-40" autocomplete="description" />
                        </div>

                        <div>
                            <x-input-label for="category" :value="__('Category')" />
                            <select class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="" disabled selected>
                                    Select your category
                                </option>
                                <option value="x">
                                    x
                                </option>
                            </select>
                        </div>

                        <div>
                            <x-input-label for="tags" :value="__('Tags')" />
                            <select multiple id="countries_multiple" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="x">x</option>
                            </select>
                        </div>

                        <div class="flex items-center gap-4 pb-10">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</x-app-layout>
