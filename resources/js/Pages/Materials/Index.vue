<template>
    <layout title="Materials">
        <div class="w-full flex bg-blue-800 p-4">
            <h1 class="text-white text-lg lg:text-xl font-semibold uppercase">Sublimation Printers</h1>
            <icon-base icon-fill="fill-white" icon-name="printer" classes="ml-2">
                <printer />
            </icon-base>
        </div>
        <div class="flex flex-col w-full">
            <printers-table :printers="printers" class="w-full mb-4" />
        </div>
        <div class="w-full flex bg-blue-800 p-4">
            <h1 class="text-white text-lg lg:text-xl font-semibold uppercase">Sublimation Colors</h1>
            <icon-base icon-fill="fill-white" view="32 32" :height="18" :width="18" icon-name="artist" classes="ml-2">
                <artist />
            </icon-base>
        </div>
        <div class="flex flex-col w-full mb-8">
            <colors-table :colors="colors" class="w-full mb-4" />
        </div>
        <div class="w-full flex bg-blue-800 p-4">
            <h1 class="text-white text-lg lg:text-xl font-semibold uppercase">Sublimation Inks</h1>
            <icon-base icon-fill="fill-white" view="20 32" icon-name="ink" classes="ml-2">
                <ink />
            </icon-base>
        </div>
        <div class="flex flex-col w-full">
            <inks-table :inks="inks" class="w-full mb-4" />
        </div>
        <div class="w-full flex bg-blue-800 p-4">
            <h1 class="text-white text-lg lg:text-xl font-semibold uppercase">Sublimation Fabrics</h1>
            <icon-base icon-fill="fill-white" icon-name="shirt" classes="ml-2">
                <shirt />
            </icon-base>
        </div>
        <div class="flex flex-col w-full">
            <fabrics-table :fabrics="fabrics" class="w-full mb-4" />
        </div>
    </layout>
</template>

<script>
import Layout from '@/Shared/Layout';
import Ink from '@/Shared/Icons/Ink';
import IconBase from '@/Shared/IconBase';
import Shirt from '@/Shared/Icons/Shirt';
import Artist from '@/Shared/Icons/Artist';
import Printer from '@/Shared/Icons/Printer';
import InksTable from '@/Partials/Materials/InksTable';
import ColorsTable from '@/Partials/Materials/ColorsTable';
import FabricsTable from '@/Partials/Materials/FabricsTable';
import PrintersTable from '@/Partials/Materials/PrintersTable';

export default {
    components: {
        Ink,
        Shirt,
        Layout,
        Artist,
        Printer,
        IconBase,
        InksTable,
        ColorsTable,
        FabricsTable,
        PrintersTable,
    },
    props: ['colors', 'fabrics', 'printers', 'inks'],
}
</script>
