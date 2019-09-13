<template>
    <vue-good-table ref="table"
                    class="mb-8"
                    :columns="colorColumns"
                    :rows="colors"
                    :pagination-options="colorPaginationOptions"
                    :search-options="colorSearchOptions"
                    :sort-options="colorSortOptions"
                    @on-row-click="showColor"
    >
        <div slot="emptystate">
            No colors found.
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
    props: ['colors'],
    store: ['colorColumns', 'colorSortOptions', 'colorPaginationOptions', 'colorSearchOptions'],
    methods: {
        showColor (params) {
            this.$inertia.visit(this.route('colors.show', params.row.id));
        },
        clearSearch () {
            this.$refs['table'].globalSearchTerm = '';
        },
    },
}
</script>
