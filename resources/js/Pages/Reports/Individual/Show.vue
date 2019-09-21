<template>
    <layout :title="type">
        <individual-report :data="report" :type="type" :timestamp="timestamp" :group="false" />
    </layout>
</template>

<script>
import moment from 'moment';
import Layout from '@/Shared/Layout';
import IndividualReport from '@/Partials/Reports/IndividualReport';

export default {
    components: {
        Layout,
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
