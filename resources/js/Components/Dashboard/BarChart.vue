<script setup>
import { Bar } from 'vue-chartjs';
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
} from 'chart.js';
import { computed, ref } from 'vue';
import _ from 'lodash';
import moment from 'moment';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

const props = defineProps({
    value: {
        type: Array,
        default: () => []
    },
    chartId: {
        type: String,
        default: 'bar-chart'
    },
    width: {
        type: Number,
        default: 500
    },
    height: {
        type: Number,
        default: 400
    },
    cssClasses: {
        default: '',
        type: String
    },
    styles: {
        type: Object,
        default: () => { }
    },
    plugins: {
        type: Array,
        default: () => []
    },
    datasetIdKey: {
        type: String,
        default: 'label'
    },
});

const months = ref([
    {
        name: 'Enero',
        id: 1,
        sums: 0,
        year: moment().format('YYYY')
    },
    {
        name: 'Febrero',
        id: 2,
        sums: 0,
        year: moment().format('YYYY')
    },
    {
        name: 'Marzo',
        id: 3,
        sums: 0,
        year: moment().format('YYYY')
    },
    {
        name: 'Abril',
        id: 4,
        sums: 0,
        year: moment().format('YYYY')
    },
    {
        name: 'Mayo',
        id: 5,
        sums: 0,
        year: moment().format('YYYY')
    },
    {
        name: 'Junio',
        id: 6,
        sums: 0,
        year: moment().format('YYYY')
    },
    {
        name: 'Julio',
        id: 7,
        sums: 0,
        year: moment().format('YYYY')
    },
    {
        name: 'Agosto',
        id: 8,
        sums: 0,
        year: moment().format('YYYY')
    },
    {
        name: 'Septiembre',
        id: 9,
        sums: 0,
        year: moment().format('YYYY')
    },
    {
        name: 'Octubre',
        id: 10,
        sums: 0,
        year: moment().format('YYYY')
    },
    {
        name: 'Noviembre',
        id: 11,
        sums: 0,
        year: moment().format('YYYY')
    },
    {
        name: 'Diciembre',
        id: 12,
        sums: 0,
        year: moment().format('YYYY')
    }
]);
const filteredDate = computed(() => {
    const values = _(props.value)
        .groupBy('month')
        .map((item, index) => ({
            id: Number(item[0].month),
            year: item[0].year,
            sums: _.sumBy(item, 'sums')
        }))
        .value();

    return _(months.value)
        .keyBy('id')
        .merge(_.keyBy(values, 'id'))
        .values()
        .value();
})

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false
}
const chartData = {
    labels: filteredDate.value.map(item => `${item.name} - ${item.year}`),
    datasets: [
        {
            label: 'Venta Mensual',
            backgroundColor: '#404E67',
            data: filteredDate.value.map(item => item.sums)
        }
    ]
}
</script>

<template>
    <Bar class="w-full" :chart-options="chartOptions" :chart-data="chartData" :chart-id="chartId" :plugins="plugins"
        :css-classes="cssClasses" :styles="styles" :width="width" :height="height" />
</template>