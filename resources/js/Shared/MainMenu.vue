<template>
    <div :class="display">
        <div :class="margin">
            <inertia-link class="flex items-center group py-3" :href="route('dashboard')">
                <icon-base view="24 24" :width="20" :height="20" :dynamic-classes="isPath('dashboard') ? 'fill-blue-300' : 'fill-white group-hover:fill-blue-300'" icon-name="dashboard" classes="mt-1 mr-2">
                    <dashboard />
                </icon-base>
                <div :class="isPath('dashboard') ? 'text-blue-200' : 'text-white group-hover:text-blue-200'" class="text-xl">Dashboard</div>
            </inertia-link>
        </div>
        <div :class="margin">
            <inertia-link class="flex items-center group py-3" :href="route('inventory')">
                <icon-base :dynamic-classes="isPath('inventory') ? 'fill-blue-300' : 'fill-white group-hover:fill-blue-300'" icon-name="book" classes="mt-1 mr-2">
                    <book />
                </icon-base>
                <div :class="isPath('inventory') ? 'text-blue-200' : 'text-white group-hover:text-blue-200'" class="text-xl">Inventory</div>
            </inertia-link>
        </div>
        <div :class="margin">
            <inertia-link class="flex items-center group py-3" :href="route('reports.list')">
                <icon-base :dynamic-classes="isPath('reports') ? 'fill-blue-300' : 'fill-white group-hover:fill-blue-300'" icon-name="inbox-full" classes="mt-1 mr-2">
                    <inbox-full />
                </icon-base>
                <div :class="isPath('reports') ? 'text-blue-200' : 'text-white group-hover:text-blue-200'" class="text-xl">Reports</div>
            </inertia-link>
        </div>
        <div v-if="$page.auth.user.is_admin || $page.auth.user.is_artist" :class="margin">
            <inertia-link class="flex items-center group py-3" :href="route('artwork.list')">
                <icon-base :dynamic-classes="isPath('artwork') ? 'fill-blue-300' : 'fill-white group-hover:fill-blue-300'" icon-name="pen-tool" classes="mt-1 mr-2">
                    <pen-tool />
                </icon-base>
                <div :class="isPath('artwork') ? 'text-blue-200' : 'text-white group-hover:text-blue-200'" class="text-xl">Artwork</div>
            </inertia-link>
        </div>
        <div>
            <inertia-link class="flex items-center group py-3" :href="route('materials.list')">
                <icon-base :dynamic-classes="isPath('materials') ? 'fill-blue-300' : 'fill-white group-hover:fill-blue-300'" icon-name="printer" classes="mt-1 mr-2">
                    <printer />
                </icon-base>
                <div :class="isPath('materials') ? 'text-blue-200' : 'text-white group-hover:text-blue-200'" class="text-xl">Materials</div>
            </inertia-link>
        </div>
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
    computed: {
        margin () {
            if (this.display === 'block' || this.display === 'flex flex-col') {
                return 'mb-4';
            } else if (this.display === 'flex flex-row') {
                return 'mr-8';
            } else {
                return 'mb-4';
            }
        },
    },
}
</script>
