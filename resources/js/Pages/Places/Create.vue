<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    categories: Array,
    chemicals: Array, // Passed from controller
});

const form = useForm({
    name: '',
    place_category_id: '',
    location: '',
    contact_person: '',
    phone_number_1: '',
    phone_number_2: '',
    phone_number_3: '',
});

const handleCategoryChange = (event) => {
    if (form.place_category_id === 'create_new') {
        form.place_category_id = ''; // Reset selection so it doesn't stay on "Create New"
        isCreatingCategory.value = true;
    }
};

const submit = () => {
    form.post(route('places.store'));
};

// Logic for Quick Create Category
const isCreatingCategory = ref(false);
const newCategoryForm = useForm({
    name: '',
    required_equipment: [], // Initialize as array
});

// Since the main form doesn't pass chemicals, we might need a simple text input or fetch them.
// For simplicity in this quick add, let's use a text area for "Required Equipment" or just let it be empty/simple for now if possible? 
// The controller VALIDATES required_equipment as an ARRAY. So we must send an array.
// I'll add a simple input and split by comma or just allow one item for now to pass validation.

const createCategory = () => {
    // We need to submit to the store route. However, the store route returns a Redirect.
    // We should probably check if the controller handles JSON requests differently or if we need a new API endpoint.
    // The current controller returns redirect(), which Inertia handles. 
    // If we use axios and it detects we want JSON, Laravel might return JSON if configured, but explicit redirect usually forces it.
    // IMPORTANT: Custom headers to ask for JSON.

    axios.post(route('place-categories.store'), {
        name: newCategoryForm.name,
        required_equipment: newCategoryForm.required_equipment,
    }, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json', // Force JSON response if possible
        }
    }).then(response => {
        // The controller now returns the created category object (JSON)
        const newCategory = response.data;

        isCreatingCategory.value = false;
        newCategoryForm.reset();

        // We select the new category immediately
        form.place_category_id = newCategory.id;

        // We reload the categories list to ensure we have the latest data from server
        // We pass preserveScroll: true and preserveState: true (partial reload)
        router.reload({
            only: ['categories'],
            preserveState: true,
            preserveScroll: true,
        });

    }).catch(error => {
        console.error("Error creating category", error);
        alert("Failed to create category. Please ensure all fields are valid.");
    });
};

import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3'; // Import router
import axios from 'axios'; // We need axios
</script>

<template>

    <Head title="Register Place" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Register New Place</h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div>
                                    <InputLabel for="name" value="Place Name" />
                                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name"
                                        required autofocus autocomplete="name" />
                                    <InputError class="mt-2" :message="form.errors.name" />
                                </div>

                                <!-- Category -->
                                <div>
                                    <InputLabel for="category" value="Category" />
                                    <select id="category" v-model="form.place_category_id"
                                        @change="handleCategoryChange"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        required>
                                        <option value="" disabled>Select a category</option>
                                        <option v-for="category in categories" :key="category.id" :value="category.id">
                                            {{ category.name }}
                                        </option>
                                        <option value="create_new" class="font-bold text-blue-600">
                                            + Create New Category
                                        </option>
                                    </select>
                                    <InputError class="mt-2" :message="form.errors.place_category_id" />
                                </div>

                                <!-- Fast Create Category Modal -->
                                <Modal :show="isCreatingCategory" @close="isCreatingCategory = false">
                                    <div class="p-6">
                                        <h2 class="text-lg font-medium text-gray-900">
                                            Create New Category
                                        </h2>
                                        <p class="mt-1 text-sm text-gray-600">
                                            Add a new category securely to the database.
                                        </p>

                                        <div class="mt-6">
                                            <InputLabel for="new_category_name" value="Category Name" />
                                            <TextInput id="new_category_name" v-model="newCategoryForm.name" type="text"
                                                class="mt-1 block w-3/4" placeholder="e.g. Residential, Industrial" />
                                            <InputError :message="newCategoryForm.errors.name" class="mt-2" />
                                        </div>

                                        <div class="mt-4">
                                            <InputLabel value="Required Chemicals / Equipment (Select Multiple)" />
                                            <div
                                                class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-2 border border-gray-300 rounded-md p-4 max-h-60 overflow-y-auto">
                                                <div v-if="!chemicals || chemicals.length === 0"
                                                    class="text-sm text-gray-500">
                                                    No chemicals registered in system.
                                                </div>
                                                <label v-for="(chem, index) in chemicals" :key="index"
                                                    class="flex items-center space-x-2 cursor-pointer hover:bg-gray-50 p-1 rounded">
                                                    <input type="checkbox" :value="chem.name"
                                                        v-model="newCategoryForm.required_equipment"
                                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                                    <span class="text-sm text-gray-700">{{ chem.name }} ({{
                                                        chem.chemical_type
                                                        }})</span>
                                                </label>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1">Select the chemicals/equipment
                                                mandatory for
                                                this place category.</p>
                                        </div>

                                        <div class="mt-6 flex justify-end">
                                            <SecondaryButton @click="isCreatingCategory = false"> Cancel
                                            </SecondaryButton>

                                            <PrimaryButton class="ms-3"
                                                :class="{ 'opacity-25': newCategoryForm.processing }"
                                                :disabled="newCategoryForm.processing" @click="createCategory">
                                                Save Category
                                            </PrimaryButton>
                                        </div>
                                    </div>
                                </Modal>

                                <!-- Location -->
                                <div class="col-span-1 md:col-span-2">
                                    <InputLabel for="location" value="Location / Address" />
                                    <TextInput id="location" type="text" class="mt-1 block w-full"
                                        v-model="form.location" required />
                                    <InputError class="mt-2" :message="form.errors.location" />
                                </div>

                                <!-- Contact Person -->
                                <div>
                                    <InputLabel for="contact_person" value="Contact Person Name" />
                                    <TextInput id="contact_person" type="text" class="mt-1 block w-full"
                                        v-model="form.contact_person" required />
                                    <InputError class="mt-2" :message="form.errors.contact_person" />
                                </div>

                                <!-- Phone 1 -->
                                <div>
                                    <InputLabel for="phone_number_1" value="Primary Phone" />
                                    <TextInput id="phone_number_1" type="text" class="mt-1 block w-full"
                                        v-model="form.phone_number_1" required />
                                    <InputError class="mt-2" :message="form.errors.phone_number_1" />
                                </div>

                                <!-- Phone 2 -->
                                <div>
                                    <InputLabel for="phone_number_2" value="Secondary Phone (Optional)" />
                                    <TextInput id="phone_number_2" type="text" class="mt-1 block w-full"
                                        v-model="form.phone_number_2" />
                                    <InputError class="mt-2" :message="form.errors.phone_number_2" />
                                </div>

                                <!-- Phone 3 -->
                                <div>
                                    <InputLabel for="phone_number_3" value="Tertiary Phone (Optional)" />
                                    <TextInput id="phone_number_3" type="text" class="mt-1 block w-full"
                                        v-model="form.phone_number_3" />
                                    <InputError class="mt-2" :message="form.errors.phone_number_3" />
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-6">
                                <Link :href="route('places.index')"
                                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Cancel
                                </Link>

                                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing">
                                    Register Place
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
