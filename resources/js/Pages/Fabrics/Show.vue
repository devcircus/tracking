<template>
    <layout :title="`Fabric - ${fabric.name}`">
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-blue-300 hover:text-blue-700" :href="route('materials.list')">Materials</inertia-link>
            <span class="text-blue-300 font-medium">/</span>
            <span class="text-blue-700">{{ fabric.name }}</span>
        </h1>
        <div class="w-full md:w-2/5 flex bg-blue-800 p-4 mb-2">
            <h1 class="text-white text-lg lg:text-xl font-semibold uppercase">{{ fabric.name }}</h1>
            <icon-base icon-fill="fill-white" icon-name="shirt" classes="ml-2">
                <shirt />
            </icon-base>
        </div>
        <div class="flex flex-col p-2 mb-2">
            <div class="flex mb-2">
                <span class="text-gray-800 font-black uppercase mr-2 w-160p">Fabric Name: </span>
                <span class="text-gray-700 font-bold uppercase">{{ fabric.name }}</span>
            </div>
            <div class="flex mb-2">
                <span class="text-gray-800 font-black uppercase mr-2 w-160p">Code: </span>
                <span class="text-gray-700 font-bold uppercase">{{ fabric.code }}</span>
            </div>
            <div class="flex mb-2">
                <span class="text-gray-800 font-black uppercase mr-2 w-160p">Cross-grain: </span>
                <span class="text-gray-700 font-bold uppercase">{{ fabric.cross_grain ? 'yes' : 'no' }}</span>
            </div>
            <div class="flex mb-2">
                <span class="text-gray-800 font-black uppercase mr-2 w-160p">Press Speed: </span>
                <span class="text-gray-700 font-bold uppercase">{{ fabric.press_speed }}</span>
            </div>
        </div>
    </layout>
</template>

<script>
import Layout from '@/Shared/Layout';
import IconBase from '@/Shared/IconBase';
import Shirt from '@/Shared/Icons/Shirt';

export default {
    components: {
        Layout,
        Shirt,
        IconBase,
    },
    props: ['fabric'],
}
</script>
