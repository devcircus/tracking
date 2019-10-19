<template>
    <div class="relative w-full" style="z-index: 90;">
        <div class="flex w-full md:hidden">
            <button ref="openButton" type="button" class="block text-gray-600 focus:outline-none focus:text-gray-900 ml-auto" aria-label="Menu" @click="open">
                <svg class="h-6 w-6" fill="white" viewBox="0 0 24 24">
                    <path d="M3 6C3 5.44772 3.44772 5 4 5H20C20.5523 5 21 5.44772 21 6C21 6.55228 20.5523 7 20 7H4C3.44772 7 3 6.55228 3 6Z" />
                    <path d="M3 12C3 11.4477 3.44772 11 4 11H20C20.5523 11 21 11.4477 21 12C21 12.5523 20.5523 13 20 13H4C3.44772 13 3 12.5523 3 12Z" />
                    <path d="M4 17C3.44772 17 3 17.4477 3 18C3 18.5523 3.44772 19 4 19H20C20.5523 19 21 18.5523 21 18C21 17.4477 20.5523 17 20 17H4Z" />
                </svg>
            </button>
        </div>
        <!-- Off-canvas menu background overlay -->
        <transition
            enter-class="opacity-0"
            enter-active-class="ease-out transition-medium"
            enter-to-class="opacity-100"
            leave-class="opacity-100"
            leave-active-class="ease-out transition-medium"
            leave-to-class="opacity-0"
            appear
        >
            <div v-show="isOpen" class="z-10 fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-black opacity-50" tabindex="-1" @click="close"></div>
            </div>
        </transition>

        <!-- Off-canvas menu -->
        <transition
            enter-class="translate-x-full"
            enter-active-class="ease-out transition-slow"
            enter-to-class="translate-x-0"
            leave-class="translate-x-0"
            leave-active-class="ease-in transition-medium"
            leave-to-class="translate-x-full"
            appear
        >
            <div v-show="isOpen" class="z-10 fixed inset-y-0 right-0 max-w-xs w-full bg-white transition-transform overflow-y-auto">
                <div class="relative z-10 bg-white">
                    <div :class="isOpen ? 'block' : 'hidden'" class="absolute top-0 right-0 p-4">
                        <button ref="closeButton" type="button" class="text-gray-600 focus:outline-none focus:text-gray-900" aria-label="Close" @click="close">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18.2929 19.7071C18.6834 20.0976 19.3166 20.0976 19.7071 19.7071C20.0976 19.3166 20.0976 18.6834 19.7071 18.2929L13.4142 12L19.7071 5.70711C20.0976 5.31658 20.0976 4.68342 19.7071 4.29289C19.3166 3.90237 18.6834 3.90237 18.2929 4.29289L12 10.5858L5.70711 4.29289C5.31658 3.90237 4.68342 3.90237 4.29289 4.29289C3.90237 4.68342 3.90237 5.31658 4.29289 5.70711L10.5858 12L4.29289 18.2929C3.90237 18.6834 3.90237 19.3166 4.29289 19.7071C4.68342 20.0976 5.31658 20.0976 5.70711 19.7071L12 13.4142L18.2929 19.7071Z"/>
                            </svg>
                        </button>
                    </div>
                    <slot name="flyout" />
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                isOpen: false,
            }
        },
        watch: {
            isOpen: {
            immediate: true,
                handler (isOpen) {
                    if (isOpen) {
                        document.body.style.setProperty('overflow', 'hidden');
                    } else {
                        document.body.style.removeProperty('overflow');
                    }
                },
            },
        },
        methods: {
            open () {
                this.isOpen = true;
                this.$nextTick(() => {
                    this.$refs.closeButton.focus()
                });
            },
            close () {
                this.isOpen = false;
                this.$nextTick(() => {
                    this.$refs.openButton.focus()
                });
            },
            toggle () {
                this.isOpen = ! this.isOpen;
            },
        },
    }
</script>
