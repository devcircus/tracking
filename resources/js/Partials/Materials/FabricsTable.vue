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
            <span class="text-blue-500 text-sm font-semibold leading-loose mr-2 inline-block mt-tenth cursor-pointer" @click="clearSearch()">Clear</span>
            <dropdown v-if="$page.auth.user.is_admin" class="mt-1 mr-1" placement="bottom-end">
                <div class="flex items-center cursor-pointer select-none group">
                    <div class="text-blue-900 group-hover:text-blue-700 focus:text-blue-700 mr-1 whitespace-no-wrap">
                        <span class="inline text-sm">Options</span>
                    </div>
                    <icon-base icon-fill="fill-blue-900" icon-name="cheveron-down" classes="group-hover:fill-blue-700 focus:fill-blue-700">
                        <cheveron-down />
                    </icon-base>
                </div>
                <div slot="dropdown" class="flex flex-col mt-2 p-2 shadow-lg bg-white rounded">
                    <checkbox v-model="showTrashed" class="mb-2" label="Include deleted fabrics: " :width="4" :height="4" :checked="showTrashed" @input="hideDropdown()" />
                    <inertia-link :href="route('fabrics.create')" class="text-blue-600 text-sm font-semibold uppercase hover:text-blue-800 mb-2">New Fabric</inertia-link>
                    <a :href="route('fabrics.pdf')" target="_blank" class="text-red-500 font-semibold text-sm uppercase cursor-pointer" @click="hideDropdown()">View PDF</a>
                </div>
            </dropdown>
        </template>
    </vue-good-table>
</template>

<script>
import { filter } from 'lodash';
import Dropdown from '@/Shared/Dropdown';
import IconBase from '@/Shared/IconBase';
import Checkbox from '@/Shared/Checkbox';
import { VueGoodTable } from 'vue-good-table';
import CheveronDown from '@/Shared/Icons/CheveronDown';

export default {
    components: {
        Dropdown,
        IconBase,
        Checkbox,
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
