<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    vehicle: Object,
    vehicle: Object,
    drivers: Array,
});

import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { router } from '@inertiajs/vue3';
import axios from 'axios';

const form = useForm({
    vehicle_type: props.vehicle.vehicle_type,
    plate_number: props.vehicle.plate_number,
    staff_id: props.vehicle.staff_id,
});

const submit = () => {
    form.put(route('vehicles.update', props.vehicle.id));
};

const isCreatingDriver = ref(false);
const newDriverForm = useForm({
    name: '',
    phone_number: '',
});

const handleDriverChange = () => {
    if (form.staff_id === 'create_new') {
        form.staff_id = '';
        isCreatingDriver.value = true;
    }
};

const createDriver = () => {
    axios.post(route('staff.store'), {
        name: newDriverForm.name,
        phone_number: newDriverForm.phone_number,
        position: 'Driver',
        shift: 'Morning',
    }, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    }).then(response => {
        const newDriver = response.data;
        isCreatingDriver.value = false;
        newDriverForm.reset();
        form.staff_id = newDriver.id;
        router.reload({ only: ['drivers'], preserveState: true, preserveScroll: true });
    }).catch(error => {
        console.error("Error creating driver", error);
        alert("Failed to register driver. Please check inputs.");
    });
};
</script>

<template>

    <Head title="Edit Vehicle" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Vehicle</h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <!-- Type -->
                            <div>
                                <InputLabel for="vehicle_type" value="Vehicle Type" />
                                <TextInput id="vehicle_type" type="text" class="mt-1 block w-full"
                                    v-model="form.vehicle_type" required autofocus />
                                <InputError class="mt-2" :message="form.errors.vehicle_type" />
                            </div>

                            <!-- Plate -->
                            <div class="mt-4">
                                <InputLabel for="plate_number" value="Plate Number" />
                                <TextInput id="plate_number" type="text" class="mt-1 block w-full"
                                    v-model="form.plate_number" required />
                                <InputError class="mt-2" :message="form.errors.plate_number" />
                            </div>

                            <!-- Driver -->
                            <div class="mt-4">
                                <InputLabel for="staff_id" value="Assigned Driver (Optional)" />
                                <select id="staff_id" v-model="form.staff_id" @change="handleDriverChange"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">None</option>
                                    <option v-for="driver in drivers" :key="driver.id" :value="driver.id">
                                        {{ driver.name }}
                                    </option>
                                    <option value="create_new" class="font-bold text-blue-600">
                                        + Register New Driver
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.staff_id" />
                            </div>

                            <div class="flex items-center justify-end mt-6">
                                <Link :href="route('vehicles.index')"
                                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Cancel
                                </Link>

                                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing">
                                    Update Vehicle
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <!-- Create Driver Modal -->
    <Modal :show="isCreatingDriver" @close="isCreatingDriver = false">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Register New Driver
            </h2>
            <div class="mt-4 grid grid-cols-1 gap-4">
                <div>
                    <InputLabel value="Full Name" />
                    <TextInput v-model="newDriverForm.name" type="text" class="mt-1 block w-full" required />
                </div>
                <div>
                    <InputLabel value="Phone Number" />
                    <TextInput v-model="newDriverForm.phone_number" type="text" class="mt-1 block w-full" required />
                </div>
                <p class="text-sm text-gray-500">Note: Position will be set to 'Driver'.</p>
            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="isCreatingDriver = false"> Cancel </SecondaryButton>
                <PrimaryButton class="ms-3" @click="createDriver" :disabled="newDriverForm.processing"> Save Driver
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>
