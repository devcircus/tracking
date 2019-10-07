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
                    <checkbox v-model="showTrashed" class="mb-2" label="Include deleted printers: " :width="4" :height="4" :checked="showTrashed" @input="hideDropdown()" />
                    <inertia-link v-if="$page.auth.user.can.createPrinters" :href="route('printers.create')" class="text-blue-600 text-sm font-semibold uppercase hover:text-blue-800">New Printer</inertia-link>
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
