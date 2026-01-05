<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    categories: Array,
});

const globalSearch = ref('');
const selectedCategoryFilter = ref('');

const filteredCategories = computed(() => {
    let result = props.categories;

    if (selectedCategoryFilter.value) {
        result = result.filter(cat => cat.id === selectedCategoryFilter.value);
    }

    if (globalSearch.value) {
        const query = globalSearch.value.toLowerCase();
        result = result.filter(cat => cat.name.toLowerCase().includes(query));
    }

    return result;
});
</script>

<template>
    <Head title="Places" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Places Registry</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <div class="bg-white p-4 rounded-lg shadow-sm mb-6 flex flex-col md:flex-row gap-4 items-center justify-between">
                    <div class="flex gap-4 w-full md:w-2/3">
                        <div class="relative w-full">
                            <input 
                                v-model="globalSearch"
                                type="text" 
                                placeholder="Search categories..." 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pl-10"
                            >
                            <span class="absolute left-3 top-2.5 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                        </div>
                        <select 
                            v-model="selectedCategoryFilter"
                            class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            <option value="">Show All Categories</option>
                            <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                        </select>
                    </div>
                     <Link
                        :href="route('places.create')"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 whitespace-nowrap"
                    >
                        New Place
                    </Link>
                </div>

                <!-- Category Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div 
                        v-for="category in filteredCategories" 
                        :key="category.id"
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition border-l-4 border-gray-200"
                    >
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ category.name }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">{{ category.places_count }} Places</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <Link 
                                    :href="route('places.index', { category_id: category.id })"
                                    class="text-sm font-medium text-indigo-600 hover:text-indigo-800"
                                >
                                    View List &rarr;
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
