<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const showPassword = ref(false);

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>

    <Head title="Log in" />

    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Left Panel - Branding/Context -->
        <div
            class="hidden md:flex flex-col justify-between w-full md:w-1/2 bg-[#0F172A] text-white p-12 relative overflow-hidden">
            <!-- Background Image Overlay -->
            <div
                class="absolute inset-0 bg-[url('/images/login-bg.jpg')] bg-cover bg-center opacity-40 mix-blend-overlay">
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#0F172A] via-transparent to-[#0F172A]/80"></div>

            <!-- Branding -->
            <div class="relative z-10 flex items-center gap-3">
                <div class="text-blue-500">
                    <!-- Flame Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8">
                        <path fill-rule="evenodd"
                            d="M12.963 2.286a.75.75 0 00-1.071-.136 9.742 9.742 0 00-3.539 6.177 7.547 7.547 0 01-1.705-1.715.75.75 0 00-1.152-.082A9 9 0 1015.68 4.534a7.46 7.46 0 01-2.717-2.248zM15.75 14.25a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <h1 class="font-bold text-xl tracking-wide uppercase">Garowe District Fire Dept.</h1>
            </div>

            <!-- Hero Text -->
            <div class="relative z-10 max-w-lg mb-12">
                <h2 class="text-5xl font-bold leading-tight mb-6">Operational Excellence in Fire Safety</h2>
                <p class="text-lg text-gray-300 leading-relaxed">
                    This system monitors incident reporting, resource allocation, and safety compliance across the
                    district. Authorized access ensures data integrity and operational readiness.
                </p>
            </div>

            <!-- Footer -->
            <div class="relative z-10 text-sm text-gray-500">
                &copy; {{ new Date().getFullYear() }} Garowe District Administration. All Rights Reserved.
            </div>
        </div>

        <!-- Right Panel - Login Form -->
        <div class="w-full md:w-1/2 bg-white flex items-center justify-center p-8 relative">
            <div class="w-full max-w-md space-y-8">

                <!-- Login Header -->
                <div class="space-y-2">
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-1 bg-blue-600 rounded-full"></div>
                        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">System Login</h2>
                    </div>
                    <p class="text-gray-500 text-sm ml-5">
                        Please enter your official credentials to access the Fire Safety Management System.
                    </p>
                </div>

                <!-- Status Message -->
                <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="space-y-6 mt-8">
                    <!-- Username/Service ID -->
                    <div class="space-y-2">
                        <label for="email" class="text-xs font-bold text-gray-500 uppercase tracking-widest">
                            Service ID / Username
                        </label>
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <!-- ID Badge Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input id="email" type="email" v-model="form.email"
                                class="block w-full pl-10 pr-3 py-3 bg-gray-50 border border-gray-200 text-gray-900 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 sm:text-sm"
                                placeholder="e.g. GFD-8821" required autofocus autocomplete="username" />
                        </div>
                        <p v-if="form.errors.email" class="text-sm text-red-600 mt-1">{{ form.errors.email }}</p>
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <label for="password" class="text-xs font-bold text-gray-500 uppercase tracking-widest">
                                Password
                            </label>
                            <a v-if="canResetPassword" :href="route('password.request')"
                                class="text-xs font-semibold text-blue-600 hover:text-blue-500 transition-colors">
                                Forgot Password?
                            </a>
                        </div>
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <!-- Lock Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M12 1.5a5.25 5.25 0 00-5.25 5.25v3a3 3 0 00-3 3v6.75a3 3 0 003 3h10.5a3 3 0 003-3v-6.75a3 3 0 00-3-3v-3c0-2.9-2.35-5.25-5.25-5.25zm3.75 8.25v-3a3.75 3.75 0 10-7.5 0v3h7.5z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input id="password" :type="showPassword ? 'text' : 'password'" v-model="form.password"
                                class="block w-full pl-10 pr-10 py-3 bg-gray-50 border border-gray-200 text-gray-900 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 sm:text-sm"
                                placeholder="Enter your secure password" required autocomplete="current-password" />
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-400 hover:text-gray-600 transition-colors"
                                @click="showPassword = !showPassword">
                                <svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    fill="currentColor" class="w-5 h-5">
                                    <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                    <path fill-rule="evenodd"
                                        d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-5 h-5">
                                    <path
                                        d="M3.53 2.47a.75.75 0 00-1.06 1.06l18 18a.75.75 0 101.06-1.06l-18-18zM22.676 12.553a11.249 11.249 0 01-2.631 4.31l-3.099-3.099a5.25 5.25 0 00-6.71-6.71L7.759 4.577a11.217 11.217 0 014.242-.827c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113z" />
                                    <path
                                        d="M15.75 12c0 .18-.013.357-.037.53l-4.244-4.243A3.75 3.75 0 0115.75 12zM12.53 15.713l-4.243-4.244a3.75 3.75 0 004.243 4.244z" />
                                    <path
                                        d="M6.75 12c0-.619.107-1.213.304-1.764l-3.1-3.1a11.25 11.25 0 00-2.63 4.31c-.12.362-.12.752 0 1.114 1.489 4.467 5.704 7.69 10.675 7.69 1.5 0 2.933-.294 4.242-.827l-2.477-2.477A5.25 5.25 0 016.75 12z" />
                                </svg>
                            </div>
                        </div>
                        <p v-if="form.errors.password" class="text-sm text-red-600 mt-1">{{ form.errors.password }}</p>
                    </div>

                    <!-- Warning Banner -->
                    <div class="rounded-lg bg-blue-50 border border-blue-100 p-4 flex gap-3 items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-6 h-6 text-blue-600 shrink-0 mt-0.5">
                            <path fill-rule="evenodd"
                                d="M12.516 2.17a.75.75 0 00-1.032 0 11.209 11.209 0 01-7.877 3.08.75.75 0 00-.722.515A12.74 12.74 0 002.25 9.75c0 5.942 4.064 10.933 9.563 12.348a.749.749 0 00.374 0c5.499-1.415 9.563-6.406 9.563-12.348 0-1.352-.272-2.636-.759-3.985a.75.75 0 00-.722-.516l-.143.001c-2.996 0-5.717-1.17-7.734-3.08zm3.094 8.016a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                                clip-rule="evenodd" />
                        </svg>
                        <p class="text-[11px] leading-relaxed text-blue-800">
                            <strong>Official Use Only:</strong> This system is monitored. Unauthorized access attempts
                            are logged and may be subject to legal action under district regulations.
                        </p>
                    </div>

                    <!-- Submit Button -->
                    <button
                        class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-4 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-500/20 shadow-lg shadow-blue-600/20 transition-all duration-200 disabled:opacity-75 disabled:cursor-not-allowed"
                        :disabled="form.processing">
                        <span v-if="!form.processing">Secure Login</span>
                        <span v-else>Logging in...</span>
                        <svg v-if="!form.processing" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </form>

                <!-- Centered footer -->
                <div class="mt-10 flex flex-col items-center gap-2 text-xs text-gray-400">
                    <p>Need assistance? <strong class="text-gray-900 underline cursor-pointer">Contact IT
                            Support</strong></p>
                    <div class="flex gap-3 mt-2">
                        <span>v2.4.1 (Stable)</span>
                        <span>•</span>
                        <span class="hover:text-gray-600 cursor-pointer">Privacy Policy</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>
