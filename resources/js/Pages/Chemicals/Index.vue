<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    chemicals: Array,
    filters: Object
});

const form = useForm({});
const search = ref(props.filters?.search || '');
const expiringSoon = ref(props.filters?.expiring_soon === '1' || props.filters?.expiring_soon === true);

// Modal State
const showCategoriesModal = ref(false);
const selectedChemicalName = ref('');
const selectedCategories = ref([]);

const openCategoriesModal = (chemical) => {
    if (chemical.place_categories_count > 0) {
        selectedChemicalName.value = chemical.name;
        selectedCategories.value = chemical.place_categories; 
        showCategoriesModal.value = true;
    }
};

const closeCategoriesModal = () => {
    showCategoriesModal.value = false;
    selectedCategories.value = [];
};

// Simple debounce utility
function debounce(fn, delay) {
    let timeoutId;
    return (...args) => {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => fn(...args), delay);
    };
}

const deleteChemical = (id) => {
    if (confirm('Are you sure you want to delete this chemical?')) {
        form.delete(route('chemicals.destroy', id));
    }
};

const isExpiringSoonDate = (dateString) => {
    const expiry = new Date(dateString);
    const today = new Date();
    const monthsDiff = (expiry - today) / (1000 * 60 * 60 * 24 * 30);
    return monthsDiff < 3 && monthsDiff > 0; // Less than 3 months
};

const isExpiredDate = (dateString) => {
     return new Date(dateString) < new Date();
}

const updateFilters = debounce(() => {
    router.get(
        route('chemicals.index'),
        { 
            search: search.value,
            expiring_soon: expiringSoon.value ? 1 : 0
        },
        { preserveState: true, replace: true }
    );
}, 300);

watch([search, expiringSoon], () => {
    updateFilters();
});
</script>

<template>
    <Head title="Chemicals" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Chemical Inventory</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                         <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                            <h3 class="text-lg font-medium text-gray-900">Inventory</h3>
                            <div class="flex items-center gap-4 w-full md:w-auto">
                                <label class="flex items-center space-x-2 text-sm text-gray-700 cursor-pointer bg-yellow-50 px-4 py-2.5 rounded-md border border-yellow-200 hover:bg-yellow-100 transition-colors">
                                    <input 
                                        v-model="expiringSoon"
                                        type="checkbox" 
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    >
                                    <span>Show Expiring Soon</span>
                                </label>
                                <input 
                                    v-model="search"
                                    type="text" 
                                    placeholder="Search chemicals..." 
                                    class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 w-full md:w-64"
                                >
                                <Link
                                    :href="route('chemicals.create')"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 whitespace-nowrap"
                                >
                                    Add Chemical
                                </Link>
                            </div>
                        </div>

                        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">Name</th>
                                        <th scope="col" class="py-3 px-6">Type</th>
                                        <th scope="col" class="py-3 px-6">Quantity</th>
                                        <th scope="col" class="py-3 px-6">Expiry Date</th>
                                        <th scope="col" class="py-3 px-6 text-center">Used In (Categories)</th>
                                        <th scope="col" class="py-3 px-6 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="chemicals.length === 0" class="bg-white border-b">
                                        <td colspan="5" class="py-4 px-6 text-center">No chemicals found.</td>
                                    </tr>
                                    <tr v-for="chem in chemicals" :key="chem.id" class="bg-white border-b hover:bg-gray-50">
                                        <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">{{ chem.name }}</td>
                                        <td class="py-4 px-6">{{ chem.chemical_type }}</td>
                                        <td class="py-4 px-6">{{ chem.quantity }} {{ chem.unit }}</td>
                                        <td class="py-4 px-6">
                                            <span :class="{
                                                'text-red-600 font-bold': isExpiredDate(chem.expiry_date),
                                                'text-yellow-600 font-bold': isExpiringSoonDate(chem.expiry_date)
                                            }">
                                                {{ chem.expiry_date }}
                                                <span v-if="isExpiredDate(chem.expiry_date)">(Expired)</span>
                                                <span v-else-if="isExpiringSoonDate(chem.expiry_date)">(Expiring Soon)</span>
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <button 
                                                v-if="chem.place_categories_count > 0"
                                                @click="openCategoriesModal(chem)"
                                                class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-2.5 py-0.5 rounded hover:bg-indigo-200 cursor-pointer underline decoration-dotted"
                                            >
                                                {{ chem.place_categories_count }} Categories
                                            </button>
                                            <span v-else class="text-gray-400 text-xs">-</span>
                                        </td>
                                        <td class="py-4 px-6 text-right">
                                            <Link
                                                :href="route('chemicals.edit', chem.id)"
                                                class="font-medium text-blue-600 hover:underline mr-4"
                                            >
                                                Edit
                                            </Link>
                                            <button
                                                @click="deleteChemical(chem.id)"
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

    <!-- Categories List Modal -->
    <Modal :show="showCategoriesModal" @close="closeCategoriesModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">
                Usage: {{ selectedChemicalName }}
            </h2>
            <p class="text-sm text-gray-500 mb-4">This chemical is required in the following categories:</p>
            
            <ul class="list-disc list-inside space-y-1 bg-gray-50 p-4 rounded-md">
                <li v-for="cat in selectedCategories" :key="cat.id" class="text-gray-700">
                    {{ cat.name }}
                </li>
            </ul>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeCategoriesModal"> Close </SecondaryButton>
            </div>
        </div>
    </Modal>
    </AuthenticatedLayout>
</template>
