<template>
    <vue-good-table ref="table"
                    class="mb-8"
                    :columns="inkColumns"
                    :rows="rows"
                    :sort-options="inkSortOptions"
                    @on-row-click="showInk"
    >
        <div slot="emptystate">
            No inks found.
        </div>
        <template slot="table-actions">
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
                    <checkbox v-model="showTrashed" class="mb-2" label="Include deleted inks: " :width="4" :height="4" :checked="showTrashed" @input="hideDropdown()" />
                    <inertia-link v-if="$page.auth.user.can.createInks" :href="route('inks.create')" class="text-blue-600 text-sm font-semibold uppercase hover:text-blue-800">New Ink</inertia-link>
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
    props: ['inks'],
    store: ['inkColumns', 'inkSortOptions'],
    data () {
        return {
            showTrashed: false,
        }
    },
    computed: {
        rows () {
            if (this.showTrashed) {
                return this.inks;
            }

            return filter(this.inks, ink => ink.deleted_at === null);
        },
    },
    methods: {
        showInk (params) {
            this.$inertia.visit(this.route('inks.show', params.row.id));
        },
        clearSearch () {
            this.$refs['table'].globalSearchTerm = '';
        },
    },
}
</script>
