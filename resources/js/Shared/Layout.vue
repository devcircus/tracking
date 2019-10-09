<template>
    <div>
        <modal />
        <portal-target name="dropdown" slim />
        <flash-message />

        <!-- TOP BARS -->
        <div class="fixed top-0 w-full z-10">
            <!-- TOP BLUE BAR -->
            <div class="flex justify-between items-center w-full px-4 py-8 bg-blue-800 ">
                <inertia-link class="mt-1" :href="route('dashboard')">
                    <logo position="left" />
                </inertia-link>
                <div class="hidden lg:block">
                    <main-menu display="flex flex-row" />
                </div>
            </div>

            <!-- TOP WHITE BAR -->
            <div class="flex justify-between items-center w-full text-sm md:text-base bg-white border-b shadow h-16 p-4 py-8">
                <div class="mt-1 mr-4">&nbsp;</div>
                <dropdown v-if="$page.auth.user" class="mt-1 md:ml-auto " placement="bottom-end">
                    <div class="flex items-center cursor-pointer select-none group">
                        <div class="text-blue-900 group-hover:text-blue-700 focus:text-blue-700 mr-1 whitespace-no-wrap">
                            <span class="inline">{{ $page.auth.user.name }}</span>
                        </div>
                        <icon-base icon-function="cheveron-down" icon-fill="fill-blue-500" classes="ml-2">
                            <cheveron-down />
                        </icon-base>
                    </div>
                    <div slot="dropdown" class="mt-2 py-2 shadow-lg bg-white rounded text-sm">
                        <user-menu />
                    </div>
                </dropdown>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex flex-grow w-full relative mt-140p">
            <div class="overflow-hidden px-4 py-8 lg:py-12 w-full">
                <ol v-if="$page.breadcrumbs" class="breadcrumb">
                    <li v-for="crumb in breadcrumbTrail" :key="crumb.title" class="breadcrumb-item"><inertia-link :href="crumb.url">{{ crumb.title }}</inertia-link></li>
                    <li class="breadcrumb-item active">{{ breadcrumbCurrent.title }}</li>
                </ol>
                <slot />
            </div>
        </div>

        <!-- Site Footer -->
        <site-footer />
    </div>
</template>

<script>
import Logo from '@/Shared/Logo';
import Modal from '@/Shared/Modal';
import IconBase from '@/Shared/IconBase';
import Dropdown from '@/Shared/Dropdown';
import MainMenu from '@/Shared/MainMenu';
import UserMenu from '@/Shared/UserMenu';
import SiteFooter from '@/Shared/SiteFooter';
import FlashMessage from '@/Shared/FlashMessage';
import CheveronDown from '@/Shared/Icons/CheveronDown';

export default {
    components: {
        Logo,
        Modal,
        IconBase,
        Dropdown,
        UserMenu,
        MainMenu,
        SiteFooter,
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
