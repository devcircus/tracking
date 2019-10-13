<template>
    <div class="relative">
        <loading-button v-if="showUpdateInfoButton" class="btn btn-blue fixed bottom-0 right-0 mb-4 mr-4 z-10" type="button" :loading="sendingInfoUpdate" @clicked="batchUpdateInfo()">Batch Update</loading-button>
        <div class="flex bg-blue-900">
            <div class="p-4">
                <h1 class="text-2xl text-white font-semibold">{{ type | capitalize }} Orders</h1>
            </div>
            <div class="ml-auto p-4 whitespace-no-wrap">
                <dropdown class="block" width="180">
                    <div slot="trigger">
                        <svg class="fill-white w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" /></svg>
                    </div>
                    <div slot="dropdown" class="flex flex-col justify-between mt-2 py-2 shadow-lg bg-white rounded">
                        <div v-if="type === 'prototype' && can('administerReports')" class="flex items-center px-3 py-2 text-gray-700 hover:bg-blue-500 hover:text-white group" @click="addVoucher()">
                            <icon-base view="24 24" icon-fill="fill-gray-700" icon-name="add fabric" classes="mr-2 group-hover:fill-white">
                                <plus />
                            </icon-base>
                            <span class="uppercase text-base text-blue-900 font-semibold py-1 cursor-pointer group-hover:text-white">
                                Add Voucher
                            </span>
                        </div>
                        <inertia-link :href="route('reports.individual.show', { type: type, date: timestamp })" class="flex items-center px-3 py-2 text-gray-700 hover:bg-blue-500 hover:text-white group">
                            <icon-base view="24 24" icon-fill="fill-gray-700" icon-name="view" classes="mr-2 group-hover:fill-white">
                                <view-eye />
                            </icon-base>
                            <span v-if="group" class="uppercase text-base text-blue-900 font-semibold py-1 group-hover:text-white">
                                View
                            </span>
                        </inertia-link>
                        <a :href="route('pdf.show', { type: type, date: timestamp })" target="_blank" class="flex items-center px-3 py-2 text-gray-700 hover:bg-blue-500 hover:text-white group" @click="hideDropdown()">
                            <icon-base width="14" height="14" icon-fill="fill-gray-700" icon-name="printable" classes="mr-2 group-hover:fill-white">
                                <printer />
                            </icon-base>
                            <span class="uppercase text-base text-blue-900 font-semibold py-1 group-hover:text-white">
                                Pdf
                            </span>
                        </a>
                    </div>
                </dropdown>
            </div>
        </div>
        <div class="flex flex-col">
            <div class="flex justify-between bg-gray-400 border-l border-r border-b border-blue-300 p-4">
                <span class="hidden xl:block lg:w-120p text-lg text-gray-800 font-semibold">
                    Date
                </span>
                <span class="hidden xl:block lg:w-220p text-lg text-gray-800 font-semibold">
                    Order
                </span>
                <span v-if="type === 'prototype'" class="block w-120p md:w-300p xl:hidden text-lg text-gray-800 font-semibold">
                    Order
                </span>
                <span v-else class="block w-300p xl:hidden text-lg text-gray-800 font-semibold">
                    Order
                </span>
                <span class="hidden xl:block w-300p text-lg text-gray-800 font-semibold">
                    Customer
                </span>
                <span v-if="type != 'prototype'" class="hidden md:block md:w-160p text-lg text-gray-800 font-semibold">
                    Style
                </span>
                <span v-else class="hidden lg:block lg:w-160p text-lg text-gray-800 font-semibold">
                    Style
                </span>
                <span v-if="type === 'prototype'" class="text-lg text-gray-800 font-semibold w-260p">
                    Info
                </span>
            </div>
            <template v-if="vouchersNotEmpty">
                <div v-for="item in data" :key="item.id" class="flex flex-wrap justify-between items-center border-l border-r border-b border-blue-300 p-4 hover:bg-gray-300 cursor-pointer" @click.prevent.stop="showActionModal(type, item)">
                    <span class="hidden xl:block lg:w-120p text-base xl:text-lg font-normal" :class="type === 'prototype' && item.art_complete ? 'text-green-700 font-semibold' : 'text-gray-800'">
                        {{ shortDate(item.schedule_date) }}
                    </span>
                    <span class="hidden xl:block xl:w-220p text-base xl:text-lg font-normal" :class="type === 'prototype' && item.art_complete ? 'text-green-700 font-semibold' : 'text-gray-800'">
                        {{ item.order_number }} - {{ item.voucher }}
                    </span>
                    <div v-if="type === 'prototype'" class="block w-120p md:w-300p xl:hidden text-base xl:text-lg font-normal" :class="type === 'prototype' && item.art_complete ? 'text-green-700 font-semibold' : 'text-gray-800'">
                        <span class="block mb-2 font-semibold">{{ shortDate(item.schedule_date) }}</span>
                        <span class="block mb-2 text-gray-600">{{ item.order_number }} - {{ item.voucher }}</span>
                        <span class="block xl:hidden">{{ item.customer }}</span>
                    </div>
                    <div v-else class="block w-300p xl:hidden text-base xl:text-lg font-normal" :class="type === 'prototype' && item.art_complete ? 'text-green-700 font-semibold' : 'text-gray-800'">
                        <span class="block mb-2 font-semibold">{{ shortDate(item.schedule_date) }}</span>
                        <span class="block mb-2 text-gray-600">{{ item.order_number }} - {{ item.voucher }}</span>
                        <span class="block xl:hidden">{{ item.customer }}</span>
                    </div>
                    <span class="hidden xl:block w-300p text-base xl:text-lg font-normal" :class="type === 'prototype' && item.art_complete ? 'text-green-700 font-semibold' : 'text-gray-800'">
                        {{ item.customer }}
                    </span>
                    <span v-if="type != 'prototype'" class="hidden md:block md:w-160p text-base xl:text-lg font-normal" :class="type === 'prototype' && item.art_complete ? 'text-green-700 font-semibold' : 'text-gray-800'">
                        {{ item.style }}
                    </span>
                    <span v-else class="hidden lg:block lg:w-160p text-base xl:text-lg font-normal" :class="type === 'prototype' && item.art_complete ? 'text-green-700 font-semibold' : 'text-gray-800'">
                        {{ item.style }}
                    </span>
                    <div v-if="type === 'prototype' && can('administerReports')" class="text-base xl:text-lg text-gray-800 font-normal w-260p mt-3" @click.stop>
                        <input :id="`${item.id}`"
                               v-model="info[item.id]"
                               class="border border-blue p-1 h-12 w-full"
                               type="text"
                               name="info"
                               @focus="prepareToRecordInfo"
                               @blur="setNewInfo"
                        >
                    </div>
                    <span v-else-if="type === 'prototype'" class="text-sm xl:text-base text-gray-800 font-normal lg:w-260p xl:w-300p" :class="item.info === 'COMPLETE' ? 'text-blue-500' : 'text-red-500'">
                        {{ item.info }}
                    </span>
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
import moment from 'moment';
import { map } from 'lodash';
import Plus from '@/Shared/Icons/Plus';
import IconBase from '@/Shared/IconBase';
import Printer from '@/Shared/Icons/Printer';
import ViewEye from '@/Shared/Icons/ViewEye';
import Dropdown from '@/Shared/Dropdown.vue';
import LoadingButton from '@/Shared/LoadingButton.vue';

export default {
    components: {
        Plus,
        ViewEye,
        Printer,
        IconBase,
        Dropdown,
        LoadingButton,
    },
    props: ['data', 'type', 'date', 'timestamp', 'group'],
    data () {
        return {
            showUpdateInfoButton: false,
            sendingInfoUpdate: false,
            updatedInfo: {},
            info: this.type === 'prototype' ? this.setInitialInfo() : null,
        }
    },
    computed: {
        vouchersNotEmpty () {
            return this.count(this.data) > 0;
        },
        vouchersEmpty () {
            return ! this.vouchersNotEmpty;
        },
    },
    watch: {
        data: {
            handler (value) {
               this.setInitialInfo();
            },
            deep: true,
        },
    },
    methods: {
        showActionModal (index, item) {
            if (! this.can('administerReports')) return;
            switch (index) {
                case 'rush':
                    break;
                case 'production':
                    break;
                case 'late':
                    break;
                case 'new':
                    break;
                default:
                    this.$modal.show('voucherActions', {
                        type: index,
                        voucher: item,
                    });
                    break;
            }
        },
        addVoucher () {
            if (! this.can('administerReports')) {
                this.$page.warning.warning = 'Only administrators may add new vouchers.';

                return;
            }
            this.$modal.show('newVoucher', {
                created: this.date,
            });

            this.hideDropdown();
        },
        prepareToRecordInfo (event) {
            this.updatedInfo[parseInt(event.target.id)] = this.info[event.target.id];
            if (! this.showUpdateInfoButton) {
                this.showUpdateInfoButton = true;
            }
        },
        setInitialInfo () {
            let info = {};
            map(this.data, voucher => {
                info[voucher.id] = voucher.info;
            });

            return info;
        },
        setNewInfo (event) {
            const key = parseInt(event.target.id);
            const voucher = this.firstWhere(this.data, ['id', key]);
            let currentValue = this.updatedInfo[key];
            let newValue = event.target.value;

            if (newValue === voucher.info && this.contains(this.updatedInfo, key)) {
                delete this.updatedInfo[key];
            } else if (newValue != voucher.info && newValue != currentValue) {
                this.updatedInfo[key] = newValue;
            }

            if (this.count(this.updatedInfo) === 0) {
                this.showUpdateInfoButton = false;
            }
        },
        batchUpdateInfo () {
            if (this.count(this.updatedInfo) > 0) {
                this.sendingInfoUpdate = true;
                this.$inertia.post(
                    this.route('orders.info.batch.update'),
                    { info: this.updatedInfo, date: this.timestamp },
                    { replace: false, preserveScroll: true, preserveState: true }).then( () => {
                        this.sendingInfoUpdate = false;
                        this.showUpdateInfoButton = false;
                    });
            }
        },
        fontColor (type, item) {
            if (type === 'prototype' && item.art_complete) {
                return 'text-green-400';
            }

            return 'text-gray-800';
        },
        shortDate (date) {
            return moment(date).format('MM-DD');
        },
    },
}
</script>
