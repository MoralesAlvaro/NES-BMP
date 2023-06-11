<script setup>
import AppLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import Table from '@/Components/Table.vue';
import Label from '@/Components/InputLabel.vue';
import Empty from '@/Components/Empty.vue'
import Input from '@/Components/TextInput.vue';
import Button from '@/Components/PrimaryButton.vue';
import * as XLSX from 'xlsx'
import { reactive, ref } from 'vue';


const props = defineProps({
    sales: Object,
    permissions: Array
});

const header = reactive([
    {
        name: "#",
        showInMobile: true
    },
    {
        name: "Fecha",
        showInMobile: true
    },
    {
        name: "Total",
        showInMobile: true
    }
]);

let sale_log = false;
const hasPermission = () => {
    props.permissions.find(item => item.name === 'sale_log') ? sale_log = true : sale_log = false;
}
hasPermission()

const exportData = () => {
  // Crea un nuevo libro de trabajo de Excel
  const workbook = XLSX.utils.book_new();

  // Crea una hoja de trabajo dentro del libro
  const worksheet = XLSX.utils.json_to_sheet(props.sales);

  // Agrega la hoja de trabajo al libro
  XLSX.utils.book_append_sheet(workbook, worksheet, 'log ventas');

  // Genera un archivo de Excel binario a partir del libro de trabajo
  const excelBuffer = XLSX.write(workbook, { bookType: 'xlsx', type: 'array' });

  // Crea un objeto Blob a partir del archivo de Excel binario
  const blob = new Blob([excelBuffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });

  // Crea un enlace temporal para descargar el archivo de Excel
  const url = window.URL.createObjectURL(blob);
  const link = document.createElement('a');
  link.href = url;
  link.setAttribute('download', 'log ventas' + '.xlsx');
  document.body.appendChild(link);

  // Simula el clic en el enlace para descargar el archivo
  link.click();

  // Limpia el enlace y libera los recursos
  document.body.removeChild(link);
  window.URL.revokeObjectURL(url);
};


</script>

<template>
    <Head title="Bitácora" />
    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-700 leading-tight sm:text-end md:text-start text-start">
                Bitácora de Ventas
            </h2>
        </template>
        <div class="py-6 min-h-screen">
            <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 pb-8">
                <div class="p-5">
                    <Button @click="exportData()" class=""><i class="fa fa-solid fa-file-excel text-green-500 font-bold text-lg"></i> Exportar</Button>
                </div>
                <div
                    class="bg-white w-full sm:overflow-x-hidden overflow-x-auto shadow-xl rounded-lg min-h-base border border-gray-50 animated fadeIn">
                    <div v-if="sales.length">
                        <Table :header="header" :items="sales.length">
                            <tbody class="px-5">
                                <tr v-for=" (item, index) in sales " class="mt-2 hover:bg-gray-50">
                                    <td class="text-center p-2 lg:text-base text-xs text-gray-400">{{ index + 1 }}</td>
                                    <td class="text-center p-2 lg:text-base text-xs">{{ item.fecha }}</td>
                                    <td class="text-center p-2 lg:text-base text-xs">${{ item.total_suma.toFixed(2) }}</td>
                                </tr>
                            </tbody>
                        </Table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
