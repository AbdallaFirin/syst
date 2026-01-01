<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, router } from '@inertiajs/vue3';

const props = defineProps({
    organization: Object,
});

const form = useForm({
    name: props.organization.name || '',
    contact_info: props.organization.contact_info || '',
    footer_info: props.organization.footer_info || '',
    logo: null,
});

const submit = () => {
    form.post(route('organization.update'), {
        forceFormData: true,
    });
};
</script>

<template>

    <Head title="Organization Settings" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Organization Settings</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <form @submit.prevent="submit" enctype="multipart/form-data">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                <div class="col-span-2">
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">General Information</h3>
                                </div>

                                <div class="col-span-1">
                                    <InputLabel for="name" value="Organization Name" />
                                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name"
                                        required autofocus />
                                    <InputError class="mt-2" :message="form.errors.name" />
                                </div>

                                <div class="col-span-1">
                                    <InputLabel for="contact_info" value="Contact Information" />
                                    <TextInput id="contact_info" type="text" class="mt-1 block w-full"
                                        v-model="form.contact_info" placeholder="e.g. Phone, Email, Address" />
                                    <InputError class="mt-2" :message="form.errors.contact_info" />
                                </div>

                                <div class="col-span-2">
                                    <InputLabel for="footer_info" value="Footer Text (for Reports)" />
                                    <textarea id="footer_info"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        v-model="form.footer_info" rows="3"
                                        placeholder="Text to appear at the bottom of printed reports"></textarea>
                                    <InputError class="mt-2" :message="form.errors.footer_info" />
                                </div>

                                <div class="col-span-2">
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Branding</h3>
                                </div>

                                <div class="col-span-1">
                                    <InputLabel for="logo" value="Organization Logo" />
                                    <div v-if="organization.logo_path" class="mb-2">
                                        <p class="text-sm text-gray-500 mb-1">Current Logo:</p>
                                        <img :src="'/storage/' + organization.logo_path" alt="Logo"
                                            class="h-16 w-auto object-contain border p-1 rounded" />
                                    </div>
                                    <input id="logo" type="file" @input="form.logo = $event.target.files[0]"
                                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                                    <progress v-if="form.progress" :value="form.progress.percentage" max="100"
                                        class="max-w-full h-2 mt-2 bg-indigo-200 rounded">
                                        {{ form.progress.percentage }}%
                                    </progress>
                                    <InputError class="mt-2" :message="form.errors.logo" />
                                </div>

                            </div>

                            <div class="flex items-center justify-end mt-6">
                                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing">
                                    Save Changes
                                </PrimaryButton>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
