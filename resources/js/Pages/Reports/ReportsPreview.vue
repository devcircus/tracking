<template>
    <div class="flex flex-col w-full lg:w-2/3">
        <div class="w-full bg-blue-800 p-4">
            <h1 class="text-white text-lg lg:text-xl font-semibold uppercase">Sublimation Reports</h1>
        </div>
        <div class="bg-white rounded shadow overflow-hidden w-full py-4">
            <div class="px-4">
                <h1 class="mb-4 font-semibold text-lg text-gray-800 uppercase">Upload Report</h1>
                <div v-if="$page.auth.user.is_admin" class="mb-6 flex items-center">
                    <file-upload v-model="file" class="mr-8" prompt="Select" button-classes="btn-sm" />
                    <loading-button v-if="file" :loading="loading" type="button" class="btn btn-blue btn-sm" :class="file ? 'cursor-pointer' : 'cursor-not-allowed btn-muted'" @clicked="uploadFile()">
                        Upload
                    </loading-button>
                </div>
                <div v-else class="mb-8 flex items-center">
                    <span class="btn btn-muted cursor-not-allowed">Choose a file</span>
                </div>
            </div>
            <div class="pt-4">
                <div v-if="reports">
                    <div class="shadow overflow-x-auto hidden lg:block">
                        <table class="w-full whitespace-no-wrap">
                            <tr class="bg-blue-300 text-left uppercase">
                                <th class="text-blue-900 font-bold px-6 pt-6 pb-4">Report Created</th>
                                <th class="text-blue-900 font-bold px-6 pt-6 pb-4">New</th>
                                <th class="text-blue-900 font-bold px-6 pt-6 pb-4">Rush</th>
                                <th class="text-blue-900 font-bold px-6 pt-6 pb-4">Late</th>
                                <th class="text-blue-900 font-bold px-6 pt-6 pb-4">Prototypes</th>
                                <th class="text-blue-900 font-bold px-6 pt-6 pb-4">Production</th>
                                <th class="text-blue-900 font-bold px-6 pt-6 pb-4">Bags</th>
                                <th class="text-blue-900 font-bold px-6 pt-6 pb-4">Total</th>
                                <th class="text-blue-900 font-bold px-6 pt-6 pb-4">&nbsp;</th>
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
                    <div class="flex flex-col lg:hidden -px-6">
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
                    <span class="text-base text-gray-800 font-semibold uppercase p-4 w-full">No reports found.</span>
                </div>
                <pagination v-if="reports" :links="results.links" :full-width="false" />
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment';
import Icon from '@/Shared/Icon';
import Pagination from '@/Shared/Pagination';
import FileUpload from '@/Shared/FileUpload';
import LoadingButton from '@/Shared/LoadingButton';
import WatchesForErrors from 'Mixins/WatchesForErrors';

export default {
    components: {
        FileUpload,
        Icon,
        Pagination,
        LoadingButton,
    },
    mixins: [ WatchesForErrors ],
    props: ['results'],
    data () {
        return {
            file: null,
            reports: null,
            currentDate: null,
            loading: false,
            errorBag: 'upload',
            errorField: 'upload',
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
        displayDate (date) {
            return moment(date).format('MM-DD-YYYY h:mm A');
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
