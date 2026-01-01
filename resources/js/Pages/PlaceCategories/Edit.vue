<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const props = defineProps({
    category: Object,
    chemicals: Array
});

// Helper to parse JSON safely
const getInitialEquipment = () => {
    try {
        const val = JSON.parse(props.category.required_equipment);
        return Array.isArray(val) ? val : [];
    } catch (e) {
        return [];
    }
};

const form = useForm({
    name: props.category.name,
    required_equipment: getInitialEquipment(),
});

const submit = () => {
    form.put(route('place-categories.update', props.category.id));
};
</script>

<template>
    <Head title="Edit Category" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Place Category</h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <!-- Name -->
                            <div>
                                <InputLabel for="name" value="Category Name" />
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

                             <!-- Required Equipment (Multi-Select) -->
                            <div class="mt-4">
                                <InputLabel value="Required Chemicals / Equipment (Select Multiple)" />
                                <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-2 border border-gray-300 rounded-md p-4 max-h-60 overflow-y-auto">
                                    <div v-if="chemicals.length === 0" class="text-sm text-gray-500">
                                        No chemicals registered in system.
                                    </div>
                                    <label v-for="(chem, index) in chemicals" :key="index" class="flex items-center space-x-2 cursor-pointer hover:bg-gray-50 p-1 rounded">
                                        <input 
                                            type="checkbox" 
                                            :value="chem.name" 
                                            v-model="form.required_equipment"
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                        >
                                        <span class="text-sm text-gray-700">{{ chem.name }} ({{ chem.chemical_type }})</span>
                                    </label>
                                </div>
                                <InputError class="mt-2" :message="form.errors.required_equipment" />
                            </div>

                            <div class="flex items-center justify-end mt-6">
                                <Link
                                    :href="route('place-categories.index')"
                                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    Cancel
                                </Link>

                                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Update Category
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
