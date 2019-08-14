<template>
    <layout :title="displayDate(date)">
        <div class="w-full md:w-4/5 mx-auto">
            <h1 class="mb-8 font-bold text-xl md:text-2xl">
                <inertia-link class="text-blue-500 hover:text-blue-800 uppercase" :href="route('dashboard')">Reports</inertia-link>
                <span class="text-blue-500 text-2xl md:text-3xl">/</span>
                <span class="text-blue-800" href="#">{{ displayDate(date) }}</span>
            </h1>
        </div>

        <!-- Reports Summary for Production and Prototype -->
        <div class="flex flex-col md:flex-row -px-4 w-full md:w-4/5 md:mx-auto mb-8">
            <div v-for="(data, index) in results.summary" :key="index" class="mr-4 last-child:mr-0 mb-4 md:mb-0 w-full md:w-1/2">
                <report-summary :type="index" :data="data" :timestamp="timestamp" :group="true" />
            </div>
        </div>

        <!-- Individual Report -->
        <div class="flex flex-col -px-4 w-full md:w-4/5 md:mx-auto mb-8">
            <div v-for="(report, index) in results.reports" :key="index" class="mr-4 w-full mb-8">
                <individual-report :data="report" :type="index" :date="date" :timestamp="timestamp" :group="true" />
            </div>
        </div>
    </layout>
</template>

<script>
import moment from 'moment-timezone';
import Layout from '@/Shared/Layout';
import { InertiaLink } from '@inertiajs/inertia-vue';
import ReportSummary from '@/Partials/ReportSummary';
import IndividualReport from '@/Partials/IndividualReport';

export default {
    components: {
        Layout,
        InertiaLink,
        ReportSummary,
        IndividualReport,
    },
    props: {
        results: Object,
        date: String,
        timestamp: Number,
    },
    methods: {
        displayDate (date) {
            return moment.utc(date).format('MM-DD-YYYY h:mm a');
        },
    },
}
</script>
