<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
// Simple debounce utility to avoid lodash dependency
function debounce(fn, delay) {
    let timeoutId;
    return (...args) => {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => fn(...args), delay);
    };
}

const props = defineProps({
    category: Object,
    filters: Object,
});

const form = useForm({});
const search = ref(props.filters?.search || '');

const deletePlace = (id) => {
    if (confirm('Are you sure you want to delete this place?')) {
        form.delete(route('places.destroy', id));
    }
};

watch(search, debounce((value) => {
    router.get(
        route('places.index'),
        { 
            category_id: props.category.id, // Keeps category scope if present
            search: value 
        },
        { preserveState: true, replace: true }
    );
}, 300));
</script>

<template>
    <Head :title="category.name + ' - Places'" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <span v-if="category.id">Places in <span class="text-indigo-600">{{ category.name }}</span></span>
                    <span v-else>{{ category.name }}</span>
                </h2>
                <Link :href="route('places.index')" class="text-sm text-gray-600 hover:text-gray-900 flex items-center">
                    &larr; Back to Categories
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <div class="flex justify-between items-center mb-6">
                    <div class="w-full max-w-md">
                        <input 
                            v-model="search"
                            type="text" 
                            placeholder="Search places..." 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                    </div>
                     <Link
                        :href="route('places.create')"
                        class="ml-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        New Place
                    </Link>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="overflow-x-auto relative shadow-sm rounded-lg border border-gray-100">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">Place Name</th>
                                        <th scope="col" class="py-3 px-6">Location</th>
                                        <th scope="col" class="py-3 px-6">Contact Person</th>
                                        <th scope="col" class="py-3 px-6">Phone</th>
                                        <th scope="col" class="py-3 px-6 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="category.places.length === 0" class="bg-white border-b">
                                        <td colspan="5" class="py-4 px-6 text-center text-gray-500 italic">No registered places for this category yet.</td>
                                    </tr>
                                    <tr v-for="place in category.places" :key="place.id" class="bg-white border-b hover:bg-gray-50">
                                        <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">{{ place.name }}</td>
                                        <td class="py-4 px-6">{{ place.location }}</td>
                                        <td class="py-4 px-6">{{ place.contact_person }}</td>
                                        <td class="py-4 px-6">{{ place.phone_number_1 }}</td>
                                        <td class="py-4 px-6 text-right">
                                            <Link
                                                :href="route('places.edit', place.id)"
                                                class="font-medium text-blue-600 hover:underline mr-4"
                                            >
                                                Edit
                                            </Link>
                                            <button
                                                @click="deletePlace(place.id)"
                                                class="font-medium text-red-600 hover:underline"
                                            >
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
