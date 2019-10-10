<template>
    <div class="flex flex-col w-full lg:w-2/3">
        <div class="w-full flex bg-blue-800 p-4">
            <h1 class="text-white text-lg lg:text-xl font-semibold uppercase">Sublimation Reports</h1>
            <icon-base icon-fill="fill-white" icon-name="inbox-full" classes="ml-2">
                <inbox-full />
            </icon-base>
        </div>
        <div class="bg-white rounded shadow overflow-hidden w-full py-4">
            <div class="px-4">
                <h1 class="mb-4 font-semibold text-lg text-gray-800 uppercase">Upload Report</h1>
                <div v-if="$page.auth.user.can.administerReports" class="mb-6 flex items-center">
                    <file-upload v-model="file" class="mr-8" prompt="Choose a file" button-classes="btn">
                        <icon-base view="24 24" icon-fill="fill-white" icon-name="folder-add" classes="mr-2 flex-no-shrink">
                            <folder-add />
                        </icon-base>
                    </file-upload>
                    <loading-button v-if="file" :loading="loading" type="button" class="flex btn btn-blue" :class="file ? 'cursor-pointer' : 'cursor-not-allowed btn-muted'" @clicked="uploadFile()">
                        <icon-base icon-fill="fill-white" icon-name="cloud-upload" classes="mr-2 flex-no-shrink">
                            <cloud-upload />
                        </icon-base>
                        Upload
                    </loading-button>
                </div>
                <div v-else class="mb-8 flex items-center">
                    <span class="flex btn btn-muted cursor-not-allowed">
                        <icon-base icon-fill="fill-gray-800" icon-name="folder-add" classes="mr-2 flex-no-shrink">
                            <folder-add />
                        </icon-base>
                        Choose a file
                    </span>
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
                                <th class="text-blue-900 font-bold px-6 pt-6 pb-4">PTs</th>
                                <th class="hidden xl:table-cell text-blue-900 font-bold px-6 pt-6 pb-4">34</th>
                                <th class="hidden xl:table-cell text-blue-900 font-bold px-6 pt-6 pb-4">PX</th>
                                <th class="hidden xl:table-cell text-blue-900 font-bold px-6 pt-6 pb-4">SP</th>
                                <th class="hidden xl:table-cell text-blue-900 font-bold px-6 pt-6 pb-4">RF</th>
                                <th class="hidden xl:table-cell text-blue-900 font-bold px-6 pt-6 pb-4">Bags</th>
                                <th class="hidden xl:table-cell text-blue-900 font-bold px-6 pt-6 pb-4">HJ</th>
                                <th class="text-blue-900 font-bold px-6 pt-6 pb-4">&nbsp;</th>
                            </tr>
                            <tr v-for="report in reports" :key="report.timestamp" class="bg-white hover:bg-gray-100 focus-within:bg-gray-100 cursor-pointer" @click.stop="showReport(report.timestamp)">
                                <td class="border-t px-6 py-4">
                                    <span class="flex items-center focus:text-blue-500 font-semibold">
                                        {{ displayDate(report.date) }}
                                        <icon v-if="report.deleted_at" name="trash" class="flex-no-shrink w-3 h-3 fill-gray-500 ml-2" />
                                    </span>
                                </td>
                                <td class="border-t px-6 py-4">
                                    <span class="flex items-center" tabindex="-1">
                                        {{ report.quantities.new }}
                                    </span>
                                </td>
                                <td class="border-t px-6 py-4">
                                    <span class="flex items-center" tabindex="-1">
                                        {{ report.quantities.rush }}
                                    </span>
                                </td>
                                <td class="border-t px-6 py-4">
                                    <span class="flex items-center" tabindex="-1">
                                        {{ report.quantities.late }}
                                    </span>
                                </td>
                                <td class="border-t px-6 py-4">
                                    <span class="flex items-center" tabindex="-1">
                                        {{ report.quantities.prototype }}
                                    </span>
                                </td>
                                <td class="hidden xl:table-cell border-t px-6 py-4">
                                    <span class="flex items-center" tabindex="-1">
                                        {{ report.quantities.ninas }}
                                    </span>
                                </td>
                                <td class="hidden xl:table-cell border-t px-6 py-4">
                                    <span class="flex items-center" tabindex="-1">
                                        {{ report.quantities.px }}
                                    </span>
                                </td>
                                <td class="hidden xl:table-cell border-t px-6 py-4">
                                    <span class="flex items-center" tabindex="-1">
                                        {{ report.quantities.sp }}
                                    </span>
                                </td>
                                <td class="hidden xl:table-cell border-t px-6 py-4">
                                    <span class="flex items-center" tabindex="-1">
                                        {{ report.quantities.rf }}
                                    </span>
                                </td>
                                <td class="hidden xl:table-cell border-t px-6 py-4">
                                    <span class="flex items-center" tabindex="-1">
                                        {{ report.quantities.bag }}
                                    </span>
                                </td>
                                <td class="hidden xl:table-cell border-t px-6 py-4">
                                    <span class="flex items-center" tabindex="-1">
                                        {{ report.quantities.hj }}
                                    </span>
                                </td>
                                <td class="border-t w-px">
                                    <span class="px-4 flex items-center" tabindex="-1">
                                        <icon-base view="24 24" icon-fill="fill-gray-500" classes="ml-2">
                                            <cheveron-right />
                                        </icon-base>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="flex flex-col lg:hidden -px-6">
                        <div class="flex justify-center mb-4 bg-gray-400 border-b-4 border-blue-500 px-4 py-4">
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
import IconBase from '@/Shared/IconBase';
import Pagination from '@/Shared/Pagination';
import FileUpload from '@/Shared/FileUpload';
import InboxFull from '@/Shared/Icons/InboxFull';
import FolderAdd from '@/Shared/Icons/FolderAdd';
import LoadingButton from '@/Shared/LoadingButton';
import CloudUpload from '@/Shared/Icons/CloudUpload';
import WatchesForErrors from 'Mixins/WatchesForErrors';
import CheveronRight from '@/Shared/Icons/CheveronRight';

export default {
    components: {
        IconBase,
        InboxFull,
        FolderAdd,
        Pagination,
        FileUpload,
        CloudUpload,
        LoadingButton,
        CheveronRight,
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
        showReport (timestamp) {
            this.$inertia.visit(this.route('reports.comprehensive.show', timestamp));
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
