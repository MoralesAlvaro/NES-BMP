<script setup>
import Button from '@/Components/PrimaryButton.vue';
import ButtonSecundary from '@/Components/SecondaryButton.vue';
import Input from '@/Components/TextInput.vue';
import Table from '@/Components/Table.vue'
import Textarea from '@/Components/TexTareaInput.vue';
import Label from '@/Components/InputLabel.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { reactive, ref, getCurrentInstance } from 'vue';
import InputError from '@/Components/InputError.vue';
import { createToaster } from "@meforma/vue-toaster";
import pdfMake from 'pdfmake/build/pdfmake';
import pdfFonts from 'pdfmake/build/vfs_fonts';

  // Cargar las fuentes necesarias para el PDF
  pdfMake.vfs = pdfFonts.pdfMake.vfs;

const emit = defineEmits(['close']);
const props = defineProps({
    isEdit: {
        type: Boolean
    },
    sale: {
        type: Object
    },
    stocks: {
        type: Object
    },
    typeProduct: {
        type: Object
    },
    success: String,
});

const toaster = createToaster({ /* options */ });
const isLoading = ref(false);

let costo = reactive({ value: 0 });
let exist = reactive({ value: 0 });
let detailSaleEmpty = reactive({ value: false });

const form = useForm({
    sale_id: props.isEdit && props.sale.id || '',
    status_sale_id: props.isEdit && props.sale.status_sale_id || false,
    sup_total: props.isEdit && props.sale.sup_total || 0.00,
    discount: props.isEdit && props.sale.discount || 0.00,
    total: props.isEdit && props.sale.total || 0.00,
    detail_sale: props.isEdit && props.sale.detailSale || [], // array de detalle de venta
    // detail_ sale
    orders: '1',
    discount_sale: '0',
});

// Seleccionando Stock
const selectedStock = ref({});
const handleSelectedStock = (selected) => {
    selectedStock.value = { ...selected };
    form.stock_id = selectedStock.value.id;
    exist.value = selectedStock.value.raw_material.parts;
    costStock();
}

// Seleccionando typeProduct
const selectedTypeProduct = ref({});
const handleSelectedTypeProduct = (selected) => {
    selectedTypeProduct.value = { ...selected };
    form.type_product_id = selectedTypeProduct.value.id;
    // console.log(selectedTypeProduct.value.id);
    costStock();
}

// Calcula el costo de las ordenes a pedir
const costStock = () => {
    selectedStock.value.mount ? costo.value = selectedStock.value.mount : costo.value = 0;
    let totalAdd = 0
    let totalProduct = 0

    if (selectedTypeProduct.value.cost != null && selectedStock.value.mount) {
        if (selectedTypeProduct.value.cost > 0.00) {
            totalAdd = selectedTypeProduct.value.cost * form.orders
            totalProduct = selectedStock.value.mount * form.orders
        } else {
            totalProduct = selectedStock.value.mount * form.orders
        }
    }

    // selectedTypeProduct.value.cost ? costo.value = selectedTypeProduct.value.cost : costo.value = 0;
    // selectedTypeProduct.value.cost && selectedStock.value.mount ? costo.value = selectedTypeProduct.value.cost + selectedStock.value.mount : 0;
    costo.value = totalAdd + totalProduct;
    totalSale()
}

// Calcula el costo total, descuento total y suptotales de la venta
const totalSale = () => {
    form.total = 0;
    form.sup_total = 0;
    form.discount = 0;
    if (form.detail_sale) {

        form.detail_sale.forEach(element => {
            if (element.kind !== 'delete') {
                // Si tiene el valor de delete, significa que será sacado del detalle de venta
                form.total += element.total;
                form.sup_total += element.total;
                form.discount += element.discount;
            }
        });
        form.total = form.total - form.discount;
    }
}

const validateNegatives = () => {
    if (form.discount_sale < 0) {
        form.discount_sale = 0;
        toaster.info("No puedes asignar descuentos negativos");
    }
    if (form.orders < 0 || form.orders < 1) {
        form.orders = 1;
        toaster.info("No puedes agregar ordenes negativas");
    }
    if (form.discount_sale === "") {
        form.discount_sale = 0;
    }
}

// Hace el caculo de las partes disponibles en stock
const dischargetParts = (stock_id) => {
    exist.value -= form.orders;
    let stock = props.stocks.data.filter(item => item.id === stock_id)
    stock[0].raw_material.parts = exist.value;
}

// Agregar los elementos de detalle de venta a un array que luego sera recorrido en ele controlador para hacer el registro
const addStockArray = () => {
    if (selectedStock.value.id && selectedTypeProduct.value.id) {
        validateNegatives();
        let stock = props.stocks.data.filter(item => item.id === selectedStock.value.id)
        let parts = stock[0].raw_material.parts - form.orders;
        if (parts < 0) {
            toaster.warning(`No puedes agregar más de ${stock[0].raw_material.parts} ordenes`);
        } else {
            form.detail_sale.push({
                id: '',
                sale_id: form.sale_id,
                stock_id: selectedStock.value.id,
                stock_name: selectedStock.value,
                type_product_id: selectedTypeProduct.value.id,
                type_product_name: selectedTypeProduct.value.name,
                discount: parseInt(form.discount_sale),
                total: costo.value,
                orders: form.orders,
                kind: 'new',
            });
            toaster.success(`${form.orders} Ordenes agregadas`);
            form.discount_sale = '0';
            // Siempre que se agrege un nuevo elemento, la bandera pasa a false
            totalSale();
            dischargetParts(selectedStock.value.id);
            detailSaleEmpty.value = false;
        }


    } else {
        toaster.warning(`Selecciona el producto y su tipo`);
    }
}

const submit = () => {
    isLoading.value = true;
    if (form.detail_sale.length) {
        if (detailSaleEmpty.value === false) {
            if (props.isEdit) {
                form.post(route('sale.update'), {
                    onSuccess: () => {
                        emit('close');
                        toaster.success(`Registro actualizado correctamente.`);
                    },
                    onError: () => {
                        const errors = usePage().props.errors;
                        for (const key in errors) {
                            if (Object.hasOwnProperty.call(errors, key)) {
                                toaster.warning(`${errors[key]}`);
                            }
                        }
                    },
                    onFinish: () => {
                        isLoading.value = false
                    }
                })
            } else {
                form.post(route('sale.store'), {
                    onSuccess: () => {
                        emit('close');
                        toaster.success(`Registro creado correctamente.`);
                    },
                    onError: () => {
                        const errors = usePage().props.errors;
                        for (const key in errors) {
                            if (Object.hasOwnProperty.call(errors, key)) {
                                toaster.warning(`${errors[key]}`);
                            }
                        }
                    },
                    onFinish: () => {
                        isLoading.value = false
                    }
                })
            }
        } else {
            toaster.warning(`Por favor agrega los productos de la venta`);
        }
    } else {
        toaster.warning(`Por favor agrega los productos de la venta`);
    }
}

const headerPreview = reactive([
    {
        name: '#',
        showInMobile: true
    },
    {
        name: 'Producto',
        showInMobile: true
    },
    {
        name: 'Precio',
        showInMobile: true
    },
    {
        name: 'Descuento',
        showInMobile: true
    },
    {
        name: 'Tipo producto',
        showInMobile: true
    },
    {
        name: 'Total órdenes',
        showInMobile: true
    },
    {
        name: 'Acciones',
        showInMobile: true
    }
]);

const formDelete = useForm({
    id: null
});

const deleteItem = (item) => {

    if (form.detail_sale[item].kind === 'old') {
        form.detail_sale[item].kind = 'delete';
        totalSale();
        // console.log(form.detail_sale[item].kind);
        toaster.info(`El detalle de venta será eliminado de la venta hasta que de click en el botón "Editar"`);
    } else if (form.detail_sale[item].kind === 'delete') {
        form.detail_sale[item].kind = 'old';
        totalSale();
        // console.log(form.detail_sale[item].kind);
        toaster.info(`El detalle de venta se ha activado nuevamente"`);
    }

    if (form.detail_sale[item].kind === 'new') {
        exist.value += parseInt(form.detail_sale[item].orders);
        form.detail_sale.splice(item, 1);
        totalSale();
        toaster.warning(`Se ha removido un item de la venta`);
    }
    totalSale();
}

const showTicket = () => {
  if (form.status_sale_id) {
    pdfMake.vfs = pdfFonts.pdfMake.vfs;
    const ticketWidthPx = 300;
    const ticketHeightPt = 'auto';

    const { sale_id, status_sale_id, sup_total, discount, total, detail_sale } = form;

    const groupedItems = detail_sale.reduce((groups, item) => {
        const { stock_name } = item;
        const itemId = stock_name.id;

        groups[itemId] = groups[itemId] || { stock_name, quantity: 0, total: 0 };
        groups[itemId].quantity += parseInt(item.orders);
        groups[itemId].total += parseInt(item.total.toFixed(2));

        return groups;
    }, {});

    const groupedItemsArray = Object.values(groupedItems);

    const documentDefinition = {
        pageSize: { width: ticketWidthPx, height: ticketHeightPt },
        content: [
        { text: 'RESTAURANTE NOCHES DE EL SALVADOR', style: 'header' },
        { text: '----------------------------', alignment: 'center' },
        { text: 'Ticket de Venta', style: 'subheader' },
        { text: `Subtotal: $${sup_total.toFixed(2)}` },
        { text: `Descuento: $${discount.toFixed(2)}` },
        { text: `Total: $${total.toFixed(2)}`, style: 'total' },
        { text: 'Detalle de Venta:', style: 'subheader' },
        {
            table: {
                headerRows: 1,
                widths: ['*', 'auto', 'auto'],
                body: [
                    ['Nombre', 'Cantidad', 'Total'],
                    ...detail_sale.map(item => [item.stock_name.name, item.orders, `$${item.total.toFixed(2)}`])
                ],
                footer: [{ text: `Total: $${total.toFixed(2)}`, style: 'total', colSpan: 2, alignment: 'right' }, {}, {}],
                autoSize: true
            },
            layout: {
                fillColor: (rowIndex, node, columnIndex) => rowIndex === 0 ? '#CCCCCC' : null,
                hLineWidth: (i, node) => i === 0 || i === node.table.body.length ? 0 : 0.5,
                vLineWidth: () => 0,
            },
            style: 'tableStyle'
        }
        ],
        styles: {
        header: { fontSize: 12, bold: true, margin: [0, 0, 0, 10], alignment: 'center' },
        subheader: { fontSize: 14, bold: true, margin: [0, 10, 0, 5] },
        total: { fontSize: 14, bold: true, margin: [0, 10, 0, 0] },
        tableStyle: { margin: [0, 10, 0, 10] }
        }
    };

    pdfMake.createPdf(documentDefinition).open();
  }
};



</script>

<template>
    <form class="py-8 px-5 bg-gray-50" @submit.prevent="submit">
        <h2 class="font-semibold text-2xl text-dark-blue-500 leading-tight text-center mb-5">
            {{ isEdit ? 'Editar Venta' : 'Registrar Venta' }}
        </h2>
        <!-- Resumen de venta -->
        <div class="grid grid-cols-3 gap-4 shadow-md p-4 bg-white rounded-md">

            <div class="md:w-auto w-full md:order-last mb-2 md:mb-0">
                <h6 class="text-brown-900 ">
                    Subtotal ${{ form.sup_total.toFixed(2) }}
                </h6>
            </div>

            <div class="md:w-auto w-full md:order-last mb-2 md:mb-0">
                <h6 class="text-brown-900 ">
                    Descuentos ${{ form.discount }}
                </h6>
            </div>

            <div class="md:w-auto w-full md:order-last mb-2 md:mb-0">
                <h6 class="text-brown-900 font-semibold text-base md:text-xl text-end">
                    Total ${{ form.total.toFixed(2) }}
                </h6>
            </div>
        </div>
        <!-- Seleccionar producto -->
        <div class="grid md:grid-cols-12 gap-4 shadow-md p-4 mt-4 bg-white rounded-md">

            <div class="mb-8 md:col-span-4 col-span-2">
                <Label for="rol" value="Producto" />
                <v-select :options="stocks.data.length ? stocks.data : []" :reduce="(option) => option.id" label="name"
                    placeholder="Seleccionar" class="appearance-none capitalize" @option:selected="handleSelectedStock">
                    <template #open-indicator="{ attributes }">
                        <svg v-bind="attributes" width="10" height="7" viewBox="0 0 10 7" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.95 6.3L0 1.3L1.283 0L4.95 3.706L8.617 0L9.9 1.3L4.95 6.3Z" fill="#A4AFB7" />
                        </svg>
                    </template>
                    <template #option="{ name }">
                        <span class="capitalize">{{ name }}</span>
                    </template>
                </v-select>
                <InputError class="mt-2" :message="form.errors.active" />
            </div>

            <div class="mb-8 md:col-span-4 col-span-2">
                <Label for="rol" value="Tipo producto" />
                <v-select :options="typeProduct.length ? typeProduct : []" :reduce="(option) => option.id" label="name"
                    placeholder="Seleccionar" class="appearance-none capitalize"
                    @option:selected="handleSelectedTypeProduct">
                    <template #open-indicator="{ attributes }">
                        <svg v-bind="attributes" width="10" height="7" viewBox="0 0 10 7" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.95 6.3L0 1.3L1.283 0L4.95 3.706L8.617 0L9.9 1.3L4.95 6.3Z" fill="#A4AFB7" />
                        </svg>
                    </template>
                    <template #option="{ name }">
                        <span class="capitalize">{{ name }}</span>
                    </template>
                </v-select>
                <InputError class="mt-2" :message="form.errors.active" />
            </div>

            <div class="col-span-2">
                <Label for="orders" value="N° Ordenes" />
                <Input id="orders" v-model="form.orders" @change="costStock" @click="validateNegatives()" type="number"
                    class="mt-1 block w-full" required placeholder="0" min="1" />
                <InputError class="mt-2" :message="form.errors.orders" />
            </div>

            <div class="md:w-auto w-full  mb-2 md:mb-0 md:col-span-2 col-span-3 sm:order-first md:order-none">
                <h6 class="text-brown-900 font-semibold text-base md:text-xl text-end">
                    Costo ${{ costo.value.toFixed(2) }}
                </h6>
            </div>

            <div class="col-span-2">
                <Label for="orders" class="text-gray-500" value="Existencias" />
                <span class=" text-gray-500">{{ exist.value }}</span>
            </div>

            <div class="col-span-3">
                <Label for="discount_sale" value="Descuentos" />
                <Input id="discount_sale" v-model="form.discount_sale" @click="validateNegatives()" type="number" min="0"
                    class="mt-1 block w-full" required placeholder="0" />
            </div>

            <div class="md:w-auto w-full mb-2 md:mb-0 md:col-span-3 pt-6 ">
                <Button @click="addStockArray()" type="button">
                    Agregar
                </Button>
            </div>

            <div class="md:w-auto w-full mb-2 md:mb-0 md:col-span-3 pt-6 ">
                <ButtonSecundary @click="showTicket()" type="submit">
                    {{ isEdit ? 'Editar' : 'Ordenar' }}
                </ButtonSecundary>
            </div>

            <div class="md:w-auto w-full mb-2 md:mb-0 pt-2 ">
                <Label class="pb-2" for="discount_sale" value="Pagado" />
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" v-model="form.status_sale_id" class="sr-only peer">
                    <div
                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                    </div>
                </label>
            </div>

        </div>

        <h2 class="font-semibold pt-5 text-lg text-dark-blue-500 leading-tight text-center mb-5">
            Detalle de la orden
        </h2>
        <!-- Detalle de la orden  -->
        <div class="grid shadow-md p-4 mt-4 bg-white rounded-md overflow-auto">
            <div v-if="headerPreview.length">
                <Table :header="headerPreview" :items="headerPreview.length" class="  h-52">
                    <tbody class="px-5">
                        <tr v-for=" (item, index) in form.detail_sale " class="mt-2">
                            <td :class="{ 'line-through text-gray-300': item.kind === 'delete' }"
                                class="text-center p-2 lg:text-base text-xs text-gray-400">{{ index + 1 }}</td>
                            <td :class="{ 'line-through text-gray-300': item.kind === 'delete' }"
                                class="text-center p-2 lg:text-base text-xs">{{ item.stock_name.name }}</td>
                            <td :class="{ 'line-through text-gray-300': item.kind === 'delete' }"
                                class="text-center p-2 lg:text-base text-xs">${{ item.total }}</td>
                            <td :class="{ 'line-through text-gray-300': item.kind === 'delete' }"
                                class="text-center p-2 lg:text-base text-xs">${{ item.discount }}</td>
                            <td :class="{ 'line-through text-gray-300': item.kind === 'delete' }"
                                class="text-center p-2 lg:text-base text-xs">{{ item.type_product_name }}</td>
                            <td :class="{ 'line-through text-gray-300': item.kind === 'delete' }"
                                class="text-center p-2 lg:text-base text-xs">{{ item.orders }}</td>
                            <td class="text-center p-2 lg:text-base text-xs">
                                <div class="flex justify-center">
                                    <div class="flex flex-row space-x-4">
                                        <a @click="deleteItem(index)"
                                            :class="{ 'line-none text-red-500': item.kind !== 'delete', 'line-none': item.kind === 'delete' }"
                                            class="text-blue-500 font-medium cursor-pointer">{{ item.kind === 'delete' ?
                                                'Activar' : 'Eliminar' }}</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </Table>
            </div>

        </div>
    </form>
</template>
