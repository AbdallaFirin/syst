<script setup>
import { computed } from 'vue';
import {
  Chart as ChartJS,
  ArcElement,
  Tooltip,
  Legend,
  CategoryScale,
  LinearScale,
  BarElement,
  Title
} from 'chart.js';
import { Pie, Bar } from 'vue-chartjs';

ChartJS.register(
  ArcElement, 
  Tooltip, 
  Legend, 
  CategoryScale, 
  LinearScale, 
  BarElement, 
  Title
);

const props = defineProps({
  charts: {
    type: Object,
    required: true
  }
});

// 1. Incidents by Cause (Pie Chart)
const pieData = computed(() => {
  const data = props.charts.by_cause || [];
  return {
    labels: data.map(item => item.cause),
    datasets: [
      {
        backgroundColor: ['#ef4444', '#f97316', '#eab308', '#22c55e', '#3b82f6', '#8b5cf6', '#ec4899'],
        data: data.map(item => item.count)
      }
    ]
  };
});

const pieOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      position: 'right',
    },
    title: {
      display: true,
      text: 'Incidents by Cause'
    }
  }
};

// 2. Monthly Trends (Bar Chart)
const barData = computed(() => {
  const data = props.charts.monthly_trends || [];
  return {
    labels: data.map(item => item.month),
    datasets: [
      {
        label: 'Financial Loss ($)',
        backgroundColor: '#ef4444',
        data: data.map(item => item.loss),
        yAxisID: 'y',
      },
      {
        label: 'Incident Count',
        backgroundColor: '#3b82f6',
        data: data.map(item => item.count),
        yAxisID: 'y1',
      }
    ]
  };
});

const barOptions = {
  responsive: true,
  maintainAspectRatio: false,
  interaction: {
    mode: 'index',
    intersect: false,
  },
  plugins: {
    title: {
      display: true,
      text: 'Monthly Trends & Financial Loss'
    }
  },
  scales: {
    y: {
      type: 'linear',
      display: true,
      position: 'left',
      title: { display: true, text: 'Financial Loss ($)' }
    },
    y1: {
      type: 'linear',
      display: true,
      position: 'right',
      grid: {
        drawOnChartArea: false,
      },
      title: { display: true, text: 'Number of Incidents' }
    },
  }
};
</script>

<template>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 print:break-inside-avoid">
    <!-- Pie Chart -->
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 h-80">
      <Pie :data="pieData" :options="pieOptions" />
    </div>

    <!-- Bar Chart -->
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 h-80">
      <Bar :data="barData" :options="barOptions" />
    </div>
  </div>
</template>
