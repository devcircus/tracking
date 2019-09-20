<template>
    <layout :title="`${printer.name}`">
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-blue-300 hover:text-blue-700" :href="route('materials.list')">Materials</inertia-link>
            <span class="text-blue-300 font-medium">/</span>
            <span class="text-blue-700">{{ printer.name }}</span>
        </h1>
        <div class="w-full md:w-2/5 flex bg-blue-800 p-4 mb-2">
            <h1 class="text-white text-lg lg:text-xl font-semibold uppercase">{{ printer.name }}</h1>
            <icon-base icon-fill="fill-white" icon-name="printer" classes="ml-2">
                <printer />
            </icon-base>
        </div>
        <template v-if="$page.auth.user.can.administerPrinters">
            <trashed-message v-if="printerData.deleted_at" class="w-full md:w-2/5 mb-6" @restore="restore">
                This printer has been deleted.
            </trashed-message>
            <div class="bg-white shadow overflow-hidden w-full md:w-2/5">
                <form @submit.prevent="submit">
                    <div class="p-8 -mr-6 -mb-8 flex flex-col">
                        <div class="flex flex-col">
                            <text-input v-model="printer.name" :errors="getErrors('name')" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />
                            <text-input v-model="printer.model" :errors="getErrors('model')" class="pb-8 w-full lg:w-1/2" label="Model" />
                            <text-input v-model="printer.manufacturer" :errors="getErrors('manufacturer')" class="pb-8 w-full lg:w-1/2" label="Manufacturer" />
                            <div class="flex w-full lg:w-1/2 mb-8 content-center">
                                <span class="text-sm font-semibold mr-2 leading-tight">Ink: </span>
                                <span class="text-base font-medium">{{ printerData.ink.manufacturer }}-{{ printerData.ink.version }}-{{ printerData.ink.type }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                        <button v-if="! printerData.deleted_at" class="btn btn-text text-red-500 hover:underline" tabindex="-1" type="button" @click="destroy">Delete</button>
                        <loading-button :loading="sending" class="btn btn-blue ml-auto" type="submit">Update Printer</loading-button>
                    </div>
                </form>
            </div>
        </template>
        <template v-else>
            <div class="flex flex-col p-2 mb-2">
                <div class="flex mb-2">
                    <span class="text-gray-800 font-black uppercase mr-2 w-160p">Printer Name: </span>
                    <span class="text-gray-700 font-bold uppercase">{{ printer.name }}</span>
                </div>
                <div class="flex mb-2">
                    <span class="text-gray-800 font-black uppercase mr-2 w-160p">Model: </span>
                    <span class="text-gray-700 font-bold uppercase">{{ printer.model }}</span>
                </div>
                <div class="flex mb-2">
                    <span class="text-gray-800 font-black uppercase mr-2 w-160p">Manufacturer: </span>
                    <span class="text-gray-700 font-bold uppercase">{{ printer.manufacturer }}</span>
                </div>
                <div class="flex mb-4">
                    <span class="text-gray-800 font-black uppercase mr-2 w-160p">Ink: </span>
                    <span class="text-gray-700 font-bold uppercase">{{ printerData.ink.manufacturer }}-{{ printerData.ink.version }}-{{ printerData.ink.type }}</span>
                </div>
                <div class="flex mb-2">
                    <inertia-link :href="route('colors.printer', printerData.id)" class="text-blue-600 font-bold uppercase mr-2 w-160p">View Colors</inertia-link>
                </div>
            </div>
        </template>
    </layout>
</template>

<script>
import Layout from '@/Shared/Layout';
import IconBase from '@/Shared/IconBase';
import TextInput from '@/Shared/TextInput';
import Printer from '@/Shared/Icons/Printer';
import LoadingButton from '@/Shared/LoadingButton';
import TrashedMessage from '@/Shared/TrashedMessage';

export default {
    components: {
        Layout,
        Printer,
        IconBase,
        TextInput,
        LoadingButton,
        TrashedMessage,
    },
    props: ['printerData', 'inks'],
    data () {
        return {
            sending: false,
            printer: {
                name: null,
                model: null,
                manufacturer: null,
                ink_id: null,
            },
        }
    },
    created () {
        this.setPrinterData();
    },
    methods: {
        setPrinterData () {
            this.printer.name = this.printerData.name;
            this.printer.model = this.printerData.model;
            this.printer.manufacturer = this.printerData.manufacturer;
            this.printer.ink_id = this.printerData.ink_id;
        },
        destroy () {
            this.$showDialog('warning', 'printer', 'delete', () => {
                this.$inertia.delete(this.route('printers.destroy', this.printerData.id), { replace: false, preserveScroll: true, preserveState: true });
                this.$modal.hide('dialogModal');
            });
        },
        restore () {
            this.$showDialog('warning', 'printer', 'restore', () => {
                this.$inertia.put(this.route('printers.restore', this.printerData.id), null, { replace: false, preserveScroll: true, preserveState: true });
                this.$modal.hide('dialogModal');
            });
        },
        submit () {
            this.sending = true;
            this.$inertia.put(this.route('printers.update', this.printerData.id), this.printer)
                .then(() => this.sending = false);
        },
    },
}
</script>
