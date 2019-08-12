<template>
    <div :class="display">
        <div :class="margin">
            <inertia-link class="flex items-center group py-3" :href="route('dashboard')">
                <icon name="home" class="w-4 h-4 mr-2" :class="isPath('dashboard') ? 'fill-blue-300' : 'fill-white group-hover:fill-blue-300'" />
                <div :class="isPath('dashboard') ? 'text-blue-200' : 'text-white group-hover:text-blue-200'" class="text-xl">Dashboard</div>
            </inertia-link>
        </div>
        <div :class="margin">
            <inertia-link class="flex items-center group py-3" :href="route('inventory')">
                <icon name="book" class="w-4 h-4 mr-2" :class="isPath('inventory') ? 'fill-blue-300' : 'fill-white group-hover:fill-blue-300'" />
                <div :class="isPath('inventory') ? 'text-blue-200' : 'text-white group-hover:text-blue-200'" class="text-xl">Inventory</div>
            </inertia-link>
        </div>
        <div :class="margin">
            <inertia-link class="flex items-center group py-3" :href="route('orders')">
                <icon name="posts" class="w-4 h-4 mr-2" :class="isPath('orders') ? 'fill-blue-300' : 'fill-white group-hover:fill-blue-300'" />
                <div :class="isPath('orders') ? 'text-blue-200' : 'text-white group-hover:text-blue-200'" class="text-xl">Orders</div>
            </inertia-link>
        </div>
        <div v-if="$page.auth.user.is_admin">
            <inertia-link class="flex items-center group py-3" :href="route('users.list')">
                <icon name="posts" class="w-4 h-4 mr-2" :class="isPath('users') ? 'fill-blue-300' : 'fill-white group-hover:fill-blue-300'" />
                <div :class="isPath('users') ? 'text-blue-200' : 'text-white group-hover:text-blue-200'" class="text-xl">Users</div>
            </inertia-link>
        </div>
    </div>
</template>

<script>
import Icon from '@/Shared/Icon';

export default {
    components: {
        Icon,
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
