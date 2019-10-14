<template>
    <layout :title="displayDate(date)">
        <div class="flex flex-col -px-4 w-full mx-auto mb-8">
            <artists-report :vouchers="report" type="prototype" :date="date" :timestamp="timestamp" :group="true" />
        </div>
    </layout>
</template>

<script>
import moment from 'moment';
import Layout from '@/Shared/Layout';
import ArtistsReport from '@/Partials/Reports/ArtistsReport';

export default {
    components: {
        Layout,
        ArtistsReport,
    },
    props: {
        report: Array,
        date: String,
        timestamp: Number,
    },
    methods: {
        displayDate (date) {
            return moment(date).format('MM-DD-YYYY h:mm a');
        },
    },
}
</script>
