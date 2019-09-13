<template>
    <vue-good-table ref="table"
                    class="mb-8"
                    :columns="fabricColumns"
                    :rows="fabrics"
                    :pagination-options="fabricPaginationOptions"
                    :search-options="fabricSearchOptions"
                    :sort-options="fabricSortOptions"
                    @on-row-click="showFabric"
    >
        <div slot="emptystate">
            No fabrics found.
        </div>
        <div slot="table-actions" class="flex justify-between">
            <span class="text-blue-500 text-sm font-semibold leading-loose mr-2 inline-block mt-tenth cursor-pointer" @click="clearSearch()">Clear</span>
        </div>
    </vue-good-table>
</template>

<script>
import { VueGoodTable } from 'vue-good-table';

export default {
    components: {
        VueGoodTable,
    },
    props: ['fabrics'],
    store: ['fabricColumns', 'fabricSortOptions', 'fabricPaginationOptions', 'fabricSearchOptions'],
    methods: {
        showFabric (params) {
            this.$inertia.visit(this.route('fabrics.show', params.row.id));
        },
        clearSearch () {
            this.$refs['table'].globalSearchTerm = '';
        },
    },
}
</script>
