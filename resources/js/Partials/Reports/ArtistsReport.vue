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
        <div class="flex flex-col">
            <div class="flex justify-between bg-gray-400 border-l border-r border-b border-blue-300 p-4">
                <span class="w-120 md:w-200p text-lg text-gray-800 font-semibold">
                    Date
                </span>
                <span class="w-140 md:w-200p text-lg text-gray-800 font-semibold">
                    Order
                </span>
                <span class="hidden md:block w-200p text-lg text-gray-800 font-semibold">
                    Voucher
                </span>
                <span class="hidden md:block w-300p text-lg text-gray-800 font-semibold">
                    Customer
                </span>
                <span class="hidden md:block flex-1 text-lg text-gray-800 font-semibold">
                    Style
                </span>
                <span v-if="type === 'prototype'" class="hidden md:block flex-1 text-lg text-gray-800 font-semibold">
                    Actions
                </span>
            </div>
            <template v-if="notEmpty">
                <div v-for="voucher in vouchers" :key="voucher.id" class="flex flex-wrap justify-between border-l border-r border-b border-blue-300 p-4 hover:bg-gray-300 cursor-pointer">
                    <span class="w-120 md:w-200p text-base text-gray-800 font-normal">
                        {{ shortDate(voucher.schedule_date) }}
                    </span>
                    <span class="hidden md:block w-200p text-base text-gray-800 font-normal">
                        {{ voucher.order_number }}
                    </span>
                    <span class="block md:hidden w-140 text-base text-gray-800 font-normal">
                        {{ voucher.order_number }} - {{ voucher.voucher }}
                    </span>
                    <span class="hidden md:block w-200p text-base text-gray-800 font-normal">
                        {{ voucher.voucher }}
                    </span>
                    <span class="hidden md:block w-300p text-base text-gray-800 font-normal">
                        {{ voucher.customer }}
                    </span>
                    <span class="hidden md:block flex-1 text-base text-gray-800 font-normal">
                        {{ voucher.style }}
                    </span>
                    <div v-if="$page.auth.user.is_artist || $page.auth.user.is_admin" class="hidden md:block flex-1 text-base text-gray-800 font-normal">
                        <loading-button v-if="! voucher.art_complete" :loading="isSending(voucher.id)" class="btn" :class="buttonClasses(voucher)" type="button" @clicked="toggleArtComplete(voucher)">{{ buttonText(voucher.id) }}</loading-button>
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
    </div>
</template>

<script>
import moment from 'moment-timezone';
import Dropdown from '@/Shared/Dropdown.vue';
import LoadingButton from '@/Shared/LoadingButton.vue';

export default {
    components: { Dropdown, LoadingButton },
    props: ['vouchers', 'type', 'date', 'timestamp', 'group'],
    data () {
        return {
            sending: false,
        }
    },
    computed: {
        notEmpty () {
            return this.vouchers.length > 0;
        },
        isEmpty () {
            return ! this.notEmpty;
        },
    },
    mounted () {
        this.vouchers.forEach(voucher => {
            this[`sending${voucher.id}`] = false;
        });
    },
    methods: {
        buttonText (voucher) {
            return voucher.art_complete ? 'Mark not complete' : 'Mark complete';
        },
        buttonClasses (voucher) {
            return voucher.art_complete ? 'btn-muted' : 'btn-green';
        },
        shortDate (date) {
            return moment.utc(date).format('MM-DD');
        },
        toggleArtComplete (id) {
            this.sending = true;
            this.$inertia.put(this.route('vouchers.art', id)).then(() => this.sending = false);
        },
        isSending (id) {
            return this[`sending${id}`];
        },
    },
}
</script>
