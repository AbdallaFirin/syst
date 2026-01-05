<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    categories: Array,
    filters: Object,
});

const form = useForm({});
const search = ref(props.filters?.search || '');
const showingViewModal = ref(false);
const selectedCategory = ref(null);
const showingDeleteModal = ref(false);
const categoryToDelete = ref(null);

// Simple debounce utility
function debounce(fn, delay) {
    let timeoutId;
    return (...args) => {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => fn(...args), delay);
    };
}

const confirmDeleteCategory = (category) => {
    categoryToDelete.value = category;
    showingDeleteModal.value = true;
};

const deleteCategory = () => {
    if (categoryToDelete.value) {
        form.delete(route('place-categories.destroy', categoryToDelete.value.id), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onError: () => nameInput.value.focus(),
            onFinish: () => form.reset(),
        });
    }
};

const viewCategory = (category) => {
    selectedCategory.value = category;
    showingViewModal.value = true;
};

const closeModal = () => {
    showingViewModal.value = false;
    showingDeleteModal.value = false;
    setTimeout(() => {
        selectedCategory.value = null;
        categoryToDelete.value = null;
    }, 300);
};

const formatEquipment = (category) => {
    // Check for new Pivot relationship data
    if (category.chemicals && category.chemicals.length > 0) {
        return category.chemicals.map(c => c.name).join(', ');
    }
    
    // Fallback to old JSON/String column
    const equipment = category.required_equipment;
    if (!equipment) return 'N/A';
    try {
        // Check if it's a JSON string
        if (typeof equipment === 'string' && (equipment.startsWith('[') || equipment.startsWith('{'))) {
             const parsed = JSON.parse(equipment);
             if (Array.isArray(parsed)) {
                 return parsed.join(', ');
             }
        }
        // If it's already an array
        if (Array.isArray(equipment)) {
            return equipment.join(', ');
        }
    } catch (e) {
        console.error('Error parsing equipment:', e);
    }
    return equipment; // Log as is if not parseable
};

watch(search, debounce((value) => {
    router.get(
        route('place-categories.index'),
        { search: value },
        { preserveState: true, replace: true }
    );
}, 300));
</script>

<template>
    <Head title="Place Categories" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Place Categories</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Manage Categories</h3>
                            <div class="flex items-center gap-4">
                                <input 
                                    v-model="search"
                                    type="text" 
                                    placeholder="Search categories..." 
                                    class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                <Link
                                    :href="route('place-categories.create')"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 whitespace-nowrap"
                                >
                                    Add New Category
                                </Link>
                            </div>
                        </div>

                        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">Name</th>
                                        <th scope="col" class="py-3 px-6">Required Equipment</th>
                                        <th scope="col" class="py-3 px-6 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="categories.length === 0" class="bg-white border-b">
                                        <td colspan="3" class="py-4 px-6 text-center">No categories found.</td>
                                    </tr>
                                    <tr v-for="category in categories" :key="category.id" class="bg-white border-b hover:bg-gray-50">
                                        <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                            <span v-if="category.icon" class="mr-2 text-xl">{{ category.icon }}</span>
                                            {{ category.name }}
                                        </td>
                                        <td class="py-4 px-6">{{ formatEquipment(category) }}</td>
                                        <td class="py-4 px-6 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <button
                                                    @click="viewCategory(category)"
                                                    class="font-medium text-gray-600 hover:text-gray-900"
                                                    title="View Details"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                </button>
                                                <Link
                                                    :href="route('place-categories.edit', category.id)"
                                                    class="font-medium text-blue-600 hover:text-blue-800"
                                                    title="Edit"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                    </svg>
                                                </Link>
                                                <button
                                                    @click="confirmDeleteCategory(category)"
                                                    class="font-medium text-red-600 hover:text-red-800"
                                                    title="Delete"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Modal :show="showingViewModal" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4" v-if="selectedCategory">
                    <span v-if="selectedCategory.icon" class="mr-2 text-2xl">{{ selectedCategory.icon }}</span>
                    Category Details: {{ selectedCategory.name }}
                </h2>
                
                <div v-if="selectedCategory" class="space-y-4">
                    <div>
                        <h4 class="font-semibold text-gray-700">Number of Places:</h4>
                        <p class="text-gray-600">{{ selectedCategory.places_count || 0 }} Places</p>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold text-gray-700">Required Chemicals/Equipment:</h4>
                        <div class="bg-gray-50 p-3 rounded mt-1 text-sm text-gray-800">
                             {{ formatEquipment(selectedCategory) }}
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        Close
                    </SecondaryButton>
                </div>
            </div>
        </Modal>

        <Modal :show="showingDeleteModal" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to delete this category?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Once this category is deleted, all of its resources and data will be permanently deleted.
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <DangerButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteCategory"
                    >
                        Delete Category
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
