<template>
    <vue-good-table ref="table"
                    class="mb-8"
                    :columns="colorColumns"
                    :rows="rows"
                    :pagination-options="colorPaginationOptions"
                    :search-options="colorSearchOptions"
                    :sort-options="colorSortOptions"
                    @on-row-click="showColor"
    >
        <div slot="emptystate">
            No colors found.
        </div>
        <template slot="table-actions">
            <span class="text-blue-500 text-sm font-semibold leading-loose mr-2 inline-block mt-tenth cursor-pointer" @click="clearSearch()">Clear</span>
            <dropdown class="mt-1 mr-1" placement="bottom-end">
                <div class="flex items-center cursor-pointer select-none group">
                    <div class="text-blue-900 group-hover:text-blue-700 focus:text-blue-700 mr-1 whitespace-no-wrap">
                        <span class="inline text-sm">Options</span>
                    </div>
                    <icon-base view="24 24" icon-fill="fill-blue-900" icon-name="cheveron-down" classes="group-hover:fill-blue-700 focus:fill-blue-700">
                        <cheveron-down />
                    </icon-base>
                </div>
                <div slot="dropdown" class="mt-2 p-2 shadow-lg bg-white rounded">
                    <checkbox v-model="showTrashed" class="mb-2" label="Include deleted colors: " :width="4" :height="4" :checked="showTrashed" @input="hideDropdown()" />
                    <inertia-link v-if="$page.auth.user.can.createColors" :href="route('colors.create')" class="text-blue-600 text-sm font-semibold uppercase hover:text-blue-800">New Color</inertia-link>
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
    props: ['colors'],
    store: ['colorColumns', 'colorSortOptions', 'colorPaginationOptions', 'colorSearchOptions'],
    data () {
        return {
            showTrashed: false,
        }
    },
    computed: {
        rows () {
            if (this.showTrashed) {
                return this.colors;
            }

            return filter(this.colors, color => color.deleted_at === null);
        },
    },
    watch: {
        windowWidth (value) {
            if (value < 768) {
                this.$set(this.colorColumns[2], 'hidden', true);
            } else {
                this.$set(this.colorColumns[2], 'hidden', false);
            }
        },
    },
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
