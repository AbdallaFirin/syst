<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    reportData: Object,
    filters: Object,
});

const page = usePage();
const organization = computed(() => page.props.organization || {});
const currentDate = new Date().toLocaleDateString('en-GB');

const form = useForm({
    start_date: props.filters.start_date || '',
    end_date: props.filters.end_date || '',
});

// Editable fields for the report (Client-side temporary state for print)
const reportTitle = ref('Fire Safety & Operational Report');
const introduction = ref('This report summarizes the operational activities, fire incidents, and safety measures undertaken by the department during the specified period.');
const conclusion = ref('The department continues to maintain high operational readiness. Recommendations have been noted for future improvements.');

const submit = () => {
    form.get(route('reports.index'));
};

const printReport = () => {
    window.print();
};

const isCustomMode = ref(false);

const toggleCustomMode = () => {
    isCustomMode.value = !isCustomMode.value;
};

const generateQuickReport = (type) => {
    isCustomMode.value = false; // Hide custom inputs
    const today = new Date();
    const formatDate = (date) => date.toISOString().split('T')[0];

    form.end_date = formatDate(today);
    let start = new Date(today);

    if (type === 'daily') {
        form.start_date = formatDate(today);
    } else if (type === 'weekly') {
        // Last 7 days including today
        start.setDate(today.getDate() - 6);
        form.start_date = formatDate(start);
    } else if (type === 'monthly') {
        // Start of current month
        start = new Date(today.getFullYear(), today.getMonth(), 1);
        form.start_date = formatDate(start);
    } else if (type === 'yearly') {
        // Start of current year
        start = new Date(today.getFullYear(), 0, 1);
        form.start_date = formatDate(start);
    }

    // Auto submit
    submit();
};
</script>

<template>

    <Head title="Reports" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reports Generation</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <!-- Search/Filter Card (Hidden when printing) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8 no-print">
                    <div class="p-6 text-gray-900">
                        <div class="flex flex-col gap-4">
                            <!-- Report Mode Selection -->
                            <div class="flex flex-wrap gap-2">
                                <button type="button" @click="generateQuickReport('daily')"
                                    class="px-4 py-2 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-md text-sm font-medium text-indigo-700 transition">
                                    Daily Report
                                </button>
                                <button type="button" @click="generateQuickReport('weekly')"
                                    class="px-4 py-2 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-md text-sm font-medium text-indigo-700 transition">
                                    Weekly Report
                                </button>
                                <button type="button" @click="generateQuickReport('monthly')"
                                    class="px-4 py-2 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-md text-sm font-medium text-indigo-700 transition">
                                    Monthly Report
                                </button>
                                <button type="button" @click="generateQuickReport('yearly')"
                                    class="px-4 py-2 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-md text-sm font-medium text-indigo-700 transition">
                                    Yearly Report
                                </button>
                                <button type="button" @click="toggleCustomMode"
                                    :class="isCustomMode ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                    class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium transition">
                                    Custom Range
                                </button>
                            </div>

                            <!-- Custom Date Inputs (only visible in Custom Mode) -->
                            <form v-if="isCustomMode" @submit.prevent="submit"
                                class="p-4 bg-gray-50 rounded-md border border-gray-200 mt-2">
                                <div class="flex flex-col md:flex-row gap-4 items-end">
                                    <div class="w-full md:w-1/3">
                                        <InputLabel for="start_date" value="Start Date" />
                                        <TextInput id="start_date" type="date" v-model="form.start_date"
                                            class="mt-1 block w-full" required />
                                    </div>
                                    <div class="w-full md:w-1/3">
                                        <InputLabel for="end_date" value="End Date" />
                                        <TextInput id="end_date" type="date" v-model="form.end_date"
                                            class="mt-1 block w-full" required />
                                    </div>
                                    <div class="w-full md:w-auto">
                                        <PrimaryButton :disabled="form.processing">Generate Custom Report
                                        </PrimaryButton>
                                    </div>
                                </div>
                            </form>

                            <!-- Print Button (Always visible if report exists) -->
                            <div v-if="reportData.summary" class="mt-2 flex justify-end">
                                <button type="button" @click="printReport"
                                    class="flex items-center gap-2 px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                                        </path>
                                    </svg>
                                    Print PDF
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Report Preview (The Printable Area) -->
                <div v-if="reportData.summary" class="bg-white shadow-lg sm:rounded-none p-8 md:p-12 print-container"
                    id="report-page">

                    <!-- 1. Header -->
                    <div class="flex justify-between items-center border-b-2 border-gray-800 pb-6 mb-8">
                        <div class="flex items-center gap-4">
                            <img v-if="organization.logo_path" :src="'/storage/' + organization.logo_path"
                                class="h-20 w-auto object-contain" alt="Logo">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 uppercase tracking-wide">{{
                                    organization.name ||
                                    'Fire Safety Department' }}</h1>
                                <p class="text-sm text-gray-600">{{ organization.contact_info }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <h2 class="text-xl font-bold text-gray-800">OFFICIAL REPORT</h2>
                            <p class="text-sm text-gray-500">Date: {{ currentDate }}</p>
                        </div>
                    </div>

                    <!-- 2. Report Meta -->
                    <div class="mb-8 bg-gray-50 p-4 rounded-md border border-gray-200">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase">Report Title</label>
                                <input v-model="reportTitle"
                                    class="w-full bg-transparent border-none p-0 text-lg font-semibold text-gray-900 focus:ring-0" />
                            </div>
                            <div class="text-right">
                                <label class="block text-xs font-bold text-gray-500 uppercase">Reporting Period</label>
                                <p class="text-gray-900 font-medium">{{ form.start_date }} to {{ form.end_date }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Introduction -->
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-gray-800 mb-2 border-l-4 border-indigo-600 pl-3">1.
                            Introduction</h3>
                        <textarea v-model="introduction"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-700"
                            rows="3"></textarea>
                    </div>

                    <!-- 2. Incident Log -->
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 border-l-4 border-indigo-600 pl-3">2. Incident
                            Log</h3>
                        <div v-if="reportData.incidents.length > 0">
                            <table
                                class="w-full text-sm text-left text-gray-600 border-collapse border border-gray-300">
                                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                                    <tr>
                                        <th class="border border-gray-300 px-4 py-2 print:px-1 print:py-1">Taariikh</th>
                                        <th class="border border-gray-300 px-4 py-2 print:px-1 print:py-1">Nooca Dabka
                                        </th>
                                        <th class="border border-gray-300 px-4 py-2 print:px-1 print:py-1">Goobta</th>
                                        <th class="border border-gray-300 px-4 py-2 print:px-1 print:py-1">Sababta</th>
                                        <th class="border border-gray-300 px-4 py-2 print:px-1 print:py-1 text-center">
                                            Khasaaro
                                            Nafyeed</th>
                                        <th class="border border-gray-300 px-4 py-2 print:px-1 print:py-1">Khasaaro
                                            Hantiyeed
                                        </th>
                                        <th class="border border-gray-300 px-4 py-2 print:px-1 print:py-1 text-right">
                                            Khasaaro
                                            Maaliyadeed
                                        </th>
                                        <th class="border border-gray-300 px-4 py-2 print:px-1 print:py-1">Hanti La
                                            Badbaadiyey
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="inc in reportData.incidents" :key="inc.id">
                                        <td class="border border-gray-300 px-4 py-2 print:px-1 print:py-1">
                                            {{ new Date(inc.incident_date).toLocaleDateString() }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2 print:px-1 print:py-1">{{
                                            inc.place?.category?.name || '-'
                                            }}</td>
                                        <td class="border border-gray-300 px-4 py-2 print:px-1 print:py-1">{{
                                            inc.place?.name }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2 print:px-1 print:py-1">{{
                                            inc.cause?.name }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2 print:px-1 print:py-1 text-center">
                                            {{ inc.human_loss }} Dhimasho, {{ inc.injured_people }} Dhaawac
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2 print:px-1 print:py-1">{{
                                            inc.property_damage || '-' }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2 print:px-1 print:py-1 text-right">
                                            ${{
                                                inc.financial_loss.toLocaleString() }}</td>
                                        <td class="border border-gray-300 px-4 py-2 print:px-1 print:py-1">{{
                                            inc.rescued_assets
                                            || '-' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-if="reportData.incidents.length === 0" class="text-gray-500 italic text-sm">No incidents
                            recorded
                            for this period.</div>
                    </div>

                    <!-- 3. Isoo Koobid (Summary Matrix) -->
                    <div
                        class="mb-8 p-6 print:mb-4 print:p-2 bg-gray-50 border border-gray-200 rounded-lg break-inside-avoid print:w-[85%] print:mx-auto">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 border-l-4 border-indigo-600 pl-3">3. Isoo
                            Koobid
                            (Summary)</h3>
                        <div class="grid grid-cols-2 md:grid-cols-5 print:grid-cols-4 gap-4 text-center">
                            <!-- Total Incidents -->
                            <div class="p-4 bg-white rounded shadow-sm border border-gray-100">
                                <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Tirada Guud ee Dabka
                                </p>
                                <p class="text-2xl font-bold text-gray-800">{{ reportData.summary.total_incidents }}
                                </p>
                            </div>

                            <!-- Human Loss -->
                            <div class="p-4 bg-white rounded shadow-sm border border-gray-100">
                                <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Khasaaro Nafyeed</p>
                                <div class="text-sm font-bold text-gray-800">
                                    <span class="text-red-600">{{ reportData.summary.total_human_loss }}
                                        Dhimasho</span>
                                    <br>
                                    <span class="text-yellow-600">{{ reportData.summary.total_injured }}
                                        Dhaawac</span>
                                </div>
                            </div>

                            <!-- Financial Loss -->
                            <div class="p-4 bg-white rounded shadow-sm border border-gray-100">
                                <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Khasaaro Maaliyadeed</p>
                                <p class="text-xl font-bold text-gray-800">${{
                                    reportData.summary.total_financial_loss.toLocaleString() }}</p>
                            </div>


                            <!-- Rescued -->
                            <div class="p-4 bg-white rounded shadow-sm border border-gray-100">
                                <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Dadka La Badbaadiyey
                                </p>
                                <p class="text-2xl font-bold text-green-600">{{ reportData.summary.total_rescued }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Conclusion -->
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-gray-800 mb-2 border-l-4 border-indigo-600 pl-3">4.
                            Conclusion
                            &
                            Recommendations</h3>
                        <textarea v-model="conclusion"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-700"
                            rows="3"></textarea>
                    </div>

                    <!-- 9. Footer -->
                    <div
                        class="mt-12 pt-6 border-t-2 border-gray-800 flex justify-between items-end text-sm text-gray-600">
                        <div class="w-2/3">
                            <p class="mb-1 font-bold">{{ organization.name }}</p>
                            <p>{{ organization.footer_info }}</p>
                        </div>
                        <div class="text-right">
                            <p>Page 1 of 1</p>
                        </div>
                    </div>
                </div>

                <div v-else class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-12 text-center text-gray-500">
                    Please select a date range to generate the report.
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
@media print {
    body * {
        visibility: hidden;
    }

    .print-container,
    .print-container * {
        visibility: visible;
    }

    .print-container {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        margin: 0;
        padding: 20px;
        box-shadow: none;
    }

    .no-print {
        display: none !important;
    }

    /* Hide input borders when printing for cleaner look */
    textarea,
    input {
        border: none !important;
        resize: none;
        padding: 0;
    }
}
</style>