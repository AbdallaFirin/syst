<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    incident: Object
});

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('en-GB', {
        day: 'numeric', month: 'long', year: 'numeric',
        hour: '2-digit', minute: '2-digit'
    });
};

const printPage = () => {
    window.print();
};
</script>

<template>
    <Head title="Incident Case File" />

    <div class="max-w-4xl mx-auto p-8 bg-white text-gray-900 print:max-w-none print:p-0">
        
        <!-- Action Bar (Hidden when printing) -->
        <div class="flex justify-between items-center mb-8 print:hidden">
            <Link :href="route('fire-incidents.edit', incident.id)" class="text-blue-600 hover:underline">
                &larr; Back to Incident
            </Link>
            <button @click="printPage" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                Print Case File
            </button>
        </div>

        <!-- Header -->
        <div class="border-b-2 border-red-600 pb-4 mb-6 flex justify-between items-end">
            <div>
                <h1 class="text-3xl font-bold uppercase tracking-wider text-red-700">Fire Incident Report</h1>
                <p class="text-gray-500 mt-1">Case No: #{{ incident.id.toString().padStart(6, '0') }}</p>
            </div>
            <div class="text-right">
                <!-- Status Removed -->
            </div>
        </div>

        <!-- Section 1: Incident Info -->
        <div class="grid grid-cols-2 gap-8 mb-8">
            <div>
                <h3 class="font-bold text-gray-500 uppercase text-xs mb-1">Date & Time</h3>
                <p class="text-lg font-semibold">{{ formatDate(incident.incident_date) }}</p>
            </div>
            <div>
                <h3 class="font-bold text-gray-500 uppercase text-xs mb-1">Cause</h3>
                <p class="text-lg">{{ incident.cause?.name || 'Unknown' }}</p>
            </div>
            <div class="col-span-2">
                <h3 class="font-bold text-gray-500 uppercase text-xs mb-1">Affected Place / Location</h3>
                <p class="text-lg font-semibold">{{ incident.place?.name }}</p>
                <p class="text-gray-600">{{ incident.place?.location }}</p>
                <p class="text-gray-600 mt-1 text-sm">Category: {{ incident.place?.category?.name }}</p>
            </div>
        </div>

        <!-- Section 2: Casualties & Financials -->
        <div class="bg-gray-50 border p-6 rounded-lg mb-8 print:bg-white print:border-gray-300">
            <h2 class="text-xl font-bold border-b border-gray-300 pb-2 mb-4">Casualties & Impact</h2>
            <div class="grid grid-cols-3 gap-6">
                <div class="text-center p-3 bg-red-50 rounded border border-red-100 print:bg-transparent print:border-red-200">
                    <span class="block text-3xl font-bold text-red-600">{{ incident.human_loss }}</span>
                    <span class="text-xs uppercase font-bold text-red-800">Deaths</span>
                </div>
                <div class="text-center p-3 bg-orange-50 rounded border border-orange-100 print:bg-transparent print:border-orange-200">
                    <span class="block text-3xl font-bold text-orange-600">{{ incident.injured_people }}</span>
                    <span class="text-xs uppercase font-bold text-orange-800">Injured</span>
                </div>
                <div class="text-center p-3 bg-gray-100 rounded border border-gray-200 print:bg-transparent print:border-gray-300">
                    <span class="block text-3xl font-bold text-gray-700">${{ incident.financial_loss.toLocaleString() }}</span>
                    <span class="text-xs uppercase font-bold text-gray-600">Financial Loss</span>
                </div>
            </div>
            
            <div class="mt-4">
                <h3 class="font-bold text-gray-700 text-sm mb-1">Property Damage Description</h3>
                <p class="text-gray-800 bg-white p-3 rounded border print:border-none print:p-0">{{ incident.property_damage || 'None reported' }}</p>
            </div>
        </div>

        <!-- Section 3: Rescue & Recovery -->
        <div class="mb-8">
            <h2 class="text-xl font-bold border-b border-gray-300 pb-2 mb-4">Rescue Operations</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                     <h3 class="font-bold text-gray-500 uppercase text-xs mb-1">People Rescued</h3>
                     <p class="text-2xl font-semibold text-green-700">{{ incident.rescued_people }}</p>
                </div>
                <div>
                     <h3 class="font-bold text-gray-500 uppercase text-xs mb-1">Assets Saved</h3>
                     <p class="italic text-gray-700">"{{ incident.rescued_assets || 'No details' }}"</p>
                </div>
            </div>
        </div>

        <!-- Section 4: Notes -->
        <div v-if="incident.additional_notes" class="mb-8">
            <h2 class="text-xl font-bold border-b border-gray-300 pb-2 mb-4">Investigator Notes</h2>
            <div class="bg-yellow-50 p-4 rounded text-sm text-gray-800 print:bg-transparent print:p-0">
                {{ incident.additional_notes }}
            </div>
        </div>

        <!-- Section 5: Evidence Gallery -->
        <div v-if="incident.images && incident.images.length > 0" class="break-inside-avoid">
            <h2 class="text-xl font-bold border-b border-gray-300 pb-2 mb-4">Photographic Evidence</h2>
            
            <div class="grid grid-cols-2 gap-4">
                <div v-for="img in incident.images" :key="img.id" class="border p-2 rounded break-inside-avoid">
                    <img :src="'/storage/' + img.image_path" class="w-full h-48 object-cover rounded mb-2" />
                    <p class="text-xs text-gray-600 italic text-center">{{ img.caption || 'Evidence Photo' }}</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-12 pt-8 border-t border-gray-400 text-center text-xs text-gray-500">
            <p>Generated by Fire Safety Management System on {{ new Date().toLocaleDateString() }}</p>
        </div>
    </div>
</template>

<style scoped>
@media print {
    body {
        background: white;
    }
}
</style>
