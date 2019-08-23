<template>
    <layout title="Activities">
        <div class="w-full bg-blue-800 p-4">
            <h1 class="text-white text-lg md:text-xl font-semibold uppercase">Activity Log</h1>
        </div>
        <div>
            <vue-good-table ref="table" class="mb-8" :columns="activityColumns" :rows="rows" :pagination-options="activityPaginationOptions" :search-options="activitySearchOptions" :sort-options="activitySortOptions">
                <div slot="emptystate">
                    No activities found.
                </div>
            </vue-good-table>
        </div>
    </layout>
</template>

<script>
import Layout from '@/Shared/Layout';
import { VueGoodTable } from 'vue-good-table';

export default {
    components: {
        Layout,
        VueGoodTable,
    },
    props: ['activities'],
    store: ['activityColumns', 'activitySortOptions', 'activityPaginationOptions', 'activitySearchOptions'],
    computed: {
        rows () {
            return this.activities;
        },
    },
    watch: {
        windowWidth (value) {
            // if (`value < 768) {
            //     this.$set(this.activityColumns[2], 'hidden', true);
            //     this.$set(this.activityColumns[3], 'hidden', true);
            //     this.$set(this.activityColumns[4], 'tdClass', 'text-sm');
            // } else {
            //     this.$set(this.activityColumns[2], 'hidden', false);
            //     this.$set(this.activityColumns[3], 'hidden', false);
            //     this.$set(this.activityColumns[4], 'tdClass', 'text-base');
            // }`
        },
    },
    methods: {
        clearSearch () {
            this.$refs['table'].globalSearchTerm = '';
        },
    },
}
</script>
