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
        <template slot="table-actions">
            <span class="text-blue-500 text-sm font-semibold leading-loose mr-2 inline-block mt-tenth cursor-pointer" @click="clearSearch()">Clear</span>
            <dropdown class="mt-1 mr-1" placement="bottom-end">
                <div class="flex items-center cursor-pointer select-none group">
                    <div class="text-blue-900 group-hover:text-blue-700 focus:text-blue-700 mr-1 whitespace-no-wrap">
                        <span class="inline text-sm">Options</span>
                    </div>
                    <icon-base icon-fill="fill-blue-900" icon-name="cheveron-down" classes="group-hover:fill-blue-700 focus:fill-blue-700">
                        <cheveron-down />
                    </icon-base>
                </div>
                <div slot="dropdown" class="mt-2 p-2 shadow-lg bg-white rounded">
                    <inertia-link :href="route('fabrics.create')" class="text-blue-600 text-sm font-semibold hover:text-blue-800">New Fabric</inertia-link>
                </div>
            </dropdown>
        </template>
    </vue-good-table>
</template>

<script>
import Dropdown from '@/Shared/Dropdown';
import IconBase from '@/Shared/IconBase';
import { VueGoodTable } from 'vue-good-table';
import CheveronDown from '@/Shared/Icons/CheveronDown';

export default {
    components: {
        Dropdown,
        IconBase,
        VueGoodTable,
        CheveronDown,
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
