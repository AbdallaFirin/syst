<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    chemical: Object,
});

const form = useForm({
    name: props.chemical.name,
    chemical_type: props.chemical.chemical_type,
    manufacture_date: props.chemical.manufacture_date,
    expiry_date: props.chemical.expiry_date,
    quantity: props.chemical.quantity,
    unit: props.chemical.unit,
});

const submit = () => {
    form.put(route('chemicals.update', props.chemical.id));
};
</script>

<template>
    <Head title="Edit Chemical" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Chemical</h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div class="col-span-2">
                                    <InputLabel for="name" value="Chemical Name" />
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

                                <!-- Type -->
                                <div class="col-span-2">
                                    <InputLabel for="chemical_type" value="Type / Classification" />
                                    <TextInput
                                        id="chemical_type"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.chemical_type"
                                        required
                                    />
                                    <InputError class="mt-2" :message="form.errors.chemical_type" />
                                </div>

                                <!-- Manufacture Date -->
                                <div>
                                    <InputLabel for="manufacture_date" value="Manufacture Date" />
                                    <TextInput
                                        id="manufacture_date"
                                        type="date"
                                        class="mt-1 block w-full"
                                        v-model="form.manufacture_date"
                                        required
                                    />
                                    <InputError class="mt-2" :message="form.errors.manufacture_date" />
                                </div>

                                <!-- Expiry Date -->
                                <div>
                                    <InputLabel for="expiry_date" value="Expiry Date" />
                                    <TextInput
                                        id="expiry_date"
                                        type="date"
                                        class="mt-1 block w-full"
                                        v-model="form.expiry_date"
                                        required
                                    />
                                    <InputError class="mt-2" :message="form.errors.expiry_date" />
                                </div>

                                <!-- Quantity -->
                                <div>
                                    <InputLabel for="quantity" value="Quantity" />
                                    <TextInput
                                        id="quantity"
                                        type="number"
                                        class="mt-1 block w-full"
                                        v-model="form.quantity"
                                        required
                                        min="0"
                                    />
                                    <InputError class="mt-2" :message="form.errors.quantity" />
                                </div>

                                <!-- Unit -->
                                <div>
                                    <InputLabel for="unit" value="Unit" />
                                    <select
                                        id="unit"
                                        v-model="form.unit"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        required
                                    >
                                        <option value="liters">Liters</option>
                                        <option value="kg">Kilograms</option>
                                        <option value="units">Units</option>
                                        <option value="gallons">Gallons</option>
                                    </select>
                                    <InputError class="mt-2" :message="form.errors.unit" />
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-6">
                                <Link
                                    :href="route('chemicals.index')"
                                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    Cancel
                                </Link>

                                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Update Chemical
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
