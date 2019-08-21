<template>
    <layout :title="displayDate(date)">
        <div class="w-full md:w-4/5 mx-auto">
            <h1 class="mb-8 font-bold text-xl md:text-2xl">
                <inertia-link class="text-blue-500 hover:text-blue-800 uppercase" :href="route('dashboard')">Artists Report</inertia-link>
                <span class="text-blue-500 text-2xl md:text-3xl">/</span>
                <span class="text-blue-800 text-lg md:text-xl" href="#">{{ displayDate(date) }}</span>
            </h1>
        </div>

        <!-- Artists Report -->
        <div class="flex flex-col -px-4 w-full md:w-4/5 md:mx-auto mb-8">
            <artists-report :vouchers="results" type="prototype" :date="date" :timestamp="timestamp" :group="true" />
        </div>
    </layout>
</template>

<script>
import moment from 'moment-timezone';
import Layout from '@/Shared/Layout';
import { InertiaLink } from '@inertiajs/inertia-vue';
import ArtistsReport from '@/Partials/Reports/ArtistsReport';

export default {
    components: {
        Layout,
        InertiaLink,
        ArtistsReport,
    },
    props: {
        results: Array,
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
