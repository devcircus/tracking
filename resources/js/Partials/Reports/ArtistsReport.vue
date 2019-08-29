<template>
    <div class="relative">
        <div class="flex p-4 bg-blue-900">
            <h1 class="text-2xl text-white font-semibold">Prototype Artwork</h1>
            <icon-base icon-fill="fill-white" icon-name="vector" classes="ml-2 mt-1">
                <vector />
            </icon-base>
        </div>
        <div v-if="windowWidth >= 800" class="flex flex-col">
            <div class="flex justify-between bg-gray-400 border-l border-r border-b border-blue-300 p-4">
                <span class="block w-120p text-lg text-gray-800 font-semibold">
                    Date
                </span>
                <span class="hidden xl:block w-200p text-lg text-gray-800 font-semibold">
                    Order
                </span>
                <span class="block w-300p text-lg text-gray-800 font-semibold">
                    Customer
                </span>
                <span class="block flex-1 text-lg text-gray-800 font-semibold">
                    Style
                </span>
                <span class="hidden xl:block flex-1 text-lg text-gray-800 font-semibold">
                    Art Ready
                </span>
                <span v-if="type === 'prototype'" class="block flex-1 text-lg text-gray-800 font-semibold">
                    Actions
                </span>
            </div>
            <template v-if="notEmpty">
                <div v-for="voucher in vouchers" :key="voucher.id" class="flex flex-wrap justify-between border-l border-r border-b border-blue-300 p-4 hover:bg-gray-300 cursor-pointer">
                    <span class="w-120p text-base text-gray-800 font-semibold md:font-normal mb-2 md:mb-0">
                        {{ voucher.schedule_date }}
                    </span>
                    <span class="hidden xl:block w-200p text-base text-gray-800 font-normal mb-2 md:mb-0">
                        {{ voucher.order_number }} - {{ voucher.voucher }}
                    </span>
                    <span class="w-300p text-base text-gray-800 font-normal">
                        {{ voucher.customer }}
                    </span>
                    <span class="flex-1 text-base text-gray-800 font-normal">
                        {{ voucher.style }}
                    </span>
                    <span class="hidden xl:block flex-1 text-base text-gray-800 font-normal">
                        {{ shortDate(voucher.art_complete) }}
                    </span>
                    <div v-if="$page.auth.user.is_artist || $page.auth.user.is_admin" class="flex-1 text-base text-gray-800 font-normal">
                        <toggle-art-complete :voucher="voucher" />
                    </div>
                </div>
            </template>
            <template v-else>
                <div class="flex justify-between border-l border-r border-b border-blue-300 p-4">
                    <span class="text-lg text-gray-800 font-normal">
                        No Vouchers Found
                    </span>
                </div>
            </template>
        </div>
        <template v-else>
            <div class="border border-gray-400 mb-8">
                <div class="flex flex-col">
                    <div v-for="voucher in vouchers" :key="voucher.id" class="flex flex-col bg-white px-3 py-3 border-b">
                        <span class="font-semibold text-gray-700 mb-2 mt-4">Schedule Date: <span class="font-normal">{{ voucher.schedule_date }}</span></span>
                        <span class="font-semibold text-gray-700 mb-2">Order: <span class="font-normal">{{ voucher.order_number }} - {{ voucher.voucher }}</span></span>
                        <span class="font-semibold text-gray-700 mb-2">Customer: <span class="font-normal">{{ voucher.customer }}</span></span>
                        <span class="font-semibold text-gray-700 mb-2">Style: <span class="font-normal">{{ voucher.style }}</span></span>
                        <span class="font-semibold text-gray-700 mb-3">Art Complete: <span class="font-normal">{{ shortDate(voucher.art_complete) }}</span></span>
                        <span v-if="$page.auth.user.is_artist || $page.auth.user.is_admin" class="w-full">
                            <toggle-art-complete class="ml-auto" :voucher="voucher" />
                        </span>
                    </div>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
import moment from 'moment';
import IconBase from '@/Shared/IconBase';
import Vector from '@/Shared/Icons/Vector';
import ToggleArtComplete from '@/Partials/Orders/ToggleArtComplete';

export default {
    components: {
        Vector,
        IconBase,
        ToggleArtComplete,
    },
    props: ['vouchers', 'type', 'date', 'timestamp', 'group'],
    computed: {
        notEmpty () {
            return this.vouchers.length > 0;
        },
        isEmpty () {
            return ! this.notEmpty;
        },
    },
    methods: {
        shortDate (date) {
            return date ?moment(date).format('MM-DD') : '';
        },
    },
}
</script>
