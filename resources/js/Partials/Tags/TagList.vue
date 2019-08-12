<script>
import Icon from '@/Shared/Icon';
import { filter, concat } from 'lodash';
import Checkbox from '@/Shared/Checkbox';
import Dropdown from '@/Shared/Dropdown';
import { VueGoodTable } from 'vue-good-table';

export default {
    components: {
        Icon,
        Dropdown,
        Checkbox,
        VueGoodTable,
    },
    remember: 'form',
    store: ['tagColumns', 'tagSortOptions', 'tagPaginationOptions', 'tagSearchOptions'],
    data () {
        return {
            sending: false,
            showActive: true,
            showFinished: true,
            showTrashed: false,
        }
    },
    computed: {
        rows () {
            return this.calculateRows();
        },
    },
    watch: {
        windowWidth (value) {
            if (value < 768) {
                this.$set(this.tagColumns[2], 'hidden', true);
                this.$set(this.tagColumns[3], 'hidden', true);
                this.$set(this.tagColumns[4], 'tdClass', 'text-sm');
            } else {
                this.$set(this.tagColumns[2], 'hidden', false);
                this.$set(this.tagColumns[3], 'hidden', false);
                this.$set(this.tagColumns[4], 'tdClass', 'text-base');
            }
        },
    },
    methods: {
        restoreTag (id) {
            this.$modal.show('dialogModal', {
                title: 'Caution!',
                text: 'Are you sure you want to restore this tag?',
                buttons: [
                    {
                        title: 'Restore Tag',
                        type: 'restore',
                        handler: () => {
                            this.$inertia.put(this.route('tags.restore', id), null, { replace: false, preserveScroll: true, preserveState: true });
                            this.$modal.hide('dialogModal');
                         },
                    },
                    {
                        title: 'Close',
                        type: 'close',
                        handler: () => this.$modal.hide('dialogModal'),
                    },
                ],
            });
        },
        destroyTag (id) {
            this.$modal.show('dialogModal', {
                title: 'Caution!',
                text: 'Are you sure you want to delete this tag?',
                buttons: [
                    {
                        title: 'Delete Tag',
                        type: 'delete',
                        handler: () => {
                            this.$inertia.delete(this.route('tags.destroy', id), { replace: false, preserveScroll: true, preserveState: true });
                            this.$modal.hide('dialogModal');
                         },
                    },
                    {
                        title: 'Close',
                        type: 'close',
                        handler: () => this.$modal.hide('dialogModal'),
                    },
                ],
            });
        },
        reactivateTag (id) {
            this.$modal.show('dialogModal', {
                title: 'Caution!',
                text: 'Are you sure you want to reactivate this tag?',
                buttons: [
                    {
                        title: 'Reactivate Tag',
                        type: 'restore',
                        handler: () => {
                            this.$inertia.put(this.route('tags.reactivate', id), null, { replace: false, preserveScroll: true, preserveState: true });
                            this.$modal.hide('dialogModal');
                         },
                    },
                    {
                        title: 'Close',
                        type: 'close',
                        handler: () => this.$modal.hide('dialogModal'),
                    },
                ],
            });
        },
        finishTag (id) {
            this.$modal.show('dialogModal', {
                title: 'Caution!',
                text: 'Are you sure you want to finish this tag?',
                buttons: [
                    {
                        title: 'Finish Tag',
                        type: 'delete',
                        handler: () => {
                            this.$inertia.put(this.route('tags.finish', id), null, { replace: false, preserveScroll: true, preserveState: true });
                            this.$modal.hide('dialogModal');
                         },
                    },
                    {
                        title: 'Close',
                        type: 'close',
                        handler: () => this.$modal.hide('dialogModal'),
                    },
                ],
            });
        },
        clearSearch () {
            this.$refs['table'].globalSearchTerm = '';
        },
        calculateRows () {
            const active = filter(this.$page.tags, tag => {
                return tag.deleted_at === null && tag.finished_at === null;
            });
            const trashed = filter(this.$page.tags, tag => {
                return tag.deleted_at != null;
            });
            const finished = filter(this.$page.tags, tag => {
                return tag.finished_at != null && tag.deleted_at === null;
            });

            if (this.showActive) {
                if (this.showTrashed) {
                    if (this.showFinished) {
                        return concat(active, trashed, finished);
                    }
                    return concat(active, trashed);
                }
                if (this.showFinished) {
                    return concat(active, finished);
                }
                return active;
            }
            if (this.showTrashed) {
                if (this.showFinished) {
                    return concat(trashed, finished);
                }
                return trashed;
            }
            if (this.showFinished) {
                return finished;
            }

            return [];
        },
    },
}
</script>

<template>
    <div>
        <div class="w-full bg-blue-800 p-4">
            <h1 class="text-white text-lg md:text-xl font-semibold uppercase">Recently Added</h1>
        </div>
        <div>
            <vue-good-table ref="table" class="mb-8" :columns="tagColumns" :rows="rows" :pagination-options="tagPaginationOptions" :search-options="tagSearchOptions" :sort-options="tagSortOptions">
                <div slot="emptystate">
                    No tags found.
                </div>
                <div slot="table-actions" class="flex justify-between">
                    <span class="text-blue-500 text-sm font-semibold leading-loose mr-2 inline-block mt-tenth cursor-pointer" @click="clearSearch()">Clear</span>
                    <dropdown class="mr-1" placement="bottom-end">
                        <div class="flex items-center cursor-pointer select-none group">
                            <div class="text-blue-900 group-hover:text-blue-700 focus:text-blue-700 mr-1 whitespace-no-wrap">
                                <span class="inline text-gray-800 text-sm font-semibold">Options</span>
                            </div>
                            <icon class="w-5 h-5 group-hover:fill-blue-700 fill-blue-900 focus:fill-blue-700" name="cheveron-down" />
                        </div>
                        <div slot="dropdown" class="mt-2 p-2 shadow-lg bg-white rounded">
                            <checkbox v-model="showActive" class="mb-2" label="Include active tags: " :width="4" :height="4" :checked="showActive" @input="hideDropdown()" />
                            <checkbox v-model="showFinished" class="mb-2" label="Include finished tags: " :width="4" :height="4" :checked="showFinished" @input="hideDropdown()" />
                            <checkbox v-if="$page.auth.user.is_admin" v-model="showTrashed" class="mb-2" label="Include deleted tags: " :width="4" :height="4" :checked="showTrashed" @input="hideDropdown()" />
                        </div>
                    </dropdown>
                </div>
                <template slot="table-row" slot-scope="props">
                    <span v-if="props.column.field == 'actions'" class="flex justify-between px-3">
                        <button v-if="props.row.deleted_at && $page.auth.user.is_admin" class="text-green-500 hover:underline" tabindex="-1" type="button" @click="restoreTag(props.row.id)">Restore</button>
                        <button v-else-if="props.row.deleted_at === null && $page.auth.user.is_admin" class="text-red-500 hover:underline" tabindex="-1" type="button" @click="destroyTag(props.row.id)">Delete</button>
                        <button v-if="props.row.finished_at" class="text-green-500 hover:underline" tabindex="-1" type="button" @click="reactivateTag(props.row.id)">Activate</button>
                        <button v-else class="text-red-500 hover:underline" tabindex="-1" type="button" @click="finishTag(props.row.id)">Finish</button>
                    </span>
                    <span v-if="props.row.deleted_at">
                        <span class="text-red-500">{{ props.formattedRow[props.column.field] }}</span>
                    </span>
                    <span v-else-if="props.row.finished_at">
                        <span class="text-orange-500">{{ props.formattedRow[props.column.field] }}</span>
                    </span>
                    <span v-else>
                        {{ props.formattedRow[props.column.field] }}
                    </span>
                </template>
            </vue-good-table>
        </div>
    </div>
</template>
