<template>
    <div>
        <div class="px-4 py-4 w-full border-b-2 border-gray-200">
            <mobile-logo />
        </div>
        <div class="px-4 pt-2 pb-6">
            <inertia-link class="flex items-center group mt-4 font-semibold" :href="route('dashboard')">
                <icon-base view="24 24" :width="18" :height="18" :dynamic-classes="isPath('dashboard') ? 'fill-blue-500 group-hover:fill-blue-800' : 'fill-blue-800 group-hover:fill-blue-500'" icon-name="dashboard" classes="mt-1 mr-2">
                    <dashboard />
                </icon-base>
                <div :class="isPath('dashboard') ? 'text-blue-500 group-hover:text-blue-800' : 'text-blue-800 group-hover:text-blue-500'">Dashboard</div>
            </inertia-link>
            <inertia-link class="flex items-center group mt-4 font-semibold" :href="route('inventory')">
                <icon-base view="24 24" :width="18" :height="18" :dynamic-classes="isPath('inventory') ? 'fill-blue-500 group-hover:fill-blue-800' : 'fill-blue-800 group-hover:fill-blue-500'" icon-name="inventory" classes="mt-1 mr-2">
                    <book />
                </icon-base>
                <div :class="isPath('inventory') ? 'text-blue-500 group-hover:text-blue-800' : 'text-blue-800 group-hover:text-blue-500'">Inventory</div>
            </inertia-link>
            <inertia-link class="flex items-center group mt-4 font-semibold" :href="route('reports.list')">
                <icon-base view="24 24" :width="18" :height="18" :dynamic-classes="isPath('reports') ? 'fill-blue-500 group-hover:fill-blue-800' : 'fill-blue-800 group-hover:fill-blue-500'" icon-name="reports" classes="mt-1 mr-2">
                    <inbox-full />
                </icon-base>
                <div :class="isPath('reports') ? 'text-blue-500 group-hover:text-blue-800' : 'text-blue-800 group-hover:text-blue-500'">Reports</div>
            </inertia-link>
            <inertia-link v-if="$page.auth.user.is_admin || $page.auth.user.is_artist" class="flex items-center group mt-4 font-semibold" :href="route('artwork.list')">
                <icon-base view="24 24" :width="18" :height="18" :dynamic-classes="isPath('artwork') ? 'fill-blue-500 group-hover:fill-blue-800' : 'fill-blue-800 group-hover:fill-blue-500'" icon-name="artwork" classes="mt-1 mr-2">
                    <pen-tool />
                </icon-base>
                <div :class="isPath('artwork') ? 'text-blue-500 group-hover:text-blue-800' : 'text-blue-800 group-hover:text-blue-500'">Artwork</div>
            </inertia-link>
            <inertia-link class="flex items-center group mt-4 font-semibold" :href="route('materials.list')">
                <icon-base view="24 24" :width="18" :height="18" :dynamic-classes="isPath('materials') ? 'fill-blue-500 group-hover:fill-blue-800' : 'fill-blue-800 group-hover:fill-blue-500'" icon-name="materials" classes="mt-1 mr-2">
                    <printer />
                </icon-base>
                <div :class="isPath('materials') ? 'text-blue-500 group-hover:text-blue-800' : 'text-blue-800 group-hover:text-blue-500'">Materials</div>
            </inertia-link>
        </div>
        <div class="border-t-2 border-gray-200 px-4 pt-4">
            <inertia-link class="flex items-center group mt-1 font-semibold" :href="route('logout')">
                <icon-base view="24 24" :width="18" :height="18" classes="fill-blue-800 group-hover:fill-blue-500 mt-1 mr-2" icon-name="logout">
                    <logout />
                </icon-base>
                <div class="text-blue-800 group-hover:text-blue-500">Logout</div>
            </inertia-link>
        </div>
    </div>
</template>

<script>
import Book from '@/Shared/Icons/Book';
import IconBase from '@/Shared/IconBase';
import MobileLogo from '@/Shared/MobileLogo';
import Printer from '@/Shared/Icons/Printer';
import PenTool from '@/Shared/Icons/PenTool';
import Logout from '@/Shared/Icons/Logout';
import InboxFull from '@/Shared/Icons/InboxFull';
import Dashboard from '@/Shared/Icons/Dashboard';

export default {
    components: {
        Book,
        Logout,
        Printer,
        PenTool,
        IconBase,
        InboxFull,
        Dashboard,
        MobileLogo,
    },
    props: {
        display: {
            type: String,
            default: 'block',
        },
    },
}
</script>
