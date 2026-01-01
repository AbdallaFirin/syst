<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    policies: Array,
});

const form = useForm({});

const deletePolicy = (id) => {
    if (confirm('Are you sure you want to delete this policy?')) {
        form.delete(route('policies.destroy', id));
    }
};

const getFileUrl = (path) => {
    return `/storage/${path}`;
};
</script>

<template>
    <Head title="Policies" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Safety Policies</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Document Management</h3>
                            <Link
                                :href="route('policies.create')"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                Upload Policy
                            </Link>
                        </div>

                        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">Policy Name</th>
                                        <th scope="col" class="py-3 px-6">Document</th>
                                        <th scope="col" class="py-3 px-6">Uploaded Date</th>
                                        <th scope="col" class="py-3 px-6 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="policies.length === 0" class="bg-white border-b">
                                        <td colspan="4" class="py-4 px-6 text-center">No policies found.</td>
                                    </tr>
                                    <tr v-for="policy in policies" :key="policy.id" class="bg-white border-b hover:bg-gray-50">
                                        <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">{{ policy.name }}</td>
                                        <td class="py-4 px-6">
                                            <a :href="getFileUrl(policy.file_path)" target="_blank" class="text-indigo-600 hover:text-indigo-900 hover:underline flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                Download / View
                                            </a>
                                        </td>
                                        <td class="py-4 px-6">{{ new Date(policy.created_at).toLocaleDateString() }}</td>
                                        <td class="py-4 px-6 text-right">
                                            <Link
                                                :href="route('policies.edit', policy.id)"
                                                class="font-medium text-blue-600 hover:underline mr-4"
                                            >
                                                Edit
                                            </Link>
                                            <button
                                                @click="deletePolicy(policy.id)"
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
