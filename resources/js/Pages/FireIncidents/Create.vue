<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    places: Array,
    places: Array,
    causes: Array,
    categories: Array, // Added for Place creation modal
});

import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import axios from 'axios';
import { router } from '@inertiajs/vue3';

const form = useForm({
    place_id: '',
    incident_cause_id: '',
    incident_date: '',
    human_loss: 0,
    injured_people: 0,
    financial_loss: 0,
    property_damage: '',
    rescued_people: 0,
    rescued_assets: '',
    additional_notes: '',
    status: 'pending',
    image: null,
    image_caption: '',
});

const submit = () => {
    form.post(route('fire-incidents.store'));
};

const isCreatingPlace = ref(false);
const newPlaceForm = useForm({
    name: '',
    place_category_id: '',
    location: '',
    contact_person: '',
    phone_number_1: '',
});

const isCreatingCause = ref(false);
const newCauseForm = useForm({
    name: '',
    description: '',
});

const handlePlaceChange = () => {
    if (form.place_id === 'create_new') {
        form.place_id = '';
        isCreatingPlace.value = true;
    }
};

const handleCauseChange = () => {
    if (form.incident_cause_id === 'create_new') {
        form.incident_cause_id = '';
        isCreatingCause.value = true;
    }
};

const createPlace = () => {
    axios.post(route('places.store'), newPlaceForm.data(), {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    }).then(response => {
        const newPlace = response.data;
        isCreatingPlace.value = false;
        newPlaceForm.reset();
        form.place_id = newPlace.id;
        router.reload({ only: ['places'], preserveState: true, preserveScroll: true });
    }).catch(error => {
        console.error("Error creating place", error);
        alert("Failed to create place. Please check fields.");
    });
};

const createCause = () => {
    axios.post(route('incident-causes.store'), newCauseForm.data(), {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    }).then(response => {
        const newCause = response.data;
        isCreatingCause.value = false;
        newCauseForm.reset();
        form.incident_cause_id = newCause.id;
        router.reload({ only: ['causes'], preserveState: true, preserveScroll: true });
    }).catch(error => {
        console.error("Error creating cause", error);
        alert("Failed to create cause.");
    });
};
</script>

<template>

    <Head title="Report Fire Incident" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Report Fire Incident</h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                <!-- Core Info -->
                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel for="place_id" value="Affected Place" />
                                    <select id="place_id" v-model="form.place_id" @change="handlePlaceChange"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        required>
                                        <option value="" disabled>Select Place</option>
                                        <option v-for="place in places" :key="place.id" :value="place.id">
                                            {{ place.name }} ({{ place.location }})
                                        </option>
                                        <option value="create_new" class="font-bold text-blue-600">
                                            + Create New Place
                                        </option>
                                    </select>
                                    <InputError class="mt-2" :message="form.errors.place_id" />
                                </div>

                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel for="incident_date" value="Date & Time of Incident" />
                                    <TextInput id="incident_date" type="datetime-local" class="mt-1 block w-full"
                                        v-model="form.incident_date" required />
                                    <InputError class="mt-2" :message="form.errors.incident_date" />
                                </div>

                                <div class="col-span-2">
                                    <InputLabel for="incident_cause_id" value="Cause of Incident" />
                                    <select id="incident_cause_id" v-model="form.incident_cause_id"
                                        @change="handleCauseChange"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        required>
                                        <option value="" disabled>Select Cause</option>
                                        <option v-for="cause in causes" :key="cause.id" :value="cause.id">
                                            {{ cause.name }}
                                        </option>
                                        <option value="create_new" class="font-bold text-blue-600">
                                            + Create New Cause
                                        </option>
                                    </select>
                                    <InputError class="mt-2" :message="form.errors.incident_cause_id" />
                                </div>

                                <!-- Losses Section -->
                                <div class="col-span-2">
                                    <h3 class="text-lg font-medium text-red-600 border-b pb-2 mb-4">Losses & Casualties
                                    </h3>
                                </div>

                                <div>
                                    <InputLabel for="human_loss" value="Deaths" />
                                    <TextInput id="human_loss" type="number" class="mt-1 block w-full"
                                        v-model="form.human_loss" required min="0" />
                                    <InputError class="mt-2" :message="form.errors.human_loss" />
                                </div>

                                <div>
                                    <InputLabel for="injured_people" value="Injured Persons" />
                                    <TextInput id="injured_people" type="number" class="mt-1 block w-full"
                                        v-model="form.injured_people" required min="0" />
                                    <InputError class="mt-2" :message="form.errors.injured_people" />
                                </div>

                                <div>
                                    <InputLabel for="financial_loss" value="Financial Loss ($)" />
                                    <TextInput id="financial_loss" type="number" step="0.01" class="mt-1 block w-full"
                                        v-model="form.financial_loss" required min="0" />
                                    <InputError class="mt-2" :message="form.errors.financial_loss" />
                                </div>

                                <div>
                                    <InputLabel for="property_damage" value="Property Damage (Description)" />
                                    <textarea id="property_damage" v-model="form.property_damage"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        rows="2"
                                        placeholder="Describe damaged property e.g. 4 huts, 1 vehicle..."></textarea>
                                    <InputError class="mt-2" :message="form.errors.property_damage" />
                                </div>

                                <!-- Rescue Section -->
                                <div class="col-span-2">
                                    <h3 class="text-lg font-medium text-green-600 border-b pb-2 mb-4 mt-2">Rescue
                                        Operations
                                    </h3>
                                </div>

                                <div>
                                    <InputLabel for="rescued_people" value="People Rescued" />
                                    <TextInput id="rescued_people" type="number" class="mt-1 block w-full"
                                        v-model="form.rescued_people" required min="0" />
                                    <InputError class="mt-2" :message="form.errors.rescued_people" />
                                </div>

                                <div class="col-span-2">
                                    <InputLabel for="rescued_assets" value="Assets Saved (Description)" />
                                    <textarea id="rescued_assets" v-model="form.rescued_assets"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        rows="2"></textarea>
                                    <InputError class="mt-2" :message="form.errors.rescued_assets" />
                                </div>

                                <!-- Additional -->
                                <div class="col-span-2">
                                    <InputLabel for="additional_notes" value="Additional Notes" />
                                    <textarea id="additional_notes" v-model="form.additional_notes"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        rows="3"></textarea>
                                    <InputError class="mt-2" :message="form.errors.additional_notes" />
                                </div>

                                <!-- Evidence (Moved to First Form) -->
                                <div class="col-span-2 border-t pt-4 mt-2">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Evidence & Photos</h3>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Image Upload -->
                                        <div class="md:col-span-2">
                                            <InputLabel value="Upload Initial Photo (Evidence)" />
                                            <input type="file" @change="e => form.image = e.target.files[0]" accept="image/*" class="mt-1 block w-full text-sm text-gray-500
                                                    file:mr-4 file:py-2 file:px-4
                                                    file:rounded-full file:border-0
                                                    file:text-sm file:font-semibold
                                                    file:bg-indigo-50 file:text-indigo-700
                                                    hover:file:bg-indigo-100
                                                "/>
                                            <InputError class="mt-2" :message="form.errors.image" />
                                            
                                            <div class="mt-2">
                                                <InputLabel value="Caption" />
                                                <TextInput v-model="form.image_caption" type="text" class="mt-1 block w-full" placeholder="e.g. Front view of fire" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="flex items-center justify-end mt-6">
                                <Link :href="route('fire-incidents.index')"
                                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Cancel
                                </Link>

                                <PrimaryButton class="ms-4 bg-red-600 hover:bg-red-500"
                                    :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Submit Report
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <!-- Create Place Modal -->
    <Modal :show="isCreatingPlace" @close="isCreatingPlace = false">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Register New Place
            </h2>
            <div class="mt-4 grid grid-cols-1 gap-4">
                <div>
                    <InputLabel value="Name" />
                    <TextInput v-model="newPlaceForm.name" type="text" class="mt-1 block w-full" required
                        placeholder="Place Name" />
                </div>
                <div>
                    <InputLabel value="Category" />
                    <select v-model="newPlaceForm.place_category_id"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                    </select>
                </div>
                <div>
                    <InputLabel value="Location" />
                    <TextInput v-model="newPlaceForm.location" type="text" class="mt-1 block w-full" required
                        placeholder="Address/Location" />
                </div>
                <div>
                    <InputLabel value="Contact Person" />
                    <TextInput v-model="newPlaceForm.contact_person" type="text" class="mt-1 block w-full" required />
                </div>
                <div>
                    <InputLabel value="Phone" />
                    <TextInput v-model="newPlaceForm.phone_number_1" type="text" class="mt-1 block w-full" required />
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="isCreatingPlace = false"> Cancel </SecondaryButton>
                <PrimaryButton class="ms-3" @click="createPlace" :disabled="newPlaceForm.processing"> Save Place
                </PrimaryButton>
            </div>
        </div>
    </Modal>

    <!-- Create Cause Modal -->
    <Modal :show="isCreatingCause" @close="isCreatingCause = false">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Add Incident Cause
            </h2>
            <div class="mt-4">
                <InputLabel value="Cause Name" />
                <TextInput v-model="newCauseForm.name" type="text" class="mt-1 block w-full"
                    placeholder="e.g. Short Circuit" />
                <InputLabel value="Description" class="mt-2" />
                <textarea v-model="newCauseForm.description"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="3"></textarea>
            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="isCreatingCause = false"> Cancel </SecondaryButton>
                <PrimaryButton class="ms-3" @click="createCause" :disabled="newCauseForm.processing"> Save Cause
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>
