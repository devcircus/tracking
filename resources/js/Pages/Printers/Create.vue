<template>
    <layout title="Add Printer">
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-blue-300 hover:text-blue-700" :href="route('materials.list')">Materials</inertia-link>
            <span class="text-blue-300 font-medium">/</span>
            <span class="text-blue-700">Add Printer</span>
        </h1>
        <div class="bg-white rounded shadow overflow-hidden max-w-lg">
            <form @submit.prevent="submit">
                <div class="p-8 -mr-6 -mb-8 flex flex-col">
                    <div class="flex flex-col">
                        <text-input v-model="form.name" :errors="getErrors('name')" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />
                        <text-input v-model="form.model" :errors="getErrors('model')" class="pb-8 w-full lg:w-1/2" label="Model" />
                        <text-input v-model="form.manufacturer" :errors="getErrors('manufacturer')" class="pb-8 w-full lg:w-1/2" label="Manufacturer" />
                        <select-input v-model="form.ink_id" class="pb-8 w-full lg:w-1/2" :error="getErrors('ink_id')" label="Ink">
                            <option v-for="ink in inks" :key="ink.id" :value="ink.id">{{ ink.manufacturer }}-{{ ink.version }}-{{ ink.type }}</option>
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
    props: ['inks'],
    remember: 'form',
    data () {
        return {
            sending: false,
            form: {
                name: null,
                model: null,
                manufacturer: null,
                ink_id: null,
            },
        }
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
