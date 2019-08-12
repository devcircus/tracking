<template>
    <div class="flex flex-col w-full md:w-1/3 md:px-2">
        <div class="w-full bg-blue-800 p-4">
            <h1 class="text-white text-lg md:text-xl font-semibold uppercase">Low Inventory</h1>
        </div>
        <div class="bg-white rounded shadow overflow-hidden w-full p-4">
            <vue-good-table :columns="columns" :rows="results" :sort-options="sortOptions" @on-row-click="showItem" />
        </div>
    </div>
</template>

<script>
import { VueGoodTable } from 'vue-good-table';

export default {
    components: { VueGoodTable },
    props: {
        results: Array,
    },
    data () {
        return {
            columns: [
                {
                    field: 'name',
                    label: 'Item',
                    type: 'text',
                    sortable: true,
                },
                {
                    field: 'active_tags_count',
                    label: 'In Stock',
                    type: 'number',
                    sortable: true,
                },
                {
                    field: 'minimum',
                    label: 'Minimum',
                    type: 'number',
                    sortable: true,
                },
            ],
            sortOptions: {
                enabled: true,
                initialSortBy: [
                    { field: 'name', type: 'asc' },
                ],
            },
        }
    },
    methods: {
        showItem (params) {
            this.$inertia.replace(this.route('items.show', params.row.id));
        },
    },
}
</script>

<style>

</style>
