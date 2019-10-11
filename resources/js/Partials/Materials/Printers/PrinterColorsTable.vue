<template>
    <vue-good-table ref="table"
                    class="mb-8"
                    :columns="printerColorColumns"
                    :rows="colors"
                    :search-options="printerColorSearchOptions"
                    :sort-options="printerColorSortOptions"
    >
        <template slot="emptystate">
            No colors found.
        </template>
        <template slot="table-actions">
            <div class="flex">
                <span class="text-blue-500 text-sm font-semibold leading-loose mr-2 inline-block mt-tenth cursor-pointer" @click="clearSearch()">Clear</span>
                <dropdown class="mt-1 mr-1" right="10">
                    <div slot="trigger" class="flex items-center cursor-pointer select-none group">
                        <div class="text-blue-900 group-hover:text-blue-700 focus:text-blue-700 mr-1 whitespace-no-wrap">
                            <span class="inline text-sm">Options</span>
                        </div>
                        <icon-base view="24 24" icon-fill="fill-blue-900" icon-name="cheveron-down" classes="group-hover:fill-blue-700 focus:fill-blue-700">
                            <cheveron-down />
                        </icon-base>
                    </div>
                    <div slot="dropdown" class="mt-2 p-2 shadow-lg bg-white rounded">
                        <a :href="route('colors.printer.pdf', printer.id)" target="_blank" class="text-red-500 font-semibold text-xs uppercase py-2 cursor-pointer" @click="hideDropdown()">View PDF</a>
                    </div>
                </dropdown>
            </div>
        </template>
    </vue-good-table>
</template>

<script>

import IconBase from '@/Shared/IconBase';
import { VueGoodTable } from 'vue-good-table';
import Dropdown from '@/Shared/Dropdown';
import CheveronDown from '@/Shared/Icons/CheveronDown';

export default {
    components: {
        IconBase,
        Dropdown,
        VueGoodTable,
        CheveronDown,
    },
    props: ['printer', 'colors'],
    store: ['printerColorColumns', 'printerColorSortOptions', 'printerColorSearchOptions'],
    watch: {
        windowWidth (value) {
            if (value < 768) {
                this.$set(this.printerColorColumns[2], 'hidden', true);
                this.$set(this.printerColorColumns[3], 'hidden', true);
                this.$set(this.printerColorColumns[4], 'hidden', true);
            } else {
                this.$set(this.printerColorColumns[2], 'hidden', false);
                this.$set(this.printerColorColumns[3], 'hidden', false);
                this.$set(this.printerColorColumns[4], 'hidden', false);
            }
        },
    },
    methods: {
        showPdf () {
            this.$inertia.visit(this.route('colors.printer.pdf', this.printer.id));
        },
        clearSearch () {
            this.$refs['table'].globalSearchTerm = '';
        },
    },
}
</script>
