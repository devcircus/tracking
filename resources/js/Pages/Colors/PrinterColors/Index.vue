<template>
    <layout :title="printer.name">
        <div class="w-full flex bg-blue-800 p-4 mb-2">
            <h1 class="text-white text-lg lg:text-xl font-semibold uppercase mr-2">{{ `${printer.name}-${printer.model} Colors` }}</h1>
            <h2 class="text-white text-base lg:text-lg font-semibold uppercase">( {{ printer.ink.type }} )</h2>
            <icon-base icon-fill="fill-white" icon-name="printer" classes="ml-2">
                <printer />
            </icon-base>
        </div>
        <div class="flex flex-col w-full">
            <printer-colors-table :printer="printer" :colors="colors" class="w-full mb-4" />
        </div>
    </layout>
</template>

<script>
import Layout from '@/Shared/Layout';
import IconBase from '@/Shared/IconBase';
import Printer from '@/Shared/Icons/Printer';
import PrinterColorsTable from '@/Partials/Materials/Printers/PrinterColorsTable';

export default {
    components: {
        Layout,
        Printer,
        IconBase,
        PrinterColorsTable,
    },
    props: ['printer', 'colors'],
}
</script>
