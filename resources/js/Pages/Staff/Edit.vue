<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    staff: Object,
});

const form = useForm({
    name: props.staff.name,
    position: props.staff.position,
    shift: props.staff.shift,
    phone_number: props.staff.phone_number,
    is_active: Boolean(props.staff.is_active),
});

const submit = () => {
    form.put(route('staff.update', props.staff.id));
};

const positionOptions = ref([
    'Management',
    'Office Staff',
    'Driver',
    'Operational Staff'
]);

// Ensure the current position is in the list
if (props.staff.position && !positionOptions.value.includes(props.staff.position)) {
    positionOptions.value.push(props.staff.position);
}

const isAddingPosition = ref(false);
const newPosition = ref('');

const handlePositionChange = () => {
    if (form.position === 'create_new') {
        form.position = '';
        isAddingPosition.value = true;
    }
};

const saveNewPosition = () => {
    if (newPosition.value) {
        positionOptions.value.push(newPosition.value);
        form.position = newPosition.value;
        isAddingPosition.value = false;
        newPosition.value = '';
    }
};
</script>

<template>

    <Head title="Edit Staff" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Staff Member</h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <!-- Name -->
                            <div>
                                <InputLabel for="name" value="Full Name" />
                                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required
                                    autofocus autocomplete="name" />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <!-- Position -->
                            <div class="mt-4">
                                <InputLabel for="position" value="Position / Role" />
                                <select id="position" v-model="form.position" @change="handlePositionChange"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    required>
                                    <option value="" disabled>Select Position</option>
                                    <option v-for="pos in positionOptions" :key="pos" :value="pos">{{ pos }}</option>
                                    <option value="create_new" class="font-bold text-blue-600">+ Add New Position
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.position" />
                            </div>

                            <!-- Shift -->
                            <div class="mt-4">
                                <InputLabel for="shift" value="Shift Assignment" />
                                <select id="shift" v-model="form.shift"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">No specific shift</option>
                                    <option value="Morning">Morning</option>
                                    <option value="Afternoon">Afternoon</option>
                                    <option value="Night">Night</option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.shift" />
                            </div>

                            <!-- Phone Number -->
                            <div class="mt-4">
                                <InputLabel for="phone_number" value="Phone Number" />
                                <TextInput id="phone_number" type="text" class="mt-1 block w-full"
                                    v-model="form.phone_number" required />
                                <InputError class="mt-2" :message="form.errors.phone_number" />
                            </div>

                            <!-- Status -->
                            <div class="block mt-4">
                                <label class="flex items-center">
                                    <input type="checkbox" v-model="form.is_active"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                                    <span class="ms-2 text-sm text-gray-600">Active Employee</span>
                                </label>
                            </div>

                            <div class="flex items-center justify-end mt-6">
                                <Link :href="route('staff.index')"
                                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Cancel
                                </Link>

                                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing">
                                    Update Staff Member
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <Modal :show="isAddingPosition" @close="isAddingPosition = false">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Add New Position
            </h2>
            <div class="mt-4">
                <InputLabel value="Position Title" />
                <TextInput v-model="newPosition" type="text" class="mt-1 block w-full" placeholder="e.g. Supervisor"
                    @keyup.enter="saveNewPosition" />
            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="isAddingPosition = false"> Cancel </SecondaryButton>
                <PrimaryButton class="ms-3" @click="saveNewPosition" :disabled="!newPosition"> Add Position
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>
