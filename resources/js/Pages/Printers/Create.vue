<template>
    <layout title="Add Printer">
        <div class="bg-white rounded shadow overflow-hidden max-w-lg">
            <form @submit.prevent="submit">
                <div class="p-8 -mr-6 -mb-8 flex flex-col">
                    <div class="flex flex-col">
                        <text-input v-model="form.name" :errors="getErrors('name')" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />
                        <text-input v-model="form.model" :errors="getErrors('model')" class="pb-8 w-full lg:w-1/2" label="Model" />
                        <text-input v-model="form.manufacturer" :errors="getErrors('manufacturer')" class="pb-8 w-full lg:w-1/2" label="Manufacturer" />
                        <select-input v-model="form.ink_id" class="pb-8 w-full lg:w-1/2" :errors="getErrors('ink_id')" label="Ink">
                            <option v-for="ink in inks" :key="ink.id" :value="ink.id">{{ ink.manufacturer }}-{{ ink.version }}-{{ ink.type }}</option>
                        </select-input>
                        <select-input v-model="form.copy_printer_id" class="pb-8 w-full lg:w-1/2" :errors="getErrors('copy_printer_id')" label="Copy colors from existing printer">
                            <option value="">Do not copy colors</option>
                            <option v-for="printer in copyPrinters" :key="printer.id" :value="printer.id">{{ printer.name }}-{{ printer.model }}-{{ printer.ink.type }}</option>
                        </select-input>
                    </div>
                </div>
                <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
                    <loading-button :loading="sending" class="btn btn-blue" type="submit">Add Printer</loading-button>
                </div>
            </form>
        </div>
    </layout>
</template>

<script>
import { filter } from 'lodash';
import Layout from '@/Shared/Layout';
import TextInput from '@/Shared/TextInput';
import SelectInput from '@/Shared/SelectInput';
import LoadingButton from '@/Shared/LoadingButton';

export default {
    components: {
        Layout,
        TextInput,
        SelectInput,
        LoadingButton,
    },
    props: ['inks', 'printers'],
    remember: 'form',
    data () {
        return {
            sending: false,
            form: {
                name: null,
                model: null,
                manufacturer: null,
                ink_id: null,
                copy_printer_id: '',
            },
        }
    },
    computed: {
        copyPrinters () {
            return this.form.ink_id ? filter(this.printers, printer => printer.ink.id === this.form.ink_id) : this.printers;
        },
    },
    methods: {
        submit () {
            this.sending = true;
            this.$inertia.post(this.route('printers.store'), this.form)
                .then(() => this.sending = false);
        },
    },
}
</script>
