<template>
    <vue-good-table ref="table"
                    class="mb-8"
                    :columns="printerColumns"
                    :rows="rows"
    >
        <template slot="emptystate">
            No printers found.
        </template>
        <template slot="table-row" slot-scope="props">
            <span v-if="props.column.field == 'colors'" class="flex px-3">
                <button v-if="props.row.has_neon" class="text-blue-600 text-sm hover:underline mr-8" tabindex="-1" type="button" @click="showColors(props.row.id)">View Colors</button>
                <button v-if="props.row.has_standard" class="text-blue-600 text-sm hover:underline mr-8" tabindex="-1" type="button" @click="showColors(props.row.id)">View Colors</button>
                <button class="text-green-600 text-sm hover:underline" tabindex="-1" type="button" @click="showPrinter(props.row.id)">View Printer</button>
            </span>
            <span v-else>
                {{ props.formattedRow[props.column.field] }}
            </span>
        </template>
        <template slot="table-actions">
            <div class="flex justify-between items-center">
                <span class="text-blue-500 text-sm font-semibold leading-loose mr-2 inline-block mt-tenth cursor-pointer" @click="clearSearch()">Clear</span>
                <new-dropdown class="mr-1" right="10" width="180">
                    <div slot="trigger" class="flex items-center cursor-pointer select-none group">
                        <div class="text-blue-900 group-hover:text-blue-700 focus:text-blue-700 mr-1 whitespace-no-wrap">
                            <span class="inline text-sm">Options</span>
                        </div>
                        <icon-base view="24 24" icon-fill="fill-blue-900" icon-name="cheveron-down" classes="group-hover:fill-blue-700 focus:fill-blue-700">
                            <cheveron-down />
                        </icon-base>
                    </div>
                    <div slot="dropdown" class="flex flex-col mt-2 shadow-lg bg-white rounded">
                        <span class="px-6">
                            <checkbox v-model="showTrashed" class="mb-2" label="Include deleted: " :width="4" :height="4" :checked="showTrashed" @input="hideDropdown()" />
                        </span>
                        <inertia-link v-if="$page.auth.user.can.createPrinters" class="flex px-6 py-2 text-gray-700 hover:bg-blue-500 hover:text-white group" :href="route('printers.create')">
                            <icon-base view="24 24 " icon-fill="fill-gray-700" icon-name="add printer" classes="mr-2 group-hover:fill-white">
                                <plus />
                            </icon-base>
                            New Printer
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
    props: ['printers'],
    store: ['printerColumns'],
    data () {
        return {
            showTrashed: false,
        }
    },
    computed: {
        rows () {
            if (this.showTrashed) {
                return this.printers;
            }

            return filter(this.printers, printer => printer.deleted_at === null);
        },
    },
    watch: {
        windowWidth (value) {
            if (value < 768) {
                this.$set(this.printerColumns[2], 'hidden', true);
                this.$set(this.printerColumns[3], 'hidden', true);
                this.$set(this.printerColumns[4], 'hidden', true);
                this.$set(this.printerColumns[0], 'tdClass', 'text-sm');
            } else {
                this.$set(this.printerColumns[2], 'hidden', false);
                this.$set(this.printerColumns[3], 'hidden', false);
                this.$set(this.printerColumns[4], 'hidden', false);
                this.$set(this.printerColumns[0], 'tdClass', 'text-base');
            }
        },
    },
    methods: {
        showPrinter (id) {
            this.$inertia.visit(this.route('printers.show', id));
        },
        showColors (id) {
            this.$inertia.visit(this.route('colors.printer', id));
        },
        clearSearch () {
            this.$refs['table'].globalSearchTerm = '';
        },
    },
}
</script>
