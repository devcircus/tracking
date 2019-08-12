<template>
    <layout title="Home">
        <h1 class="mb-4 font-semibold text-2xl text-gray-800 uppercase">Upload Report</h1>
        <div v-if="$page.auth.user.is_admin" class="mb-6 flex items-center">
            <file-upload v-model="file" class="mr-8" />
            <div v-if="file" class="btn btn-muted" :class="file ? 'cursor-pointer' : 'cursor-not-allowed'" @click="uploadFile()">
                <span>Upload</span>
                <span class="hidden md:inline">Report</span>
            </div>
        </div>
        <div v-else class="mb-8 flex items-center">
            <span class="btn btn-muted cursor-not-allowed">Choose a file</span>
        </div>
        <h1 class="mb-4 font-semibold text-2xl text-gray-800 uppercase">Previous Reports</h1>
        <div v-if="reports">
            <div class="rounded shadow overflow-x-auto hidden md:block">
                <table class="w-full whitespace-no-wrap">
                    <tr class="bg-blue-900 text-left">
                        <th class="text-white font-bold px-6 pt-6 pb-4">Report Created</th>
                        <th class="text-white font-bold px-6 pt-6 pb-4">New</th>
                        <th class="text-white font-bold px-6 pt-6 pb-4">Rush</th>
                        <th class="text-white font-bold px-6 pt-6 pb-4">Late</th>
                        <th class="text-white font-bold px-6 pt-6 pb-4">Prototypes</th>
                        <th class="text-white font-bold px-6 pt-6 pb-4">Production</th>
                        <th class="text-white font-bold px-6 pt-6 pb-4">Bags</th>
                        <th class="text-white font-bold px-6 pt-6 pb-4">Total</th>
                        <th class="text-white font-bold px-6 pt-6 pb-4">&nbsp;</th>
                    </tr>
                    <tr v-for="report in reports" :key="report.timestamp" class="bg-white hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            <inertia-link class="px-6 py-4 flex items-center focus:text-blue-500 font-semibold" :href="route('reports.comprehensive.show', report.timestamp)">
                                {{ report.date_string }}
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
                                {{ report.quantities.production }}
                            </inertia-link>
                        </td>
                        <td class="border-t">
                            <inertia-link class="px-6 py-4 flex items-center" :href="route('reports.comprehensive.show', report.timestamp)" tabindex="-1">
                                {{ report.quantities.bag }}
                            </inertia-link>
                        </td>
                        <td class="border-t">
                            <inertia-link class="px-6 py-4 flex items-center" :href="route('reports.comprehensive.show', report.timestamp)" tabindex="-1">
                                {{ report.quantities.total }}
                            </inertia-link>
                        </td>
                        <td class="border-t w-px">
                            <inertia-link class="px-4 flex items-center" :href="route('reports.comprehensive.show', report.timestamp)" tabindex="-1">
                                <icon name="cheveron-right" class="block w-6 h-6 fill-gray-500" />
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
            <span class="border-t px-6 py-4 w-full">No reports found.</span>
        </div>
        <pagination :links="results.links" :full-width="false" />
    </layout>
</template>

<script>
import axios from 'axios';
import moment from 'moment';
import Icon from '@/Shared/Icon';
import Layout from '@/Shared/Layout';
import Pagination from '@/Shared/Pagination';
import FileUpload from '@/Shared/FileUpload';

export default {
    components: {
        Layout,
        FileUpload,
        Icon,
        Pagination,
    },
    props: ['results'],
    data () {
        return {
            file: null,
            reports: null,
            currentDate: null,
        }
    },
    created () {
        if (this.results.data.length > 0 || Object.keys(this.results.data).length > 0) {
            this.reports = this.results.data;
            this.currentDate = this.results.data[Object.keys(this.results.data)[0]].date;
        }
    },
    methods: {
        uploadFile () {
            if (! this.file) return;

            this.$modal.show('fetching');
            this.$modal.show('uploading');

            let formData = new FormData();
            formData.append('upload', this.file);

            axios.post(this.route('uploads.store'), formData)
            .then((response) => {
                this.file = null;
                this.$modal.hide('uploading');
            });
        },
        to_timestamp (date) {
            return  moment.utc(date).unix();
        },
        getDayOfWeek (date) {
            return moment.utc(date).format('ddd');
        },
        getDay (date) {
            return moment.utc(date).format('D');
        },
        setCurrentDate (date) {
            this.currentDate = date;
        },
        accentDate (date) {
            return date === this.currentDate ? 'font-bold text-blue-800 text-2xl' : 'font-semibold text-blue-500 text-lg';
        },
    },
}
</script>
