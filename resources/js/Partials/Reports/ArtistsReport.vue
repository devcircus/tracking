<template>
    <div class="relative">
        <div class="w-3/4 xl:w-full mx-auto flex p-4 bg-blue-900">
            <h1 class="text-2xl text-white font-semibold">Prototype Artwork</h1>
            <icon-base icon-fill="fill-white" icon-name="vector" classes="ml-2 mt-1">
                <vector />
            </icon-base>
        </div>
        <div v-if="windowWidth >= 1280">
            <vue-good-table ref="table" class="w-full mx-auto mb-8" :columns="artworkColumns" :rows="vouchers" :search-options="artworkSearchOptions" :sort-options="artworkSortOptions">
                <div slot="emptystate">
                    No prototype vouchers found.
                </div>
                <div slot="table-actions" class="flex justify-between">
                    <span class="text-blue-500 text-sm font-semibold leading-loose mr-2 inline-block mt-tenth cursor-pointer" @click="clearSearch()">Clear</span>
                </div>
                <template slot="table-row" slot-scope="props">
                    <span v-if="props.column.field == 'actions'" class="flex justify-between px-3">
                        <toggle-art-complete v-if="$page.auth.user.is_artist || $page.auth.user.is_admin" class="ml-auto btn-sm" :voucher="props.row" />
                    </span>
                    <span v-if="props.row.art_complete">
                        <span class="text-green-500">{{ props.formattedRow[props.column.field] }}</span>
                    </span>
                    <span v-else>
                        <span class="text-red-500">{{ props.formattedRow[props.column.field] }}</span>
                    </span>
                </template>
            </vue-good-table>
        </div>
        <div v-else>
            <div v-if="notEmpty" class="flex flex-col w-3/4 mx-auto">
                <div v-for="voucher in vouchers" :key="voucher.id" class="flex flex-col bg-white px-3 py-3 border-b">
                    <div class="flex mb-4 mt-4">
                        <span class="w-160p font-semibold text-lg uppercase text-gray-700">Schedule Date: </span>
                        <span class="text-lg text-gray-600 font-semibold">{{ voucher.schedule_date }}</span>
                    </div>
                    <div class="flex mb-2">
                        <span class="w-160p font-semibold text-gray-700">Order: </span>
                        <span class="font-normal">{{ voucher.order_number }} - {{ voucher.voucher }}</span>
                    </div>

                    <div class="flex mb-2">
                        <span class="w-160p font-semibold text-gray-700">Customer: </span>
                        <span class="font-normal">{{ voucher.customer }}</span>
                    </div>

                    <div class="flex mb-2">
                        <span class="w-160p font-semibold text-gray-700">Style: </span>
                        <span class="font-normal">{{ voucher.style }}</span>
                    </div>

                    <div class="flex mb-3">
                        <span class="w-160p font-semibold text-gray-700">Art Complete: </span>
                        <span class="font-normal">{{ shortDate(voucher.art_complete) }}</span>
                    </div>

                    <span v-if="$page.auth.user.is_artist || $page.auth.user.is_admin" class="w-full">
                        <toggle-art-complete class="ml-auto" :voucher="voucher" />
                    </span>
                </div>
            </div>
            <div v-else class="flex justify-between border-l border-r border-b border-blue-300 p-4">
                <span class="text-lg text-gray-800 font-normal">
                    No Vouchers Found
                </span>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment';
import IconBase from '@/Shared/IconBase';
import Vector from '@/Shared/Icons/Vector';
import { VueGoodTable } from 'vue-good-table';
import ToggleArtComplete from '@/Partials/Orders/ToggleArtComplete';

export default {
    components: {
        Vector,
        IconBase,
        VueGoodTable,
        ToggleArtComplete,
    },
    props: ['vouchers', 'type', 'date', 'timestamp', 'group'],
    store: ['artworkColumns', 'artworkSortOptions', 'artworkSearchOptions'],
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
        clearSearch () {
            this.$refs['table'].globalSearchTerm = '';
        },
    },
}
</script>
