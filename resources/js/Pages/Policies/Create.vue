<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    file_path: null,
});

const submit = () => {
    form.post(route('policies.store'), {
        forceFormData: true,
    });
};
</script>

<template>
    <Head title="Upload Policy" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Upload New Policy</h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <!-- Name -->
                            <div>
                                <InputLabel for="name" value="Policy Name" />
                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    required
                                    autofocus
                                    placeholder="e.g. Fire Safety Guidelines 2025"
                                />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <!-- File Upload -->
                            <div class="mt-4">
                                <InputLabel for="file_path" value="Policy Document (PDF, DOCX)" />
                                <input
                                    id="file_path"
                                    type="file"
                                    class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                    @input="form.file_path = $event.target.files[0]"
                                    required
                                    accept=".pdf,.doc,.docx,.jpg,.png"
                                />
                                <p class="mt-1 text-sm text-gray-500">PDF, DOC, DOCX, JPG, PNG (Max 10MB).</p>
                                <InputError class="mt-2" :message="form.errors.file_path" />
                            </div>

                            <div class="flex items-center justify-end mt-6">
                                <Link
                                    :href="route('policies.index')"
                                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    Cancel
                                </Link>

                                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Upload Policy
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
