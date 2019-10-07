<template>
    <div>
        <modal />
        <portal-target name="dropdown" slim />
        <flash-message />
        <div class="flex flex-col">
            <div class="flex flex-col">
                <div class="flex flex-wrap">
                    <div class="bg-blue-900 flex-no-shrink w-full px-4 py-8 lg:p-12 flex justify-between items-center">
                        <inertia-link class="mt-1" :href="route('dashboard')">
                            <logo position="left" />
                        </inertia-link>
                        <div class="hidden lg:block">
                            <main-menu display="flex flex-row" />
                        </div>
                        <dropdown class="block lg:hidden" placement="bottom-end">
                            <svg class="fill-white w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" /></svg>
                            <div slot="dropdown" class="mt-2 px-8 py-4 shadow-lg bg-blue-800 rounded">
                                <main-menu />
                            </div>
                        </dropdown>
                    </div>
                    <div class="flex w-full h-20 bg-white bg-tictac border-b shadow p-4 px-4 py-8 md:px-12 text-sm lg:text-base justify-between items-center relative">
                        <div class="mt-1 mr-4">&nbsp;</div>
                        <dropdown v-if="$page.auth.user" class="mt-1 lg:ml-auto " placement="bottom-end">
                            <div class="flex items-center cursor-pointer select-none group">
                                <span class="text-blue-800 font-semibold group-hover:text-blue-500 focus:text-blue-500 mr-1 whitespace-no-wrap">
                                    {{ $page.auth.user.name }}
                                </span>
                                <icon-base view="24 24" icon-fill="fill-blue-800" classes="group-hover:fill-blue-500 focus:fill-blue-500">
                                    <cheveron-down />
                                </icon-base>
                            </div>
                            <div slot="dropdown" class="mt-2 py-2 shadow-lg bg-white rounded text-sm">
                                <div class="flex flex-col">
                                    <inertia-link class="flex px-6 py-2 hover:bg-blue-500 hover:text-white group" :href="route('users.edit', $page.auth.user.id)">
                                        <icon-base width="14" height="14" icon-fill="fill-gray-800" icon-name="profile" classes="mr-2 group-hover:fill-white">
                                            <profile />
                                        </icon-base>
                                        My Profile
                                    </inertia-link>
                                    <div v-if="$page.auth.user.is_super_admin">
                                        <inertia-link class="flex px-6 py-2 hover:bg-blue-500 hover:text-white group" :href="route('users.list')">
                                            <icon-base width="14" height="14" icon-fill="fill-gray-800" icon-name="users" classes="mr-2 group-hover:fill-white">
                                                <users />
                                            </icon-base>
                                            Manage Users
                                        </inertia-link>
                                        <inertia-link class="flex px-6 py-2 hover:bg-blue-500 hover:text-white group" :href="route('activities.list')">
                                            <icon-base width="14" height="14" icon-fill="fill-gray-800" icon-name="activities" classes="mr-2 group-hover:fill-white">
                                                <activities />
                                            </icon-base>
                                            View Activities
                                        </inertia-link>
                                    </div>
                                    <inertia-link class="flex px-6 py-2 hover:bg-blue-500 hover:text-white group" :href="route('logout')" method="post">
                                        <icon-base width="14" height="14" icon-fill="fill-gray-800" icon-name="logout" classes="mr-2 group-hover:fill-white">
                                            <logout />
                                        </icon-base>
                                        Logout
                                    </inertia-link>
                                </div>
                            </div>
                        </dropdown>
                    </div>
                </div>
                <div class="flex flex-grow w-full relative">
                    <div class="overflow-hidden px-4 py-8 lg:p-12 w-full">
                        <ol v-if="$page.breadcrumbs" class="breadcrumb">
                            <li v-for="crumb in breadcrumbTrail" :key="crumb.title" class="breadcrumb-item"><inertia-link :href="crumb.url">{{ crumb.title }}</inertia-link></li>
                            <li class="breadcrumb-item active">{{ breadcrumbCurrent.title }}</li>
                        </ol>
                        <slot />
                    </div>
                </div>
            </div>
        </div>
        <site-footer />
    </div>
</template>

<script>
import Logo from '@/Shared/Logo';
import Modal from '@/Shared/Modal';
import Users from '@/Shared/Icons/Users';
import IconBase from '@/Shared/IconBase';
import Dropdown from '@/Shared/Dropdown';
import MainMenu from '@/Shared/MainMenu';
import Logout from '@/Shared/Icons/Logout';
import Profile from '@/Shared/Icons/Profile';
import SiteFooter from '@/Shared/SiteFooter';
import FlashMessage from '@/Shared/FlashMessage';
import Activities from '@/Shared/Icons/Activities';
import CheveronDown from '@/Shared/Icons/CheveronDown';

export default {
    components: {
        Logo,
        Modal,
        Users,
        Logout,
        Profile,
        IconBase,
        Dropdown,
        MainMenu,
        SiteFooter,
        Activities,
        FlashMessage,
        CheveronDown,
    },
    props: {
        title: String,
    },
    head: {
        title: function () {
            return {
                inner: this.title,
            }
        },
    },
    computed: {
        breadcrumbTrail () {
            return this.$page.breadcrumbs ? this.$page.breadcrumbs.slice(0, -1): null;
        },
        breadcrumbCurrent () {
            return this.$page.breadcrumbs ? this.$page.breadcrumbs[this.$page.breadcrumbs.length -1] : null;
        },
    },
}
</script>
