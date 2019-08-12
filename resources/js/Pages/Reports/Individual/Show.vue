<template>
    <layout :title="type">
        <h1 class="mb-8 font-bold text-xl md:text-2xl">
            <inertia-link class="text-blue-500 hover:text-blue-800 uppercase" :href="route('dashboard')">Reports</inertia-link>
            <span class="text-blue-800 text-2xl md:text-3xl font-medium">/</span>
            <inertia-link class="text-blue-500 hover:text-blue-800" :href="route('reports.comprehensive.show', timestamp)">{{ displayDate(date) }}</inertia-link>
            <span class="text-blue-800 text-2xl md:text-3xl font-medium">/</span>
            <span class="text-blue-800 text-2xl md:text-3xl">{{ type | ucase }}</span>
        </h1>

        <individual-report :data="report" :type="type" :timestamp="timestamp" :group="false" />
    </layout>
</template>

<script>
import moment from 'moment-timezone';
import Layout from '@/Shared/Layout';
import { InertiaLink } from 'inertia-vue';
import IndividualReport from '@/Partials/IndividualReport';

export default {
    components: {
        Layout,
        InertiaLink,
        IndividualReport,
    },
    props: {
        report: Array,
        date: String,
        timestamp: Number,
        type: String,
    },
    methods: {
        displayDate (date) {
            return moment(date).format('MM-DD-YYYY h:mm a');
        },
    },
}
</script>
