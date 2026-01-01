<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    categories: Array,
});

const form = useForm({});
const selectedCategory = ref(null);

const deletePlace = (id) => {
    if (confirm('Are you sure you want to delete this place?')) {
        form.delete(route('places.destroy', id), {
            onSuccess: () => {
                // Refresh logic is handled by Inertia, but we might want to keep selection if possible.
                // For MVP, we might reset, but it's okay.
            }
        });
    }
};

const selectCategory = (category) => {
    if (selectedCategory.value && selectedCategory.value.id === category.id) {
        selectedCategory.value = null; // Deselect
    } else {
        selectedCategory.value = category;
    }
};
</script>

<template>
    <Head title="Places" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Places Registry</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <div class="flex justify-between items-center mb-6">
                    <p class="text-gray-600">Select a category to view its registered places.</p>
                     <Link
                        :href="route('places.create')"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        New Place
                    </Link>
                </div>

                <!-- Category Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div 
                        v-for="category in categories" 
                        :key="category.id"
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg cursor-pointer hover:shadow-md transition border-l-4"
                        :class="selectedCategory && selectedCategory.id === category.id ? 'border-indigo-500 ring-2 ring-indigo-200' : 'border-gray-200'"
                        @click="selectCategory(category)"
                    >
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ category.name }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">{{ category.places.length }} Places</p>
                                </div>
                                <span class="bg-indigo-100 text-indigo-700 text-xs px-2 py-1 rounded-full" v-if="selectedCategory && selectedCategory.id === category.id">
                                    Viewing
                                </span>
                            </div>
                            <div class="mt-4">
                                <button class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                                    {{ selectedCategory && selectedCategory.id === category.id ? 'Hide List' : 'View List' }} &rarr;
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Places Table (Conditional) -->
                <div v-if="selectedCategory" class="bg-white overflow-hidden shadow-sm sm:rounded-lg transition-all duration-500 ease-in-out">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-4 border-b pb-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                Places in <span class="text-indigo-600">{{ selectedCategory.name }}</span>
                            </h3>
                            <button @click="selectedCategory = null" class="text-gray-400 hover:text-gray-600">
                                <span class="sr-only">Close</span>
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

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
                                    <tr v-if="selectedCategory.places.length === 0" class="bg-white border-b">
                                        <td colspan="5" class="py-4 px-6 text-center text-gray-500 italic">No registered places for this category yet.</td>
                                    </tr>
                                    <tr v-for="place in selectedCategory.places" :key="place.id" class="bg-white border-b hover:bg-gray-50">
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
