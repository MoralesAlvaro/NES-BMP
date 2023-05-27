<template>
    <div>
        <Bar :options="chartOptions" :data="chartData" />
    </div>
</template>

<script>
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default {
    name: 'BarChart',
    components: { Bar },
    props: {
        value: {
            type: Array,
            required: true
        },
        chartTitle: {
            type: String,
            default: 'Bar Chart'
        },
        width: {
            type: Number,
            default: 1500
        },
        height: {
            type: Number,
            default: 1500
        },
    },


    data() {
        return {
            chartData: {
                labels: this.value.map(item => item.month),
                datasets: [{
                    label: 'Anual por mes',
                    backgroundColor: '#DB763B',
                    borderColor: '#d1d5db',
                    fill: false,
                    lineTension: 0,
                    data: this.value.map(item => item.totales)
                }]
            },
            chartOptions: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: false,
                },
                scales: {},
                tooltips: {
                    mode: 'label'
                },
                // Agrega las propiedades width y height con valor '100%'
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
                width: '100%',
                height: '100%'
            }

        }
    }
}
</script>
