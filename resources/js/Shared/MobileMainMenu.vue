<template>
    <div :class="display">
        <inertia-link class="flex items-center group py-3 px-8 hover:bg-blue-500" :href="route('dashboard')">
            <icon-base view="24 24" :width="20" :height="20" :dynamic-classes="isPath('dashboard') ? 'fill-blue-500 group-hover:fill-white' : 'fill-blue-800 group-hover:fill-white'" icon-name="dashboard" classes="mt-1 mr-2">
                <dashboard />
            </icon-base>
            <div :class="isPath('dashboard') ? 'text-blue-500 group-hover:text-white' : 'text-blue-800 group-hover:text-white'" class="text-lg lg:text-xl">Dashboard</div>
        </inertia-link>
        <inertia-link class="flex items-center group py-3 px-8 hover:bg-blue-500" :href="route('inventory')">
            <icon-base :dynamic-classes="isPath('inventory') ? 'fill-blue-500 group-hover:fill-white' : 'fill-blue-800 group-hover:fill-white'" icon-name="book" classes="mt-1 mr-2">
                <book />
            </icon-base>
            <div :class="isPath('inventory') ? 'text-blue-500 group-hover:text-white' : 'text-blue-800 group-hover:text-white'" class="text-lg lg:text-xl">Inventory</div>
        </inertia-link>
        <inertia-link class="flex items-center group py-3 px-8 hover:bg-blue-500" :href="route('reports.list')">
            <icon-base :dynamic-classes="isPath('reports') ? 'fill-blue-500 group-hover:fill-white' : 'fill-blue-800 group-hover:fill-white'" icon-name="inbox-full" classes="mt-1 mr-2">
                <inbox-full />
            </icon-base>
            <div :class="isPath('reports') ? 'text-blue-500 group-hover:text-white' : 'text-blue-800 group-hover:text-white'" class="text-lg lg:text-xl">Reports</div>
        </inertia-link>
        <inertia-link v-if="$page.auth.user.is_admin || $page.auth.user.is_artist" class="flex items-center group py-3 px-8 hover:bg-blue-500" :href="route('artwork.list')">
            <icon-base :dynamic-classes="isPath('artwork') ? 'fill-blue-500 group-hover:fill-white' : 'fill-blue-800 group-hover:fill-white'" icon-name="pen-tool" classes="mt-1 mr-2">
                <pen-tool />
            </icon-base>
            <div :class="isPath('artwork') ? 'text-blue-500 group-hover:text-white' : 'text-blue-800 group-hover:text-white'" class="text-lg lg:text-xl">Artwork</div>
        </inertia-link>
        <inertia-link class="flex items-center group py-3 px-8 hover:bg-blue-500" :href="route('materials.list')">
            <icon-base :dynamic-classes="isPath('materials') ? 'fill-blue-500 group-hover:fill-white' : 'fill-blue-800 group-hover:fill-white'" icon-name="printer" classes="mt-1 mr-2">
                <printer />
            </icon-base>
            <div :class="isPath('materials') ? 'text-blue-500 group-hover:text-white' : 'text-blue-800 group-hover:text-white'" class="text-lg lg:text-xl">Materials</div>
        </inertia-link>
    </div>
</template>

<script>
import Book from '@/Shared/Icons/Book';
import IconBase from '@/Shared/IconBase';
import Printer from '@/Shared/Icons/Printer';
import PenTool from '@/Shared/Icons/PenTool';
import InboxFull from '@/Shared/Icons/InboxFull';
import Dashboard from '@/Shared/Icons/Dashboard';

export default {
    components: {
        Book,
        Printer,
        PenTool,
        IconBase,
        InboxFull,
        Dashboard,
    },
    props: {
        display: {
            type: String,
            default: 'block',
        },
    },
}
</script>
