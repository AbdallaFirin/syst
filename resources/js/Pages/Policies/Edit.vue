<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    policy: Object,
});

// Since we are uploading a file (possibly) on put/patch, we might need a workaround for Inertia v1 methods not supporting multipart on PUT. 
// However, Inertia v2 might or using _method field in POST is the standard standard workaround.
// Laravel supports PUT/PATCH via POST with _method. 

const form = useForm({
    _method: 'PUT',
    name: props.policy.name,
    file_path: null,
});

const submit = () => {
    form.post(route('policies.update', props.policy.id), {
        forceFormData: true,
    });
};
</script>

<template>
    <Head title="Edit Policy" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Policy</h2>
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
                                />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <!-- File Upload -->
                            <div class="mt-4">
                                <InputLabel for="file_path" value="Replace Document (Optional)" />
                                <input
                                    id="file_path"
                                    type="file"
                                    class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                    @input="form.file_path = $event.target.files[0]"
                                    accept=".pdf,.doc,.docx,.jpg,.png"
                                />
                                <p class="mt-1 text-sm text-gray-500">Leave empty to keep current file.</p>
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
                                    Update Policy
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
