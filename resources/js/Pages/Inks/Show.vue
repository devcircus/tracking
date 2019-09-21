<template>
    <layout :title="`Ink - ${ink.version}`">
        <div class="w-full md:w-2/5 flex bg-blue-800 p-4 mb-2">
            <h1 class="text-white text-lg lg:text-xl font-semibold uppercase">{{ ink.manufacturer }} {{ ink.version }} {{ ink.type }}</h1>
            <icon-base icon-fill="fill-white" view="20 32" icon-name="ink" classes="ml-2">
                <ink />
            </icon-base>
        </div>
        <template v-if="$page.auth.user.can.administerInks">
            <trashed-message v-if="inkData.deleted_at" class="w-full md:w-2/5 mb-6" @restore="restore">
                This ink has been deleted.
            </trashed-message>
            <div class="bg-white shadow overflow-hidden w-full md:w-2/5">
                <form @submit.prevent="submit">
                    <div class="p-8 -mr-6 -mb-8 flex flex-col">
                        <div class="flex flex-col">
                            <text-input v-model="ink.manufacturer" :errors="getErrors('manufacturer')" class="pb-8 w-full lg:w-1/2" label="Manufacturer" />
                            <text-input v-model="ink.version" :errors="getErrors('version')" class="pb-8 w-full lg:w-1/2" label="Version" />
                            <div class="flex w-full lg:w-1/2 mb-8 content-center">
                                <span class="text-sm font-semibold mr-2 leading-tight">Type: </span>
                                <span class="text-base font-medium">{{ inkData.type }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                        <button v-if="! inkData.deleted_at" class="btn btn-text text-red-500 hover:underline" tabindex="-1" type="button" @click="destroy">Delete</button>
                        <loading-button :loading="sending" class="btn btn-blue ml-auto" type="submit">Update Ink</loading-button>
                    </div>
                </form>
            </div>
        </template>
        <template v-else>
            <div class="flex flex-col p-2 mb-2">
                <div class="flex mb-2">
                    <span class="text-gray-800 font-black uppercase mr-2 w-200p">Ink Manufacturer: </span>
                    <span class="text-gray-700 font-bold uppercase">{{ ink.manufacturer }}</span>
                </div>
                <div class="flex mb-2">
                    <span class="text-gray-800 font-black uppercase mr-2 w-200p">Version: </span>
                    <span class="text-gray-700 font-bold uppercase">{{ ink.version }}</span>
                </div>
                <div class="flex mb-2">
                    <span class="text-gray-800 font-black uppercase mr-2 w-200p">Type: </span>
                    <span class="text-gray-700 font-bold uppercase">{{ ink.type }}</span>
                </div>
            </div>
        </template>
    </layout>
</template>

<script>
import Ink from '@/Shared/Icons/Ink';
import Layout from '@/Shared/Layout';
import IconBase from '@/Shared/IconBase';
import TextInput from '@/Shared/TextInput';
import LoadingButton from '@/Shared/LoadingButton';
import TrashedMessage from '@/Shared/TrashedMessage';

export default {
    components: {
        Ink,
        Layout,
        IconBase,
        TextInput,
        LoadingButton,
        TrashedMessage,
    },
    props: ['inkData'],
    data () {
        return {
            sending: false,
            ink: {
                manufacturer: null,
                version: null,
                type: null,
            },
        }
    },
    created () {
        this.setInkData();
    },
    methods: {
        setInkData () {
            this.ink.manufacturer = this.inkData.manufacturer;
            this.ink.version = this.inkData.version;
            this.ink.type = this.inkData.type;
        },
        destroy () {
            this.$showDialog('warning', 'ink', 'delete', () => {
                this.$inertia.delete(this.route('inks.destroy', this.inkData.id), { replace: false, preserveScroll: true, preserveState: true });
                this.$modal.hide('dialogModal');
            });
        },
        restore () {
            this.$showDialog('warning', 'ink', 'restore', () => {
                this.$inertia.put(this.route('inks.restore', this.inkData.id), null, { replace: false, preserveScroll: true, preserveState: true });
                this.$modal.hide('dialogModal');
            });
        },
        submit () {
            this.sending = true;
            this.$inertia.put(this.route('inks.update', this.inkData.id), this.ink)
                .then(() => this.sending = false);
        },
    },
}
</script>
