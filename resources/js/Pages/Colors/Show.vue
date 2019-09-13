<template>
    <layout :title="`Color - ${color.name}`">
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-blue-300 hover:text-blue-700" :href="route('materials.list')">Materials</inertia-link>
            <span class="text-blue-300 font-medium">/</span>
            <span class="text-blue-700">{{ color.name }}</span>
        </h1>
        <div class="w-full md:w-2/5 flex bg-blue-800 p-4 mb-2">
            <h1 class="text-white text-lg lg:text-xl font-semibold uppercase">{{ color.name }}</h1>
            <icon-base icon-fill="fill-white" view="32 32" :height="18" :width="18" icon-name="artist" classes="ml-2">
                <artist />
            </icon-base>
        </div>
        <div class="flex flex-col p-2 mb-2">
            <div class="flex mb-2">
                <span class="text-gray-800 font-black uppercase mr-2 w-160p">Color Name: </span>
                <span class="text-gray-700 font-bold uppercase">{{ color.name }}</span>
            </div>
            <div class="flex mb-2">
                <span class="text-gray-800 font-black uppercase mr-2 w-160p">Code: </span>
                <span class="text-gray-700 font-bold uppercase">{{ color.code }}</span>
            </div>
            <div class="flex mb-2">
                <span class="text-gray-800 font-black uppercase mr-2 w-160p">Type: </span>
                <span class="text-gray-700 font-bold uppercase">{{ color.type }}</span>
            </div>
        </div>
        <div class="w-full md:w-2/5 flex bg-blue-500 px-4 py-2 mb-2">
            <h1 class="text-white text-base lg:text-sm font-semibold uppercase">Printers</h1>
            <icon-base icon-fill="fill-white" :height="14" :width="14" icon-name="printer" classes="ml-2">
                <printer />
            </icon-base>
        </div>
        <div class="w-full md:w-2/5 flex flex-col">
            <div v-for="printer in color.printers" :key="printer.id" class="flex-col mb-2 bg-gray-300 p-2">
                <div class="flex mb-2">
                    <inertia-link :href="route('printers.show', printer.id)" class="text-gray-800 font-black uppercase mr-2 w-100p">{{ printer.name }}</inertia-link>
                    <span class="text-gray-700 text-sm font-bold uppercase mr-2" :class="printer.pivot.approved ? 'text-green-500' : 'text-red-500'">( {{ printer.pivot.approved ? 'approved' : 'not approved' }} )</span>
                </div>
                <div class="flex">
                    <span class="text-gray-800 font-bold uppercase mr-2 mb-2 w-100p">CMYK: </span>
                    <span class="text-gray-700 font-bold uppercase">{{ getColorValues(printer.pivot) }}</span>
                </div>
            </div>
        </div>
    </layout>
</template>

<script>
import Layout from '@/Shared/Layout';
import IconBase from '@/Shared/IconBase';
import Artist from '@/Shared/Icons/Artist';
import Printer from '@/Shared/Icons/Printer';

export default {
    components: {
        Layout,
        Artist,
        Printer,
        IconBase,
    },
    props: ['color'],
    methods: {
        getColorValues (colors) {
            return `
                ${colors.cyan}-${colors.magenta}-${colors.yellow}-${colors.black}
            `
        },
    },
}
</script>
