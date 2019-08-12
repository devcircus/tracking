<template>
    <layout title="Create Item">
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-blue-300 hover:text-blue-700" :href="route('inventory')">Inventory</inertia-link>
            <span class="text-blue-300 font-medium">/</span>
            <span class="text-gray-800 font-semibold">Create Item</span>
        </h1>
        <div class="bg-white rounded shadow overflow-hidden max-w-lg">
            <form @submit.prevent="submit">
                <div class="p-8 -mr-6 -mb-8 flex flex-col">
                    <div class="flex flex-wrap">
                        <text-input v-model="form.name" :errors="getErrors('name')" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />
                        <text-input v-model="form.minimum" type="number" :errors="getErrors('minimum')" class="pb-8 w-full lg:w-1/2" label="Minimum" />
                    </div>
                </div>
                <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
                    <loading-button :loading="sending" class="btn btn-blue" type="submit">Create Item</loading-button>
                </div>
            </form>
        </div>
    </layout>
</template>

<script>
import Layout from '@/Shared/Layout';
import TextInput from '@/Shared/TextInput';
import LoadingButton from '@/Shared/LoadingButton';

export default {
    components: {
        Layout,
        LoadingButton,
        TextInput,
    },
    remember: 'form',
    data () {
        return {
            sending: false,
            errorBag: 'item',
            form: {
                name: null,
                minimum: null,
            },
        }
    },
    methods: {
        submit () {
            this.sending = true;
            this.$inertia.post(this.route('items.store'), this.form)
            .then(() => this.sending = false)
        },
    },
}
</script>
