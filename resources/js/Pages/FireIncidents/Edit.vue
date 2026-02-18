<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    incident: Object,
    places: Array,
    causes: Array,
});

const maxDate = computed(() => {
    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    return now.toISOString().slice(0, 16);
});

const deathEvidence = computed(() => props.incident.images?.filter(img => img.category === 'death_evidence') || []);
const injuryEvidence = computed(() => props.incident.images?.filter(img => img.category === 'injury_evidence') || []);

const form = useForm({
    place_id: props.incident.place_id,
    incident_cause_id: props.incident.incident_cause_id,
    incident_date: props.incident.incident_date, // Needs proper formatting for datetime-local input?
    human_loss: props.incident.human_loss,
    injured_people: props.incident.injured_people,
    financial_loss: props.incident.financial_loss,
    property_damage: props.incident.property_damage,
    rescued_people: props.incident.rescued_people,
    rescued_assets: props.incident.rescued_assets,
    additional_notes: props.incident.additional_notes,
    status: props.incident.status || 'pending',
    death_evidence: [],
    injury_evidence: [],
});

const imageForm = useForm({
    image: null,
    caption: ''
});

const uploadMessage = ref('');

const handleFileChange = (e) => {
    imageForm.image = e.target.files[0];
};

const uploadPhoto = () => {
    imageForm.post(route('fire-incidents.upload-image', props.incident.id), {
        onSuccess: () => {
            imageForm.reset();
            uploadMessage.value = 'Photo uploaded!';
            setTimeout(() => uploadMessage.value = '', 3000);
            // Optionally reload to see new image if not auto-injected by Props update
            // Inertia usually handles prop updates automatically on success
        }
    });
};

const deletePhoto = (id) => {
    if(confirm('Delete this photo?')) {
        router.delete(route('incident-images.destroy', id));
    }
};

const submit = () => {
    form.put(route('fire-incidents.update', props.incident.id));
};
</script>

<template>

    <Head title="Edit Incident Report" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Incident Report</h2>
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
                                    <select id="place_id" v-model="form.place_id"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        required>
                                        <option value="" disabled>Select Place</option>
                                        <option v-for="place in places" :key="place.id" :value="place.id">
                                            {{ place.name }} ({{ place.location }})
                                        </option>
                                    </select>
                                    <InputError class="mt-2" :message="form.errors.place_id" />
                                </div>

                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel for="incident_date" value="Date & Time of Incident" />
                                    <!-- Note: datetime-local expects YYYY-MM-DDTHH:MM format. 
                                         Laravel default cast is often full string. Might need formatting. 
                                         For this task, assuming the model casts 'datetime' or user picks new date. -->
                                    <TextInput id="incident_date" type="datetime-local" class="mt-1 block w-full"
                                        v-model="form.incident_date" :max="maxDate" required />
                                    <InputError class="mt-2" :message="form.errors.incident_date" />
                                </div>

                                <div class="col-span-2">
                                    <InputLabel for="incident_cause_id" value="Cause of Incident" />
                                    <select id="incident_cause_id" v-model="form.incident_cause_id"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        required>
                                        <option value="" disabled>Select Cause</option>
                                        <option v-for="cause in causes" :key="cause.id" :value="cause.id">
                                            {{ cause.name }}
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
                                    <!-- Display Existing Death Evidence -->
                                    <div v-if="deathEvidence.length > 0" class="mt-2 p-2 bg-gray-50 rounded border">
                                        <p class="text-xs font-bold text-gray-500 mb-1">Attached Evidence:</p>
                                        <div v-for="img in deathEvidence" :key="img.id" class="flex items-center justify-between text-xs">
                                            <a :href="'/storage/' + img.image_path" target="_blank" class="text-blue-600 hover:underline flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                View Document/Photo
                                            </a>
                                        </div>
                                    </div>
                                    <!-- Add New Death Evidence -->
                                    <div class="mt-2">
                                        <InputLabel value="Add New Death Evidence" class="text-xs text-gray-500" />
                                        <input type="file" multiple @change="e => form.death_evidence = Array.from(e.target.files)"
                                            class="mt-1 block w-full text-xs text-slate-500
                                            file:mr-4 file:py-1 file:px-2
                                            file:rounded-full file:border-0
                                            file:text-xs file:font-semibold
                                            file:bg-red-50 file:text-red-700
                                            hover:file:bg-red-100" />
                                        <InputError :message="form.errors.death_evidence" class="mt-1" />
                                    </div>
                                </div>

                                <div>
                                    <InputLabel for="injured_people" value="Injured Persons" />
                                    <TextInput id="injured_people" type="number" class="mt-1 block w-full"
                                        v-model="form.injured_people" required min="0" />
                                    <InputError class="mt-2" :message="form.errors.injured_people" />
                                    <!-- Display Existing Injury Evidence -->
                                    <div v-if="injuryEvidence.length > 0" class="mt-2 p-2 bg-gray-50 rounded border">
                                        <p class="text-xs font-bold text-gray-500 mb-1">Attached Evidence:</p>
                                        <div v-for="img in injuryEvidence" :key="img.id" class="flex items-center justify-between text-xs">
                                            <a :href="'/storage/' + img.image_path" target="_blank" class="text-blue-600 hover:underline flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                View Document/Photo
                                            </a>
                                        </div>
                                    </div>
                                    <!-- Add New Injury Evidence -->
                                    <div class="mt-2">
                                        <InputLabel value="Add New Injury Evidence" class="text-xs text-gray-500" />
                                        <input type="file" multiple @change="e => form.injury_evidence = Array.from(e.target.files)"
                                            class="mt-1 block w-full text-xs text-slate-500
                                            file:mr-4 file:py-1 file:px-2
                                            file:rounded-full file:border-0
                                            file:text-xs file:font-semibold
                                            file:bg-orange-50 file:text-orange-700
                                            hover:file:bg-orange-100" />
                                        <InputError :message="form.errors.injury_evidence" class="mt-1" />
                                    </div>
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





                            </div>

                            <div class="flex items-center justify-between mt-8 border-t pt-6">
                                <a :href="route('fire-incidents.case-file', incident.id)" target="_blank"
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Print Case File
                                </a>

                                <div class="flex items-center">
                                    <Link :href="route('fire-incidents.index')"
                                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Cancel
                                    </Link>

                                    <PrimaryButton class="ms-4 bg-red-600 hover:bg-red-500"
                                        :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        Update Report
                                    </PrimaryButton>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
