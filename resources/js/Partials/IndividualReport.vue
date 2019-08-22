<template>
    <div class="relative">
        <loading-button v-if="showUpdateInfoButton" class="btn btn-blue fixed bottom-0 right-0 mb-4 mr-4" type="button" :loading="sendingInfoUpdate" @clicked="batchUpdateInfo()">Batch Update</loading-button>
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
                    Info
                </span>
            </div>
            <template v-if="notEmpty">
                <div v-for="item in data" :key="item.id" class="flex flex-wrap justify-between border-l border-r border-b border-blue-300 p-4 hover:bg-gray-300 cursor-pointer" @click.prevent.stop="showActionModal(type, item)">
                    <span class="w-120 md:w-200p text-base font-normal" :class="type === 'prototype' && item.art_complete ? 'text-green-700 font-semibold' : 'text-gray-800'">
                        {{ shortDate(item.schedule_date) }}
                    </span>
                    <span class="hidden md:block w-200p text-base font-normal" :class="type === 'prototype' && item.art_complete ? 'text-green-700 font-semibold' : 'text-gray-800'">
                        {{ item.order_number }}
                    </span>
                    <span class="block md:hidden w-140 text-base font-normal" :class="type === 'prototype' && item.art_complete ? 'text-green-700 font-semibold' : 'text-gray-800'">
                        {{ item.order_number }} - {{ item.voucher }}
                    </span>
                    <span class="hidden md:block w-200p text-base font-normal" :class="type === 'prototype' && item.art_complete ? 'text-green-700 font-semibold' : 'text-gray-800'">
                        {{ item.voucher }}
                    </span>
                    <span class="hidden md:block w-300p text-base font-normal" :class="type === 'prototype' && item.art_complete ? 'text-green-700 font-semibold' : 'text-gray-800'">
                        {{ item.customer }}
                    </span>
                    <span class="hidden md:block flex-1 text-base font-normal" :class="type === 'prototype' && item.art_complete ? 'text-green-700 font-semibold' : 'text-gray-800'">
                        {{ item.style }}
                    </span>
                    <div v-if="type === 'prototype' && $page.auth.user.is_admin" class="hidden md:block flex-1 text-base text-gray-800 font-normal" @click.stop>
                        <input :id="`${item.id}`"
                               v-model="info[item.id]"
                               class="border border-blue text-sm p-1 w-full"
                               type="text"
                               name="info"
                               @focus="prepareToRecordInfo"
                               @blur="setNewInfo"
                        >
                    </div>
                    <span v-else-if="type === 'prototype'" class="flex-1 text-sm text-gray-800 font-normal" :class="item.info === 'COMPLETE' ? 'text-blue-500' : 'text-red-500'">
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
import { map } from 'lodash';
import moment from 'moment-timezone';
import Dropdown from '@/Shared/Dropdown.vue';
import LoadingButton from '@/Shared/LoadingButton.vue';

export default {
    components: { Dropdown, LoadingButton },
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
        notEmpty () {
            return this.data.length > 0;
        },
        isEmpty () {
            return ! this.notEmpty;
        },
    },
    methods: {
        shortDate (date) {
            return moment.utc(date).format('MM-DD');
        },
        showActionModal (index, item) {
            if (! this.$page.auth.user.is_admin) return;
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
            if (! this.$page.auth.user.is_admin) {
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
            const voucher = this.$collection(this.data).where('id', key).first();
            let currentValue = this.updatedInfo[key];
            let newValue = event.target.value;

            if (newValue === voucher.info && this.$collection(this.updatedInfo).has(key)) {
                delete this.updatedInfo[key];
            } else if (newValue != voucher.info && newValue != currentValue) {
                this.updatedInfo[key] = newValue;
            }

            if (this.$collection(this.updatedInfo).count() === 0) {
                this.showUpdateInfoButton = false;
            }
        },
        batchUpdateInfo () {
            if (this.$collection(this.updatedInfo).count() > 0) {
                this.sendingInfoUpdate = true;
                this.$inertia.post(this.route('info.batch.update'), { info: this.updatedInfo }).then( () => {
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
    },
}
</script>
