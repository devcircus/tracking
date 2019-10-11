<template>
    <vue-good-table ref="table"
                    class="mb-8"
                    :columns="fabricColumns"
                    :rows="rows"
                    :pagination-options="fabricPaginationOptions"
                    :search-options="fabricSearchOptions"
                    :sort-options="fabricSortOptions"
                    @on-row-click="showFabric"
    >
        <div slot="emptystate">
            No fabrics found.
        </div>
        <template slot="table-actions">
            <div class="flex">
                <span class="text-blue-500 text-sm font-semibold leading-loose mr-2 inline-block mt-tenth cursor-pointer" @click="clearSearch()">Clear</span>
                <dropdown class="mt-1 mr-1" right="10" width="180">
                    <div slot="trigger" class="flex items-center cursor-pointer select-none group">
                        <div class="text-blue-900 group-hover:text-blue-700 focus:text-blue-700 mr-1 whitespace-no-wrap">
                            <span class="inline text-sm">Options</span>
                        </div>
                        <icon-base view="24 24" icon-fill="fill-blue-900" icon-name="cheveron-down" classes="group-hover:fill-blue-700 focus:fill-blue-700">
                            <cheveron-down />
                        </icon-base>
                    </div>
                    <div slot="dropdown" class="flex flex-col mt-2 shadow-lg bg-white rounded">
                        <span class="px-3">
                            <checkbox v-model="showTrashed" class="mb-2 text-gray-700" label="Include deleted: " :width="4" :height="4" :checked="showTrashed" @input="hideDropdown()" />
                        </span>
                        <inertia-link v-if="$page.auth.user.can.createFabrics" class="flex px-3 py-2 text-gray-700 hover:bg-blue-500 hover:text-white group" :href="route('fabrics.create')">
                            <icon-base view="24 24" icon-fill="fill-gray-700" icon-name="add fabric" classes="mr-2 group-hover:fill-white">
                                <plus />
                            </icon-base>
                            New Fabric
                        </inertia-link>
                        <a :href="route('fabrics.pdf')" target="_blank" class="flex px-3 py-2 text-gray-700 hover:bg-blue-500 hover:text-white group" @click="hideDropdown()">
                            <icon-base width="14" height="14" icon-fill="fill-gray-700" icon-name="printable" classes="mr-2 group-hover:fill-white">
                                <printer />
                            </icon-base>
                            View PDF
                        </a>
                    </div>
                </dropdown>
            </div>
        </template>
    </vue-good-table>
</template>

<script>
import { filter } from 'lodash';
import Plus from '@/Shared/Icons/Plus';
import IconBase from '@/Shared/IconBase';
import Checkbox from '@/Shared/Checkbox';
import Printer from '@/Shared/Icons/Printer';
import { VueGoodTable } from 'vue-good-table';
import Dropdown from '@/Shared/Dropdown';
import CheveronDown from '@/Shared/Icons/CheveronDown';

export default {
    components: {
        Plus,
        Printer,
        IconBase,
        Checkbox,
        Dropdown,
        VueGoodTable,
        CheveronDown,
    },
    props: ['fabrics'],
    store: ['fabricColumns', 'fabricSortOptions', 'fabricPaginationOptions', 'fabricSearchOptions'],
    data () {
        return {
            showTrashed: false,
        }
    },
    computed: {
        rows () {
            if (this.showTrashed) {
                return this.fabrics;
            }

            return filter(this.fabrics, fabric => fabric.deleted_at === null);
        },
    },
    watch: {
        windowWidth (value) {
            if (value < 768) {
                this.$set(this.fabricColumns[2], 'hidden', true);
                this.$set(this.fabricColumns[3], 'hidden', true);
                this.$set(this.fabricColumns[4], 'hidden', true);
            } else {
                this.$set(this.fabricColumns[2], 'hidden', false);
                this.$set(this.fabricColumns[3], 'hidden', false);
                this.$set(this.fabricColumns[4], 'hidden', false);
            }
        },
    },
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
