<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    chemicals: Array,
});

const form = useForm({});

const deleteChemical = (id) => {
    if (confirm('Are you sure you want to delete this chemical?')) {
        form.delete(route('chemicals.destroy', id));
    }
};

const isExpiringSoon = (dateString) => {
    const expiry = new Date(dateString);
    const today = new Date();
    const monthsDiff = (expiry - today) / (1000 * 60 * 60 * 24 * 30);
    return monthsDiff < 3 && monthsDiff > 0; // Less than 3 months
};

const isExpired = (dateString) => {
     return new Date(dateString) < new Date();
}
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
                         <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Inventory</h3>
                            <Link
                                :href="route('chemicals.create')"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                Add Chemical
                            </Link>
                        </div>

                        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">Name</th>
                                        <th scope="col" class="py-3 px-6">Type</th>
                                        <th scope="col" class="py-3 px-6">Quantity</th>
                                        <th scope="col" class="py-3 px-6">Expiry Date</th>
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
                                                'text-red-600 font-bold': isExpired(chem.expiry_date),
                                                'text-yellow-600 font-bold': isExpiringSoon(chem.expiry_date)
                                            }">
                                                {{ chem.expiry_date }}
                                                <span v-if="isExpired(chem.expiry_date)">(Expired)</span>
                                                <span v-else-if="isExpiringSoon(chem.expiry_date)">(Expiring Soon)</span>
                                            </span>
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
    </AuthenticatedLayout>
</template>
