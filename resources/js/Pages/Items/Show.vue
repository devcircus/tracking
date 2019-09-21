<template>
    <layout :title="displayName">
        <trashed-message v-if="item.deleted_at" class="mb-6" @restore="restore">
            This item has been deleted.
        </trashed-message>
        <div class="flex flex-wrap w-full -mx-2">
            <div class="flex flex-col w-full lg:w-1/3">
                <div class="bg-white rounded shadow overflow-hidden w-full px-2 mb-4">
                    <form @submit.prevent="submit">
                        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                            <text-input v-model="form.name" :errors="getErrors('name')" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />
                            <text-input v-model="form.minimum" type="number" :errors="getErrors('minimum')" class="pr-6 pb-8 w-full lg:w-1/2" label="Minimum" />
                        </div>
                        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                            <button v-if="! item.deleted_at" class="text-red-500 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Item</button>
                            <loading-button :loading="sending" class="btn btn-blue ml-auto" type="submit">Update Item</loading-button>
                        </div>
                    </form>
                </div>
                <active-tags :item="item" />
            </div>
            <div class="overflow-hidden w-full lg:w-2/3 px-2">
                <activated-history :item="item" class="mb-4" />
                <finished-history :item="item" />
            </div>
        </div>
    </layout>
</template>

<script>
import Layout from '@/Shared/Layout';
import TextInput from '@/Shared/TextInput';
import LoadingButton from '@/Shared/LoadingButton';
import ActiveTags from '@/Partials/Items/ActiveTags';
import TrashedMessage from '@/Shared/TrashedMessage';
import WatchesForErrors from 'Mixins/WatchesForErrors';
import FinishedHistory from '@/Partials/Items/FinishedHistory';
import ActivatedHistory from '@/Partials/Items/ActivatedHistory';

export default {
    components: {
        Layout,
        LoadingButton,
        TextInput,
        TrashedMessage,
        ActiveTags,
        ActivatedHistory,
        FinishedHistory,
    },
    mixins: [ WatchesForErrors ],
    props: {
        item: Object,
    },
    remember: 'form',
    data () {
        return {
            sending: false,
            errorBag: 'item',
            form: {
                id: this.item.id,
                name: this.item.name,
                minimum: this.item.minimum.toString(),
            },
        }
    },
    computed: {
        displayName () {
            return this.item.name.toUpperCase();
        },
    },
    methods: {
        submit () {
            this.sending = true;
            this.$inertia.put(this.route('items.update', this.item.id), this.form)
            .then(() => {
                this.sending = false;
             });
        },
        restore () {
            this.$showDialog('warning', 'item', 'restore',
                () => {
                    this.$inertia.put(this.route('items.restore', this.item.id), null, { replace: false, preserveScroll: true, preserveState: true });
                    this.$modal.hide('dialogModal');
                }
            );
        },
        destroy () {
            this.$showDialog('warning', 'item', 'delete',
                () => {
                    this.$inertia.delete(this.route('items.destroy', this.item.id), { replace: false, preserveScroll: true, preserveState: true });
                    this.$modal.hide('dialogModal');
                }
            );
        },
    },
}
</script>
