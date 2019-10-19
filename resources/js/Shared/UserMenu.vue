<template>
    <div class="w-64 text-left bg-white rounded-lg shadow-lg">
        <div class="flex items-center px-6 py-4">
            <icon-base width="18" height="18" icon-fill="fill-gray-800" icon-name="profile" classes="mr-2 flex-no-shrink dropdown-item">
                <profile />
            </icon-base>
            <div class="ml-4">
                <p class="font-semibold text-gray-900 leading-none mb-2">{{ $page.auth.user.name }}</p>
                <inertia-link class="flex text-sm text-gray-600 leading-none hover:underline dropdown-item" :href="route('users.edit', $page.auth.user.id)">
                    View Profile
                </inertia-link>
            </div>
        </div>
        <div v-if="$page.auth.user.can.administerUsers" class="border-t-2 border-gray-200 py-1">
            <inertia-link class="flex px-6 py-3 hover:bg-gray-200 dropdown-item" :href="route('users.list')">
                <icon-base width="14" height="14" icon-fill="fill-gray-800" icon-name="users" classes="mr-2">
                    <users />
                </icon-base>
                Manage Users
            </inertia-link>
            <inertia-link class="flex px-6 py-3 hover:bg-gray-200 dropdown-item" :href="route('activities.list')">
                <icon-base width="14" height="14" icon-fill="fill-gray-800" icon-name="activities" classes="mr-2">
                    <activities />
                </icon-base>
                View Activities
            </inertia-link>
        </div>
        <div class="border-t-2 border-gray-200 py-1">
            <inertia-link class="flex w-full px-6 py-3 text-left leading-tight hover:bg-gray-200 dropdown-item" :href="route('logout')" method="post">
                <icon-base width="14" height="14" icon-fill="fill-gray-800" icon-name="logout" classes="mr-2">
                    <logout />
                </icon-base>
                Logout
            </inertia-link>
        </div>
    </div>
</template>

<script>
import IconBase from '@/Shared/IconBase';
import Users from '@/Shared/Icons/Users';
import Logout from '@/Shared/Icons/Logout';
import Profile from '@/Shared/Icons/Profile';
import Activities from '@/Shared/Icons/Activities';

export default {
    components: {
        Users,
        Logout,
        Profile,
        IconBase,
        Activities,
    },
}
</script>
