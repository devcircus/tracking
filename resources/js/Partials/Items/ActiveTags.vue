<template>
    <div class="flex flex-col">
        <div class="w-full bg-blue-800 p-4">
            <h1 class="text-white text-lg md:text-xl font-semibold uppercase">Current Inventory</h1>
        </div>
        <vue-good-table ref="table" class="mb-8" :columns="tagColumns" :rows="rows" :pagination-options="paginationOptions" :search-options="searchOptions">
            <div slot="emptystate">
                No inventory for {{ item.name }}.
            </div>
        </vue-good-table>
    </div>
</template>

<script>
import { VueGoodTable } from 'vue-good-table';

export default {
    components: {
        VueGoodTable,
    },
    props: {
        item: {
            type: Object,
        },
    },
    data () {
        return {
            tagColumns: [
                {
                    field: 'package_number',
                    label: 'Package Number',
                    type: 'number',
                    tdClass: 'text-left',
                    thClass: 'text-left',
                },
                {
                    field: 'item.name',
                    label: 'Item',
                    type: 'text',
                },
                {
                    field: 'received_at',
                    label: 'Received',
                    type: 'date',
                    dateInputFormat: 'yyyy-LL-dd',
                    dateOutputFormat: 'yyyy-LL-dd',
                },
            ],
            rows: this.item.active_tags,
            paginationOptions: {
                enabled: true,
                mode: 'pages',
                perPage: 8,
                dropdownAllowAll: true,
                nextLabel: 'next',
                prevLabel: 'prev',
                rowsPerPageLabel: 'Records per page',
                ofLabel: 'of',
                pageLabel: 'page',
                allLabel: 'All',
            },
            searchOptions: {
                enabled: true,
                placeholder: 'Search active tags...',
            },
        }
    },
}
</script>
