<template>
    <div>
        <modal />
        <flash-message />

        <!-- TOP BARS -->
        <div class="fixed top-0 w-full" style="z-index:80">
            <!-- TOP BLUE BAR -->
            <div class="flex justify-between items-center w-full px-4 py-8 bg-blue-800 ">
                <inertia-link class="inline-block md:hidden lg:inline-block mt-1" :href="route('dashboard')">
                    <logo-on-dark position="left" />
                </inertia-link>
                <flyout>
                    <div slot="flyout">
                        <mobile-main-menu />
                    </div>
                </flyout>
                <div class="hidden md:block ml-auto">
                    <desktop-main-menu display="flex flex-row" />
                </div>
            </div>

            <!-- TOP WHITE BAR -->
            <div class="flex justify-between items-center w-full text-sm md:text-base bg-white border-b shadow h-16 p-4 py-8">
                <inertia-link class="hidden md:inline-block lg:hidden mt-1" :href="route('dashboard')">
                    <logo-on-light position="left" />
                </inertia-link>
                <div class="mt-1 mr-4">&nbsp;</div>
                <dropdown v-if="$page.auth.user" class="mt-1 md:ml-auto " width="180" :nav="true">
                    <div slot="trigger" class="flex items-center cursor-pointer select-none group">
                        <div class="flex text-blue-800 group-hover:text-blue-500 focus:text-blue-500 mr-1 whitespace-no-wrap">
                            <span class="inline-block mt-px">{{ $page.auth.user.email }}</span>
                            <icon-base icon-function="cheveron-down" icon-fill="fill-blue-800" classes="ml-1 group-hover:fill-blue-500">
                                <cheveron-down />
                            </icon-base>
                        </div>
                    </div>
                    <div slot="dropdown" class="mt-2 shadow-lg bg-white rounded text-sm">
                        <user-menu />
                    </div>
                </dropdown>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex flex-grow w-full relative mt-160p">
            <div class="overflow-hidden px-4 py-8 lg:py-12 w-full">
                <breadcrumbs />
                <slot />
            </div>
        </div>

        <!-- Site Footer -->
        <site-footer />
    </div>
</template>

<script>
import Modal from '@/Shared/Modal';
import Flyout from '@/Shared/Flyout';
import IconBase from '@/Shared/IconBase';
import DesktopMainMenu from '@/Shared/DesktopMainMenu';
import MobileMainMenu from '@/Shared/MobileMainMenu';
import UserMenu from '@/Shared/UserMenu';
import Dropdown from '@/Shared/Dropdown';
import LogoOnDark from '@/Shared/LogoOnDark';
import SiteFooter from '@/Shared/SiteFooter';
import LogoOnLight from '@/Shared/LogoOnLight';
import Breadcrumbs from '@/Shared/Breadcrumbs';
import FlashMessage from '@/Shared/FlashMessage';
import CheveronDown from '@/Shared/Icons/CheveronDown';

export default {
    components: {
        Modal,
        Flyout,
        IconBase,
        UserMenu,
        Dropdown,
        SiteFooter,
        LogoOnDark,
        Breadcrumbs,
        LogoOnLight,
        FlashMessage,
        CheveronDown,
        MobileMainMenu,
        DesktopMainMenu,
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
}
</script>
