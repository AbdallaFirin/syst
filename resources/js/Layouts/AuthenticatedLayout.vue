<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { Link } from '@inertiajs/vue3';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

const showingNavigationDropdown = ref(false);

const openGroups = ref({
    management: route().current('places.*') || route().current('place-categories.*') || route().current('staff.*'),
    assets: route().current('vehicles.*') || route().current('chemicals.*'),
    operations: route().current('policies.*') || route().current('fire-incidents.*') || route().current('incident-causes.*') || route().current('reports.*'),
    settings: route().current('organization.*'),
});

const toggleGroup = (key) => {
    openGroups.value[key] = !openGroups.value[key];
};
</script>

<template>
    <div class="flex h-screen bg-gray-50">
        <!-- Sidebar (Desktop) -->
        <aside
            class="hidden w-64 flex-col border-r border-gray-800 bg-sidebar-dark text-white md:flex transition-all duration-300">
            <!-- Logo -->
            <div
                class="flex h-16 shrink-0 items-center justify-center border-b border-gray-800 px-6 bg-sidebar-darker/50">
                <Link :href="route('dashboard')">
                    <ApplicationLogo class="block h-10 w-auto fill-current text-white" />
                </Link>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
                <Link :href="route('dashboard')" :class="[
                    route().current('dashboard')
                        ? 'bg-brand-600 text-white shadow-md'
                        : 'text-gray-400 hover:bg-gray-800 hover:text-white',
                    'group flex w-full items-center rounded-lg px-3 py-2.5 text-sm font-medium transition-colors'
                ]">
                    <svg class="mr-3 h-5 w-5 flex-shrink-0"
                        :class="route().current('dashboard') ? 'text-white' : 'text-gray-500 group-hover:text-white'"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </Link>

                <button @click="toggleGroup('management')"
                    class="flex w-full items-center justify-between px-3 pt-6 pb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider hover:text-gray-300 focus:outline-none transition-colors">
                    <span>Management</span>
                    <svg class="h-4 w-4 transition-transform duration-200"
                        :class="{ 'rotate-90': openGroups.management }" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div v-show="openGroups.management" class="space-y-1">
                    <Link :href="route('places.index')" :class="[
                        route().current('places.*')
                            ? 'bg-brand-600 text-white'
                            : 'text-gray-400 hover:bg-gray-800 hover:text-white',
                        'group flex w-full items-center rounded-lg px-3 py-2 text-sm font-medium pl-9 transition-colors'
                    ]">
                        Places
                    </Link>

                    <Link :href="route('place-categories.index')" :class="[
                        route().current('place-categories.*')
                            ? 'bg-brand-600 text-white'
                            : 'text-gray-400 hover:bg-gray-800 hover:text-white',
                        'group flex w-full items-center rounded-lg px-3 py-2 text-sm font-medium pl-9 transition-colors'
                    ]">
                        Categories
                    </Link>

                    <Link :href="route('staff.index')" :class="[
                        route().current('staff.*')
                            ? 'bg-brand-600 text-white'
                            : 'text-gray-400 hover:bg-gray-800 hover:text-white',
                        'group flex w-full items-center rounded-lg px-3 py-2 text-sm font-medium pl-9 transition-colors'
                    ]">
                        Staff
                    </Link>
                </div>

                <button @click="toggleGroup('assets')"
                    class="flex w-full items-center justify-between px-3 pt-6 pb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider hover:text-gray-300 focus:outline-none transition-colors">
                    <span>Assets</span>
                    <svg class="h-4 w-4 transition-transform duration-200" :class="{ 'rotate-90': openGroups.assets }"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div v-show="openGroups.assets" class="space-y-1">
                    <Link :href="route('vehicles.index')" :class="[
                        route().current('vehicles.*')
                            ? 'bg-brand-600 text-white'
                            : 'text-gray-400 hover:bg-gray-800 hover:text-white',
                        'group flex w-full items-center rounded-lg px-3 py-2 text-sm font-medium pl-9 transition-colors'
                    ]">
                        Vehicles
                    </Link>

                    <Link :href="route('chemicals.index')" :class="[
                        route().current('chemicals.*')
                            ? 'bg-brand-600 text-white'
                            : 'text-gray-400 hover:bg-gray-800 hover:text-white',
                        'group flex w-full items-center rounded-lg px-3 py-2 text-sm font-medium pl-9 transition-colors'
                    ]">
                        Chemicals
                    </Link>
                </div>

                <button @click="toggleGroup('operations')"
                    class="flex w-full items-center justify-between px-3 pt-6 pb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider hover:text-gray-300 focus:outline-none transition-colors">
                    <span>Operations</span>
                    <svg class="h-4 w-4 transition-transform duration-200"
                        :class="{ 'rotate-90': openGroups.operations }" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div v-show="openGroups.operations" class="space-y-1">
                    <Link :href="route('policies.index')" :class="[
                        route().current('policies.*')
                            ? 'bg-brand-600 text-white'
                            : 'text-gray-400 hover:bg-gray-800 hover:text-white',
                        'group flex w-full items-center rounded-lg px-3 py-2 text-sm font-medium pl-9 transition-colors'
                    ]">
                        Policies
                    </Link>

                    <Link :href="route('fire-incidents.index')" :class="[
                        route().current('fire-incidents.*') || route().current('incident-causes.*')
                            ? 'bg-brand-600 text-white'
                            : 'text-gray-400 hover:bg-gray-800 hover:text-white',
                        'group flex w-full items-center rounded-lg px-3 py-2 text-sm font-medium pl-9 transition-colors'
                    ]">
                        Incidents
                    </Link>

                    <Link :href="route('reports.index')" :class="[
                        route().current('reports.index')
                            ? 'bg-brand-600 text-white'
                            : 'text-gray-400 hover:bg-gray-800 hover:text-white',
                        'group flex w-full items-center rounded-lg px-3 py-2 text-sm font-medium pl-9 transition-colors'
                    ]">
                        Reports
                    </Link>
                </div>

                <button @click="toggleGroup('settings')"
                    class="flex w-full items-center justify-between px-3 pt-6 pb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider hover:text-gray-300 focus:outline-none transition-colors">
                    <span>Settings</span>
                    <svg class="h-4 w-4 transition-transform duration-200"
                        :class="{ '-rotate-90': !openGroups.settings }" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div v-show="openGroups.settings" class="space-y-1">
                    <Link :href="route('organization.edit')" :class="[
                        route().current('organization.*')
                            ? 'bg-brand-600 text-white'
                            : 'text-gray-400 hover:bg-gray-800 hover:text-white',
                        'group flex w-full items-center rounded-lg px-3 py-2 text-sm font-medium pl-9 transition-colors'
                    ]">
                        Organization
                    </Link>
                </div>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <div class="flex flex-1 flex-col overflow-hidden">
            <!-- Top Header -->
            <header
                class="sticky top-0 z-10 flex h-16 shrink-0 items-center justify-between border-b border-gray-200 bg-white/80 backdrop-blur-md px-4 shadow-sm sm:px-6 lg:px-8">
                <div class="flex items-center">
                    <!-- Mobile Hamburger -->
                    <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                        class="mr-4 text-gray-500 focus:outline-none md:hidden">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <!-- Page Heading (Optional in Header, usually in slot) -->
                    <div v-if="$slots.header">
                        <slot name="header" />
                    </div>
                </div>

                <!-- Settings Dropdown -->
                <div class="flex items-center">
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button type="button"
                                    class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none">
                                    {{ $page.props.auth.user.name }}
                                    <svg class="-me-0.5 ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </span>
                        </template>

                        <template #content>
                            <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
                            <DropdownLink :href="route('logout')" method="post" as="button"> Log Out </DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </header>

            <!-- Mobile Menu -->
            <div v-if="showingNavigationDropdown" class="md:hidden border-b border-gray-200 bg-white">
                <div class="space-y-1 pb-3 pt-2">
                    <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                        Dashboard
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('places.index')" :active="route().current('places.*')">
                        Places
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('place-categories.index')"
                        :active="route().current('place-categories.*')">
                        Categories
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('staff.index')" :active="route().current('staff.*')">
                        Staff
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('vehicles.index')" :active="route().current('vehicles.*')">
                        Vehicles
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('chemicals.index')" :active="route().current('chemicals.*')">
                        Chemicals
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('fire-incidents.index')"
                        :active="route().current('fire-incidents.*')">
                        Incidents
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('reports.index')" :active="route().current('reports.index')">
                        Reports
                    </ResponsiveNavLink>
                </div>
            </div>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-100 p-6">
                <slot />
            </main>
        </div>
    </div>
</template>
