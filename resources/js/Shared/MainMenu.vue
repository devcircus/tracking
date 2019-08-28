<template>
    <div :class="display">
        <div :class="margin">
            <inertia-link class="flex items-center group py-3" :href="route('dashboard')">
                <icon-base :dynamic-classes="isPath('dashboard') ? 'fill-blue-300' : 'fill-white group-hover:fill-blue-300'" icon-name="dashboard" classes="mr-2">
                    <dashboard />
                </icon-base>
                <div :class="isPath('dashboard') ? 'text-blue-200' : 'text-white group-hover:text-blue-200'" class="text-xl">Dashboard</div>
            </inertia-link>
        </div>
        <div :class="margin">
            <inertia-link class="flex items-center group py-3" :href="route('inventory')">
                <icon-base :dynamic-classes="isPath('inventory') ? 'fill-blue-300' : 'fill-white group-hover:fill-blue-300'" icon-name="book" classes="mr-2">
                    <book />
                </icon-base>
                <div :class="isPath('inventory') ? 'text-blue-200' : 'text-white group-hover:text-blue-200'" class="text-xl">Inventory</div>
            </inertia-link>
        </div>
        <div :class="margin">
            <inertia-link class="flex items-center group py-3" :href="route('reports.list')">
                <icon-base :dynamic-classes="isPath('reports') ? 'fill-blue-300' : 'fill-white group-hover:fill-blue-300'" icon-name="inbox-full" classes="mr-2">
                    <inbox-full />
                </icon-base>
                <div :class="isPath('reports') ? 'text-blue-200' : 'text-white group-hover:text-blue-200'" class="text-xl">Reports</div>
            </inertia-link>
        </div>
        <div v-if="$page.auth.user.is_admin || $page.auth.user.is_artist" :class="margin">
            <inertia-link class="flex items-center group py-3" :href="route('vouchers.list')">
                <icon-base :dynamic-classes="isPath('vouchers') ? 'fill-blue-300' : 'fill-white group-hover:fill-blue-300'" icon-name="vector" classes="mr-2">
                    <vector />
                </icon-base>
                <div :class="isPath('vouchers') ? 'text-blue-200' : 'text-white group-hover:text-blue-200'" class="text-xl">Artwork</div>
            </inertia-link>
        </div>
        <div v-if="$page.auth.user.is_admin">
            <inertia-link class="flex items-center group py-3" :href="route('users.list')">
                <icon-base :dynamic-classes="isPath('users') ? 'fill-blue-300' : 'fill-white group-hover:fill-blue-300'" icon-name="users" classes="mr-2">
                    <users />
                </icon-base>
                <div :class="isPath('users') ? 'text-blue-200' : 'text-white group-hover:text-blue-200'" class="text-xl">Users</div>
            </inertia-link>
        </div>
    </div>
</template>

<script>
import Book from '@/Shared/Icons/Book';
import Users from '@/Shared/Icons/Users';
import IconBase from '@/Shared/IconBase';
import Vector from '@/Shared/Icons/Vector';
import InboxFull from '@/Shared/Icons/InboxFull';
import Dashboard from '@/Shared/Icons/Dashboard';

export default {
    components: {
        Book,
        Users,
        Vector,
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
