<template>
    <div class="relative">
        <div class="flex bg-blue-900">
            <div class="p-4">
                <h1 class="text-2xl text-white font-semibold">{{ type | capitalize }} Orders</h1>
            </div>
            <div class="ml-auto p-4 whitespace-no-wrap">
                <portal-target :name="`dropdown-${type}`" slim />
                <dropdown class="block" placement="bottom-end" :name="`dropdown-${type}`">
                    <svg class="fill-white w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" /></svg>
                    <div slot="dropdown" class="flex flex-col justify-between mt-2 px-8 py-4 shadow-lg bg-white border-2 border-blue-500 rounded">
                        <span v-if="type === 'prototype' && $page.auth.user.is_admin" class="uppercase text-base text-blue-900 font-semibold hover:text-blue-400 px-2 py-1 cursor-pointer" @click="addVoucher()">
                            Add Voucher
                        </span>
                        <inertia-link v-if="group" :href="route('reports.individual.show', { type: type, date: timestamp })" class="uppercase text-base text-blue-900 font-semibold hover:text-blue-400 px-2 py-1">
                            View
                        </inertia-link>
                        <a :href="route('pdf.show', { type: type, date: timestamp })" target="_blank" class="uppercase text-base text-blue-900 font-semibold hover:text-blue-400 px-2 py-1" @click="hideDropdown()">
                            Pdf
                        </a>
                    </div>
                </dropdown>
            </div>
        </div>
        <div v-if="windowWidth >= 768" class="flex flex-col">
            <div class="flex justify-between bg-gray-400 border-l border-r border-b border-blue-300 p-4">
                <span class="block w-200p text-lg text-gray-800 font-semibold">
                    Date
                </span>
                <span class="block w-200p text-lg text-gray-800 font-semibold">
                    Order
                </span>
                <span class="block w-300p text-lg text-gray-800 font-semibold">
                    Customer
                </span>
                <span class="block flex-1 text-lg text-gray-800 font-semibold">
                    Style
                </span>
                <span class="block flex-1 text-lg text-gray-800 font-semibold">
                    Art Ready
                </span>
                <span v-if="type === 'prototype'" class="block flex-1 text-lg text-gray-800 font-semibold">
                    Actions
                </span>
            </div>
            <template v-if="notEmpty">
                <div v-for="voucher in vouchers" :key="voucher.id" class="flex flex-wrap justify-between border-l border-r border-b border-blue-300 p-4 hover:bg-gray-300 cursor-pointer">
                    <span class="w-200p text-base text-gray-800 font-semibold md:font-normal mb-2 md:mb-0">
                        {{ voucher.schedule_date }}
                    </span>
                    <span class="w-200p text-base text-gray-800 font-normal mb-2 md:mb-0">
                        {{ voucher.order_number }} - {{ voucher.voucher }}
                    </span>
                    <span class="w-300p text-base text-gray-800 font-normal">
                        {{ voucher.customer }}
                    </span>
                    <span class="flex-1 text-base text-gray-800 font-normal">
                        {{ voucher.style }}
                    </span>
                    <span class="flex-1 text-base text-gray-800 font-normal">
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
import moment from 'moment-timezone';
import Dropdown from '@/Shared/Dropdown.vue';
import ToggleArtComplete from '@/Partials/Orders/ToggleArtComplete';

export default {
    components: {
        Dropdown,
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
            return date ?moment.utc(date).local().format('MM-DD') : '';
        },
    },
}
</script>
