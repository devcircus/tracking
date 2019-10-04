<template>
    <layout title="Home">
        <div v-if="reports">
            <div class="rounded shadow overflow-x-auto hidden md:block">
                <table class="w-full whitespace-no-wrap">
                    <tr class="bg-blue-900 text-left">
                        <th class="text-white font-bold px-6 pt-6 pb-4">Report Created</th>
                        <th class="text-white font-bold px-6 pt-6 pb-4">New</th>
                        <th class="text-white font-bold px-6 pt-6 pb-4">Rush</th>
                        <th class="text-white font-bold px-6 pt-6 pb-4">Late</th>
                        <th class="text-white font-bold px-6 pt-6 pb-4">PTs</th>
                        <th class="text-white font-bold px-6 pt-6 pb-4">34</th>
                        <th class="text-white font-bold px-6 pt-6 pb-4">PX</th>
                        <th class="text-white font-bold px-6 pt-6 pb-4">SP</th>
                        <th class="text-white font-bold px-6 pt-6 pb-4">RF</th>
                        <th class="text-white font-bold px-6 pt-6 pb-4">Bags</th>
                        <th class="text-white font-bold px-6 pt-6 pb-4">HJ</th>
                        <th class="text-white font-bold px-6 pt-6 pb-4">&nbsp;</th>
                    </tr>
                    <tr v-if="inProgress" class="bg-white hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t" colspan="9">
                            <span class="px-6 py-4 text-green-600 font-semibold">Report generation started. Data will refresh shortly...</span>
                            <img class="inline-block py-4" src="images/loader-on-white.gif" />
                        </td>
                    </tr>
                    <tr v-for="report in reports" :key="report.timestamp" class="bg-white hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            <inertia-link class="px-6 py-4 flex items-center focus:text-blue-500 font-semibold" :href="route('reports.comprehensive.show', report.timestamp)">
                                {{ displayDate(report.date) }}
                                <icon v-if="report.deleted_at" name="trash" class="flex-no-shrink w-3 h-3 fill-gray-500 ml-2" />
                            </inertia-link>
                        </td>
                        <td class="border-t">
                            <inertia-link class="px-6 py-4 flex items-center" :href="route('reports.comprehensive.show', report.timestamp)" tabindex="-1">
                                {{ report.quantities.new }}
                            </inertia-link>
                        </td>
                        <td class="border-t">
                            <inertia-link class="px-6 py-4 flex items-center" :href="route('reports.comprehensive.show', report.timestamp)" tabindex="-1">
                                {{ report.quantities.rush }}
                            </inertia-link>
                        </td>
                        <td class="border-t">
                            <inertia-link class="px-6 py-4 flex items-center" :href="route('reports.comprehensive.show', report.timestamp)" tabindex="-1">
                                {{ report.quantities.late }}
                            </inertia-link>
                        </td>
                        <td class="border-t">
                            <inertia-link class="px-6 py-4 flex items-center" :href="route('reports.comprehensive.show', report.timestamp)" tabindex="-1">
                                {{ report.quantities.prototype }}
                            </inertia-link>
                        </td>
                        <td class="border-t">
                            <inertia-link class="px-6 py-4 flex items-center" :href="route('reports.comprehensive.show', report.timestamp)" tabindex="-1">
                                {{ report.quantities.ninas }}
                            </inertia-link>
                        </td>
                        <td class="border-t">
                            <inertia-link class="px-6 py-4 flex items-center" :href="route('reports.comprehensive.show', report.timestamp)" tabindex="-1">
                                {{ report.quantities.px }}
                            </inertia-link>
                        </td>
                        <td class="border-t">
                            <inertia-link class="px-6 py-4 flex items-center" :href="route('reports.comprehensive.show', report.timestamp)" tabindex="-1">
                                {{ report.quantities.sp }}
                            </inertia-link>
                        </td>
                        <td class="border-t">
                            <inertia-link class="px-6 py-4 flex items-center" :href="route('reports.comprehensive.show', report.timestamp)" tabindex="-1">
                                {{ report.quantities.rf }}
                            </inertia-link>
                        </td>
                        <td class="border-t">
                            <inertia-link class="px-6 py-4 flex items-center" :href="route('reports.comprehensive.show', report.timestamp)" tabindex="-1">
                                {{ report.quantities.bag }}
                            </inertia-link>
                        </td>
                        <td class="border-t">
                            <inertia-link class="px-6 py-4 flex items-center" :href="route('reports.comprehensive.show', report.timestamp)" tabindex="-1">
                                {{ report.quantities.hj }}
                            </inertia-link>
                        </td>
                        <td class="border-t w-px">
                            <inertia-link class="px-4 flex items-center" :href="route('reports.comprehensive.show', report.timestamp)" tabindex="-1">
                                <icon-base icon-fill="fill-gray-500" classes="ml-2">
                                    <cheveron-right />
                                </icon-base>
                            </inertia-link>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="flex flex-col md:hidden -px-6">
                <div class="flex mb-4 bg-gray-400 border-b-4 border-blue-500 px-4 py-4">
                    <div v-for="date in results.data" :key="date.date" class="flex flex-col mr-2 cursor-pointer items-center" :class="accentDate(date.date)" @click="setCurrentDate(date.date)">
                        <span class="text-xs uppercase mb-1">
                            {{ getDayOfWeek(date.date) }}
                        </span>
                        <span class="uppercase">
                            {{ getDay(date.date) }}
                        </span>
                    </div>
                </div>
                <div class="flex flex-col w-full ">
                    <inertia-link :href="route('reports.comprehensive.show', results.data[currentDate].timestamp)">
                        <div v-for="(quantity, key) in results.data[currentDate].quantities" :key="key" class="flex justify-between p-4 border-b-2 border-gray-400">
                            <span class="text-base font-semibold text-gray-800 uppercase">{{ key | ucase }}:</span>
                            <span class="text-lg font-semibold text-gray-600">{{ quantity }}</span>
                        </div>
                    </inertia-link>
                </div>
            </div>
        </div>
        <div v-else>
            <div v-if="inProgress">
                <span class="border-t px-6 py-4 w-full">Generating New Report. Data will refresh shortly...</span>
                <img class="inline-block py-4" src="images/loader-on-gray.gif" />
            </div>
            <span v-else class="border-t px-6 py-4 w-full">No reports found.</span>
        </div>
        <pagination :links="results.links" :full-width="false" />
    </layout>
</template>

<script>
import axios from 'axios';
import moment from 'moment';
import Layout from '@/Shared/Layout';
import IconBase from '@/Shared/IconBase';
import Pagination from '@/Shared/Pagination';
import InboxFull from '@/Shared/Icons/InboxFull';
import CheveronRight from '@/Shared/Icons/CheveronRight';

export default {
    components: {
        Layout,
        IconBase,
        InboxFull,
        Pagination,
        CheveronRight,
    },
    props: ['results'],
    data () {
        return {
            file: null,
            reports: null,
            currentDate: null,
            loading: false,
            errorBag: 'upload',
            errorField: 'upload',
            inProgress: false,
        }
    },
    created () {
        if (this.results.data.length > 0 || Object.keys(this.results.data).length > 0) {
            this.reports = this.results.data;
            this.currentDate = this.results.data[Object.keys(this.results.data)[0]].date;
        }
        axios.get(this.route('uploads.check')).then(response => {
            this.inProgress = response.data.uploading;
        });
        this.$listen('reportsCreated', () => {
            this.$inertia.visit(this.route('reports.list'), { method: 'get', data: {}, preserveScroll: false, preserveState: false }).then(() => {
                this.inProgress = false;
            });
        });
    },
    methods: {
        uploadFile () {
            if (! this.file) return;

            this.loading = true;

            let formData = new FormData();
            formData.append('upload', this.file);

            this.$inertia.post(this.route('uploads.store'), formData).then(() => {
                this.file = null;
                this.loading = false;
            });
        },
        getDayOfWeek (date) {
            return moment(date).format('ddd');
        },
        getDay (date) {
            return moment(date).format('D');
        },
        setCurrentDate (date) {
            this.currentDate = date;
        },
        displayDate (date) {
            return moment(date).format('MM-DD-YYYY h:mm A');
        },
        accentDate (date) {
            return date === this.currentDate ? 'font-bold text-blue-800 text-2xl' : 'font-semibold text-blue-500 text-lg';
        },
    },
}
</script>
