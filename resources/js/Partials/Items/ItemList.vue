<template>
    <div>
        <div class="w-full flex bg-blue-800 p-4">
            <h1 class="text-white text-lg md:text-xl font-semibold uppercase">Current Inventory</h1>
            <icon-base icon-fill="fill-white" icon-name="book" classes="ml-2">
                <book />
            </icon-base>
        </div>
        <div>
            <vue-good-table ref="table" class="mb-8" :columns="itemColumns" :rows="rows" :pagination-options="itemPaginationOptions" :search-options="itemSearchOptions" :sort-options="itemSortOptions">
                <div slot="emptystate">
                    No items found.
                </div>
                <div slot="table-actions" class="flex justify-between">
                    <span class="text-blue-500 text-sm font-semibold leading-loose mr-2 inline-block mt-tenth cursor-pointer" @click="clearSearch()">Clear</span>
                    <dropdown v-if="$page.auth.user.can.administerItems" class="mr-1" placement="bottom-end">
                        <div class="flex items-center cursor-pointer select-none group">
                            <div class="text-blue-900 group-hover:text-blue-700 focus:text-blue-700 mr-1 whitespace-no-wrap">
                                <span class="inline text-gray-800 text-sm font-semibold">Options</span>
                            </div>
                            <icon-base icon-fill="fill-blue-900" icon-name="cheveron-down" classes="group-hover:fill-blue-700 focus:fill-blue-700">
                                <cheveron-down />
                            </icon-base>
                        </div>
                        <div slot="dropdown" class="mt-2 p-2 shadow-lg bg-white rounded">
                            <checkbox v-model="showTrashed" class="mb-2" label="Include deleted items: " :width="4" :height="4" :checked="showTrashed" @input="hideDropdown()" />
                            <span class="text-blue-500 font-semibold text-xs uppercase py-2 cursor-pointer" @click="newItem()">New Item</span>
                        </div>
                    </dropdown>
                </div>
                <template slot="table-row" slot-scope="props">
                    <span v-if="props.column.field == 'actions'" class="flex justify-between px-3">
                        <button v-if="props.row.deleted_at && $page.auth.user.can.restoreItem" class="text-green-500 hover:underline" tabindex="-1" type="button" @click="restoreItem(props.row.id)">Restore</button>
                        <button v-else-if="props.row.deleted_at === null && $page.auth.user.can.deleteItem" class="text-red-500 hover:underline" tabindex="-1" type="button" @click="destroyItem(props.row.id)">Delete</button>
                        <inertia-link v-if="$page.auth.user.can.administerItem" :href="route('items.show', props.row.id)" class="btn btn-text py-0 text-blue-500 hover:underline" tabindex="-1">View</inertia-link>
                    </span>
                    <span v-if="props.row.deleted_at">
                        <span class="text-red-500">{{ props.formattedRow[props.column.field] }}</span>
                    </span>
                    <span v-else>
                        {{ props.formattedRow[props.column.field] }}
                    </span>
                </template>
            </vue-good-table>
        </div>
    </div>
</template>

<script>
import { filter } from 'lodash';
import Book from '@/Shared/Icons/Book';
import IconBase from '@/Shared/IconBase';
import Dropdown from '@/Shared/Dropdown';
import Checkbox from '@/Shared/Checkbox';
import { VueGoodTable } from 'vue-good-table';
import CheveronDown from '@/Shared/Icons/CheveronDown';
import WatchesForErrors from 'Mixins/WatchesForErrors';

export default {
    components: {
        Book,
        IconBase,
        Dropdown,
        Checkbox,
        CheveronDown,
        VueGoodTable,
    },
    mixins: [ WatchesForErrors ],
    props: ['items'],
    remember: 'form',
    store: ['itemColumns', 'itemPaginationOptions', 'itemSortOptions', 'itemSearchOptions'],
    data () {
        return {
            showTrashed: false,
            errorBag: 'item',
        }
    },
    computed: {
        rows () {
            return this.calculateRows();
        },
    },
    methods: {
        newItem () {
            this.$inertia.visit(this.route('items.create'));
        },
        restoreItem (id) {
            this.$showDialog('warning', 'item', 'restore',
                () => {
                    this.$inertia.put(this.route('items.restore', id), null, { replace: false, preserveScroll: true, preserveState: true });
                    this.$modal.hide('dialogModal');
                }
            );
        },
        destroyItem (id) {
            this.$showDialog('warning', 'item', 'delete',
                () => {
                    this.$inertia.delete(this.route('items.destroy', id), { replace: false, preserveScroll: true, preserveState: true });
                    this.$modal.hide('dialogModal');
                }
            );
        },
        clearSearch () {
            this.$refs['table'].globalSearchTerm = '';
        },
        calculateRows () {
            if (! this.showTrashed) {
                return filter(this.items, item => item.deleted_at === null);
            }

            return this.items;
        },
    },
}
</script>
