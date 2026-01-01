<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    vehicles: Array,
});

const form = useForm({});

const deleteVehicle = (id) => {
    if (confirm('Are you sure you want to delete this vehicle?')) {
        form.delete(route('vehicles.destroy', id));
    }
};
</script>

<template>
    <Head title="Vehicles" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Vehicle Management</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Fleet</h3>
                            <Link
                                :href="route('vehicles.create')"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                Register Vehicle
                            </Link>
                        </div>

                        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">Type</th>
                                        <th scope="col" class="py-3 px-6">Plate Number</th>
                                        <th scope="col" class="py-3 px-6">Assigned Driver</th>
                                        <th scope="col" class="py-3 px-6 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="vehicles.length === 0" class="bg-white border-b">
                                        <td colspan="4" class="py-4 px-6 text-center">No vehicles found.</td>
                                    </tr>
                                    <tr v-for="vehicle in vehicles" :key="vehicle.id" class="bg-white border-b hover:bg-gray-50">
                                        <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">{{ vehicle.vehicle_type }}</td>
                                        <td class="py-4 px-6">{{ vehicle.plate_number }}</td>
                                        <td class="py-4 px-6">{{ vehicle.driver ? vehicle.driver.name : 'Unassigned' }}</td>
                                        <td class="py-4 px-6 text-right">
                                            <Link
                                                :href="route('vehicles.edit', vehicle.id)"
                                                class="font-medium text-blue-600 hover:underline mr-4"
                                            >
                                                Edit
                                            </Link>
                                            <button
                                                @click="deleteVehicle(vehicle.id)"
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
