<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    stats: Object,
    stats: Object,
    recent_incidents: Array,
    expiring_chemicals_list: Array,
});

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString(undefined, {
        year: 'numeric', month: 'short', day: 'numeric'
    });
};
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Overview</h2>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

                <!-- Welcome Board -->
                <div
                    class="bg-gradient-to-r from-brand-800 to-brand-600 rounded-2xl shadow-xl p-8 text-white flex justify-between items-center relative overflow-hidden">
                    <div class="relative z-10">
                        <h2 class="text-3xl font-bold">Welcome Back, Fire Safety Officer</h2>
                        <p class="mt-2 text-brand-100 text-lg">Here's what's happening in your facility today.</p>
                        <div class="mt-6 flex space-x-3">
                            <Link :href="route('fire-incidents.create')"
                                class="bg-white text-brand-700 px-5 py-2.5 rounded-lg font-semibold hover:bg-brand-50 transition shadow-sm">
                                + Log Incident
                            </Link>
                            <Link :href="route('reports.index')"
                                class="bg-brand-700 text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-brand-800 transition shadow-sm border border-brand-500">
                                View Reports
                            </Link>
                        </div>
                    </div>
                    <!-- Decorative Graphic -->
                    <div class="absolute right-0 top-0 h-full w-1/3 bg-white/5 skew-x-12 transform origin-bottom-right">
                    </div>
                    <div class="absolute right-10 bottom-0 text-9xl text-white/10">
                        <svg class="h-40 w-40" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 22h20L12 2zm0 3.5L18.5 20h-13L12 5.5z" />
                            <path opacity=".5" d="M12 8l-4 8h8l-4-8z" />
                        </svg>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Total Places -->
                    <div
                        class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Places</p>
                                <p class="text-3xl font-bold text-gray-900 mt-1">{{ stats.total_places }}</p>
                            </div>
                            <div class="p-3 bg-indigo-50 rounded-full text-indigo-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 text-sm text-green-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Monitored Active</span>
                        </div>
                    </div>

                    <!-- Incidents -->
                    <div
                        class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Incidents
                                </p>
                                <p class="text-3xl font-bold text-gray-900 mt-1">{{ stats.total_incidents }}</p>
                            </div>
                            <div class="p-3 bg-red-50 rounded-full text-red-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 text-sm text-gray-500">
                            Recorded this year
                        </div>
                    </div>

                    <!-- Staff -->
                    <div
                        class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Active Staff</p>
                                <p class="text-3xl font-bold text-gray-900 mt-1">{{ stats.total_staff }}</p>
                            </div>
                            <div class="p-3 bg-green-50 rounded-full text-green-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 text-sm text-gray-500">
                            On duty or available
                        </div>
                    </div>

                    <!-- Equipment Warning -->
                    <div
                        class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Expiring Chemicals
                                </p>
                                <p class="text-3xl font-bold mt-1"
                                    :class="stats.expiring_chemicals > 0 ? 'text-orange-600' : 'text-gray-900'">{{
                                        stats.expiring_chemicals }}</p>
                            </div>
                            <div class="p-3 bg-orange-50 rounded-full text-orange-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 text-sm">
                            <span v-if="stats.expiring_chemicals > 0" class="text-orange-600 font-semibold">Action
                                Required</span>
                            <span v-else class="text-green-600 font-semibold">All Good</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Matrix -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <Link :href="route('places.create')"
                            class="group flex items-center p-4 bg-gray-50 rounded-xl hover:bg-brand-50 hover:shadow-md transition-all cursor-pointer border border-transparent hover:border-brand-200">
                            <div
                                class="p-3 rounded-lg bg-white text-brand-600 shadow-sm group-hover:bg-brand-600 group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-bold text-gray-900 group-hover:text-brand-700">Add New Place
                                </p>
                                <p class="text-xs text-gray-500 mt-0.5">Register Facility</p>
                            </div>
                        </Link>

                        <Link :href="route('chemicals.create')"
                            class="group flex items-center p-4 bg-gray-50 rounded-xl hover:bg-orange-50 hover:shadow-md transition-all cursor-pointer border border-transparent hover:border-orange-200">
                            <div
                                class="p-3 rounded-lg bg-white text-orange-600 shadow-sm group-hover:bg-orange-500 group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-bold text-gray-900 group-hover:text-orange-700">Add Chemical
                                </p>
                                <p class="text-xs text-gray-500 mt-0.5">Update Stock</p>
                            </div>
                        </Link>

                        <Link :href="route('vehicles.create')"
                            class="group flex items-center p-4 bg-gray-50 rounded-xl hover:bg-green-50 hover:shadow-md transition-all cursor-pointer border border-transparent hover:border-green-200">
                            <div
                                class="p-3 rounded-lg bg-white text-green-600 shadow-sm group-hover:bg-green-600 group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-bold text-gray-900 group-hover:text-green-700">Add Vehicle
                                </p>
                                <p class="text-xs text-gray-500 mt-0.5">Register Fleet</p>
                            </div>
                        </Link>

                        <Link :href="route('fire-incidents.create')"
                            class="group flex items-center p-4 bg-gray-50 rounded-xl hover:bg-red-50 hover:shadow-md transition-all cursor-pointer border border-transparent hover:border-red-200">
                            <div
                                class="p-3 rounded-lg bg-white text-red-600 shadow-sm group-hover:bg-red-600 group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-bold text-gray-900 group-hover:text-red-700">Log Incident</p>
                                <p class="text-xs text-gray-500 mt-0.5">Emergency Record</p>
                            </div>
                        </Link>
                    </div>
                </div>

                <div class="flex flex-col lg:flex-row gap-6">
                    <!-- Recent Incidents (Flex Grow) -->
                    <div class="flex-1 min-w-0 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-900">Recent Incidents</h3>
                            <Link :href="route('fire-incidents.index')"
                                class="text-sm font-medium text-brand-600 hover:text-brand-800">
                                View All &rarr;
                            </Link>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm text-gray-600">
                                <thead class="bg-gray-50 text-xs uppercase text-gray-500 font-semibold">
                                    <tr>
                                        <th class="px-6 py-4">Date</th>
                                        <th class="px-6 py-4">Location</th>
                                        <th class="px-6 py-4">Cause</th>
                                        <th class="px-6 py-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <tr v-if="recent_incidents.length === 0">
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-400">No recent incidents
                                            recorded.</td>
                                    </tr>
                                    <tr v-for="incident in recent_incidents" :key="incident.id"
                                        class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 font-medium text-gray-900">{{
                                            formatDate(incident.incident_date) }}
                                        </td>
                                        <td class="px-6 py-4">{{ incident.place?.name || 'Unknown' }}</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ incident.cause?.name || 'Unknown' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Recorded
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Expiring Chemicals (Flex Grow) -->
                    <div class="flex-1 min-w-0 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-orange-50/50">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center">
                                <svg class="w-5 h-5 text-orange-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                    </path>
                                </svg>
                                Expiring Chemicals
                            </h3>
                            <Link :href="route('chemicals.index')"
                                class="text-sm font-medium text-orange-600 hover:text-orange-800">
                                Manage Inventory &rarr;
                            </Link>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm text-gray-600">
                                <thead class="bg-gray-50 text-xs uppercase text-gray-500 font-semibold">
                                    <tr>
                                        <th class="px-6 py-4">Name</th>
                                        <th class="px-6 py-4">Expiry Date</th>
                                        <th class="px-6 py-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <tr v-if="expiring_chemicals_list.length === 0">
                                        <td colspan="3" class="px-6 py-8 text-center text-gray-400">No chemicals
                                            expiring soon.
                                        </td>
                                    </tr>
                                    <tr v-for="chem in expiring_chemicals_list" :key="chem.id"
                                        class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ chem.name }}</td>
                                        <td class="px-6 py-4">{{ formatDate(chem.expiry_date) }}</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                Expiring Soon
                                            </span>
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