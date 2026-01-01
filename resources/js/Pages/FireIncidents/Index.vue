<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { ref } from 'vue';

defineProps({
    incidents: Array,
});

const form = useForm({});
const showingIncidentModal = ref(false);
const selectedIncident = ref(null);

const deleteIncident = (id) => {
    if (confirm('Are you sure you want to delete this incident report?')) {
        form.delete(route('fire-incidents.destroy', id));
    }
};

const viewIncident = (incident) => {
    selectedIncident.value = incident;
    showingIncidentModal.value = true;
};

const closeModal = () => {
    showingIncidentModal.value = false;
    setTimeout(() => {
        selectedIncident.value = null;
    }, 300); // Wait for animation
};

const formatDate = (dateString, timeRequired = false) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    if (timeRequired) {
        options.hour = '2-digit';
        options.minute = '2-digit';
    }
    return new Date(dateString).toLocaleDateString(undefined, options);
};

const getPropertyDamage = (incident) => {
    return incident.property_damage || 'None reported';
};

const getRescuedAssets = (incident) => {
    return incident.rescued_assets || 'No specific assets noted';
};
</script>

<template>

    <Head title="Fire Incidents" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Fire Incident Reports</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Incident Log</h3>
                            <Link :href="route('fire-incidents.create')"
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Report Incident
                            </Link>
                        </div>

                        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">Date</th>
                                        <th scope="col" class="py-3 px-6">Place</th>
                                        <th scope="col" class="py-3 px-6">Cause</th>
                                        <th scope="col" class="py-3 px-6 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="incidents.length === 0" class="bg-white border-b">
                                        <td colspan="4" class="py-4 px-6 text-center">No fire incidents recorded.</td>
                                    </tr>
                                    <tr v-for="incident in incidents" :key="incident.id"
                                        class="bg-white border-b hover:bg-gray-50">
                                        <td class="py-4 px-6">{{ formatDate(incident.incident_date) }}</td>
                                        <td class="py-4 px-6 font-medium text-gray-900">{{ incident.place ?
                                            incident.place.name
                                            : 'Unknown' }}</td>
                                        <td class="py-4 px-6">{{ incident.cause ? incident.cause.name : 'Unknown' }}
                                        </td>
                                        <td class="py-4 px-6 text-right flex justify-end gap-3">
                                            <button @click="viewIncident(incident)"
                                                class="text-gray-500 hover:text-indigo-600 transition"
                                                title="View Details">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>
                                            </button>

                                            <Link :href="route('fire-incidents.edit', incident.id)"
                                                class="text-blue-600 hover:text-blue-800 transition" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </Link>
                                            <button @click="deleteIncident(incident.id)"
                                                class="text-red-600 hover:text-red-800 transition" title="Delete">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
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

        <!-- Details Modal -->
        <Modal :show="showingIncidentModal" @close="closeModal">
            <div v-if="selectedIncident" class="p-6">
                <div class="flex justify-between items-start mb-6 border-b pb-4">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">
                            Incident Details
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">Recorded on {{ formatDate(selectedIncident.created_at) }}
                        </p>
                    </div>
                    <button @click="closeModal" class="text-gray-400 hover:text-gray-500 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2 bg-gray-50 p-4 rounded-lg">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider">Date & Time</h3>
                                <p class="text-base font-semibold text-gray-900">{{
                                    formatDate(selectedIncident.incident_date,
                                        true) }}</p>
                            </div>
                            <div>
                                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider">Cause</h3>
                                <p class="text-base font-semibold text-gray-900">{{ selectedIncident.cause?.name }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider">Location / Place
                                </h3>
                                <p class="text-base font-semibold text-gray-900">{{ selectedIncident.place?.name }} ({{
                                    selectedIncident.place?.location }})</p>
                            </div>
                        </div>
                    </div>

                    <!-- Losses -->
                    <div class="border rounded-lg p-4">
                        <h3 class="text-sm font-bold text-red-600 border-b pb-2 mb-3">Casualties & Losses</h3>
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm text-gray-500">Human Casualties:</span>
                                <div class="font-medium">
                                    <span class="text-red-600">{{ selectedIncident.human_loss }} Deaths</span>,
                                    <span class="text-orange-500">{{ selectedIncident.injured_people }} Injured</span>
                                </div>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500">Financial Loss:</span>
                                <div class="font-medium text-gray-900">${{
                                    selectedIncident.financial_loss.toLocaleString() }}
                                </div>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500">Property Damage:</span>
                                <div class="font-medium text-gray-900">{{ getPropertyDamage(selectedIncident) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rescue -->
                    <div class="border rounded-lg p-4">
                        <h3 class="text-sm font-bold text-green-600 border-b pb-2 mb-3">Rescue Operations</h3>
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm text-gray-500">People Rescued:</span>
                                <div class="font-medium text-green-700">{{ selectedIncident.rescued_people }} People
                                </div>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500">Assets Saved:</span>
                                <div class="font-medium text-gray-900 italic">"{{ getRescuedAssets(selectedIncident) }}"
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="selectedIncident.additional_notes"
                        class="md:col-span-2 bg-yellow-50 p-4 border border-yellow-100 rounded-lg">
                        <h3 class="text-xs font-bold text-yellow-800 uppercase tracking-wider mb-1">Additional Notes
                        </h3>
                        <p class="text-sm text-yellow-900">{{ selectedIncident.additional_notes }}</p>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Close </SecondaryButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
