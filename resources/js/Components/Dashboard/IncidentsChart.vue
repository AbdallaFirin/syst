<script setup>
import { computed } from 'vue';

const props = defineProps({
    data: {
        type: Array,
        default: () => []
    }
});

const maxCount = computed(() => {
    return Math.max(...props.data.map(item => item.count), 0);
});

const getPercentage = (count) => {
    if (maxCount.value === 0) return 0;
    return (count / maxCount.value) * 100;
};
</script>

<template>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Incidents by Category</h3>
        
        <div v-if="data.length === 0" class="text-center text-gray-500 py-8">
            No incident data available.
        </div>
        
        <div v-else class="space-y-4">
            <div v-for="(item, index) in data" :key="index" class="relative">
                <div class="flex justify-between items-center mb-1 text-sm">
                    <span class="font-medium text-gray-700">{{ item.category }}</span>
                    <span class="text-gray-600 font-bold">{{ item.count }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div 
                        class="bg-indigo-600 h-2.5 rounded-full transition-all duration-1000 ease-out"
                        :style="{ width: `${getPercentage(item.count)}%` }"
                    ></div>
                </div>
            </div>
        </div>
    </div>
</template>
