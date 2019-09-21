<template>
    <layout :title="displayDate(date)">
        <!-- Reports Summary for Production and Prototype -->
        <div class="flex flex-col md:flex-row -px-4 w-full mb-8">
            <div v-for="(data, index) in summary" :key="index" class="mr-4 last-child:mr-0 mb-4 md:mb-0 w-full md:w-1/2">
                <report-summary :type="index" :data="data" :timestamp="timestamp" />
            </div>
        </div>
    </layout>
</template>

<script>
import moment from 'moment';
import Layout from '@/Shared/Layout.vue';
import ReportSummary from '@/Partials/Reports/ReportSummary.vue';

export default {
    components: {
        Layout,
        ReportSummary,
    },
    props: ['summary', 'date', 'timestamp'],
    methods: {
        displayDate (date) {
            return moment(date).format('MM-DD-YYYY h:mm a');
        },
    },
}
</script>
