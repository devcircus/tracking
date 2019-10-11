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
            <div class="flex">
                <span class="text-blue-500 text-sm font-semibold leading-loose mr-2 inline-block mt-tenth cursor-pointer" @click="clearSearch()">Clear</span>
                <new-dropdown class="mt-1 mr-1" right="10" width="180">
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
                        <inertia-link v-if="$page.auth.user.can.createInks" class="flex px-3 py-2 text-gray-700 hover:bg-blue-500 hover:text-white group" :href="route('inks.create')">
                            <icon-base view="24 24 " icon-fill="fill-gray-700" icon-name="add ink" classes="mr-2 group-hover:fill-white">
                                <plus />
                            </icon-base>
                            New Ink
                        </inertia-link>
                    </div>
                </new-dropdown>
            </div>
        </template>
    </vue-good-table>
</template>

<script>
import { filter } from 'lodash';
import Plus from '@/Shared/Icons/Plus';
import IconBase from '@/Shared/IconBase';
import Checkbox from '@/Shared/Checkbox';
import { VueGoodTable } from 'vue-good-table';
import NewDropdown from '@/Shared/NewDropdown';
import CheveronDown from '@/Shared/Icons/CheveronDown';

export default {
    components: {
        Plus,
        IconBase,
        Checkbox,
        NewDropdown,
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
