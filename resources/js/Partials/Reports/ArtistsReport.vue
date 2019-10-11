<template>
    <div class="relative">
        <loading-button v-if="showBatchUpdateButton" class="btn btn-blue fixed bottom-0 right-0 mb-4 mr-4 z-10" type="button" :loading="sendingArtworkUpdate" @clicked="batchUpdateArtwork()">Batch Update</loading-button>
        <div class="w-full xl:w-full mx-auto flex p-4 bg-blue-900">
            <h1 class="text-2xl text-white font-semibold">Prototype Artwork</h1>
            <icon-base icon-fill="fill-white" icon-name="vector" classes="ml-2 mt-1">
                <vector />
            </icon-base>
        </div>
        <div v-if="windowWidth >= 1280">
            <vue-good-table ref="table" class="w-full mx-auto mb-8" :columns="artworkColumns" :rows="rows" :search-options="artworkSearchOptions" :sort-options="artworkSortOptions">
                <div slot="emptystate">
                    No prototype vouchers found.
                </div>
                <div slot="table-actions">
                    <div class="flex items-center justify-between">
                        <span class="text-blue-500 text-sm font-semibold leading-loose mr-2 inline-block mt-tenth cursor-pointer" @click="clearSearch()">Clear</span>
                        <dropdown right="10">
                            <div slot="trigger" class="flex items-center cursor-pointer select-none group">
                                <div class="text-blue-900 group-hover:text-blue-700 focus:text-blue-700 mr-1 whitespace-no-wrap">
                                    <span class="inline text-sm">Options</span>
                                </div>
                                <icon-base view="24 24" icon-fill="fill-blue-900" icon-name="cheveron-down" classes="group-hover:fill-blue-700 focus:fill-blue-700 ml-2">
                                    <cheveron-down />
                                </icon-base>
                            </div>
                            <div slot="dropdown" class="mt-2 p-2 shadow-lg bg-white rounded">
                                <checkbox v-model="showCheckboxes" class="mb-2" label="Select multiple" :width="4" :height="4" :checked="showCheckboxes" @input="hideDropdown()" />
                            </div>
                        </dropdown>
                    </div>
                </div>
                <template slot="table-row" slot-scope="props">
                    <span v-if="props.column.field == 'actions'" class="flex justify-between px-3">
                        <checkbox v-if="showCheckboxes" class="mb-2" :width="6" :height="6" :checked="selected[props.row.id] ? selected[props.row.id]['selected'] : false" @input="selectVoucher(props.row)" />
                        <toggle v-if="userCanToggleArt()"
                                :value="props.row.art_complete ? true : false"
                                on-text="Complete"
                                off-text="Not Complete"
                                :sending="sendingToggle[props.row.id] ? true : false"
                                @clicked="toggleArtComplete(props.row.id)"
                        />
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
            <div v-if="vouchersNotEmpty" class="flex flex-col w-full mx-auto pb-3">
                <div v-for="voucher in rows" :key="voucher.id" class="flex flex-col bg-white px-3 py-3 border-b odd:bg-gray-200">
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
                        <toggle v-if="userCanToggleArt()"
                                :value="voucher.art_complete ? true : false"
                                on-text="Complete"
                                off-text="Not Complete"
                                :sending="sendingToggle[voucher.id] ? true : false"
                                @clicked="toggleArtComplete(voucher.id)"
                        />
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
import Toggle from '@/Shared/Toggle';
import Checkbox from '@/Shared/Checkbox';
import IconBase from '@/Shared/IconBase';
import Vector from '@/Shared/Icons/Vector';
import { VueGoodTable } from 'vue-good-table';
import Dropdown from '@/Shared/Dropdown';
import LoadingButton from '@/Shared/LoadingButton';
import CheveronDown from '@/Shared/Icons/CheveronDown';

export default {
    components: {
        Vector,
        Toggle,
        Checkbox,
        IconBase,
        Dropdown,
        VueGoodTable,
        CheveronDown,
        LoadingButton,
    },
    props: ['vouchers', 'type', 'date', 'timestamp', 'group'],
    store: ['artworkColumns', 'artworkSortOptions', 'artworkSearchOptions'],
    data () {
        return {
            showCheckboxes: false,
            showBatchUpdateButton: false,
            sendingArtworkUpdate: false,
            sendingToggle: [],
            selected: {},
        }
    },
    computed: {
        rows () {
            return this.vouchers;
        },
        vouchersNotEmpty () {
            return ! this.isEmpty(this.vouchers);
        },
        vouchersEmpty () {
            return ! this.vouchersNotEmpty;
        },
    },
    watch: {
        selected: {
            handler (newValue) {
                if (this.count(this.selected) > 0) {
                    this.showBatchUpdateButton = true;
                } else {
                    this.showBatchUpdateButton = false;
                }
            },
            deep: true,
        },
    },
    methods: {
        userCanToggleArt () {
            return this.$page.auth.user.is_artist || this.$page.auth.user.is_admin;
        },
        toggleArtComplete (id) {
            this.sendingToggle[id] = true;
            this.$inertia.put(this.route('vouchers.art', id), null, { replace: false, preserveScroll: true, preserveState: true }).then( () => {
                this.$delete(this.sendingToggle, id);
            });
        },
        shortDate (date) {
            return date ?moment(date).format('MM-DD') : '';
        },
        clearSearch () {
            this.$refs['table'].globalSearchTerm = '';
        },
        selectVoucher (row) {
            // if the row is already selected, set to false, otherwise true
            row.selected = row.selected ? false : true;

            // check to see if this row is already selected
            let first = this.firstWhere(this.selected, ['id', row.id]);

            // if row is already selected, remove from the 'selected' collection, otherwise add it to the selected collection
            if (first !== undefined) {
                this.$delete(this.selected, row.id);
            } else {
                this.selected = Object.assign({}, this.selected, {
                    [row.id]: row,
                });
            }
        },
        batchUpdateArtwork () {
            if (this.count(this.selected) > 0) {
                this.sendingArtworkUpdate = true;
                this.$inertia.post(
                    this.route('vouchers.art.batch'),
                    { artwork: this.selected },
                    { replace: false, preserveScroll: true, preserveState: true })
                    .then( () => {
                        this.sendingArtworkUpdate = false;
                        this.showBatchUpdateButton = false;
                        this.selected = {};
                    });
            }
        },
    },
}
</script>
