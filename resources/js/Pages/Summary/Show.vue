<template>
    <layout :title="displayDate(date)">
        <div class="w-full md:w-4/5 mx-auto container">
            <h1 class="mb-8 font-bold text-xl md:text-2xl">
                <inertia-link class="text-blue-500 hover:text-blue-800 uppercase" :href="route('dashboard')">Reports</inertia-link>
                <span class="text-blue-500 text-2xl md:text-3xl">/</span>
                <inertia-link class="text-blue-500 hover:text-blue-800" :href="route('reports.comprehensive.show', timestamp)">{{ displayDate(date) }}</inertia-link>
                <span class="text-blue-500 text-2xl md:text-3xl">/</span>
                <span class="text-blue-800" href="#">Summary</span>
            </h1>
        </div>

        <!-- Reports Summary for Production and Prototype -->
        <div class="flex flex-col md:flex-row -px-4 w-full md:w-4/5 md:mx-auto mb-8">
            <div v-for="(data, index) in summary" :key="index" class="mr-4 last-child:mr-0 mb-4 md:mb-0 w-full md:w-1/2">
                <report-summary :type="index" :data="data" :timestamp="timestamp" />
            </div>
        </div>
    </layout>
</template>

<script>
import moment from 'moment';
import Layout from '@/Shared/Layout.vue';
import ReportSummary from '@/Partials/ReportSummary.vue';

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
