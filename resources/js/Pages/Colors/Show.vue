<template>
    <layout :title="`Color - ${color.name}`">
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-blue-300 hover:text-blue-700" :href="route('materials.list')">Materials</inertia-link>
            <span class="text-blue-300 font-medium">/</span>
            <span class="text-blue-700">{{ color.name }}</span>
        </h1>
        <div class="w-full flex bg-blue-800 p-4 mb-2">
            <h1 class="text-white text-lg lg:text-xl font-semibold uppercase">{{ color.name }}</h1>
            <icon-base icon-fill="fill-white" view="32 32" :height="18" :width="18" icon-name="artist" classes="ml-2">
                <artist />
            </icon-base>
        </div>
        <template v-if="$page.auth.user.is_admin">
            <div class="flex flex-col lg:flex-row -mx-2">
                <div class="w-full lg:w-1/2 px-2">
                    <trashed-message v-if="colorData.deleted_at" class="w-full mb-6" @restore="restore">
                        This color has been deleted.
                    </trashed-message>
                    <div class="bg-white shadow overflow-hidden w-full p-8">
                        <form @submit.prevent="submit">
                            <div class="flex flex-col">
                                <text-input v-model="color.code" :errors="getErrors('code')" class="mb-8 w-full lg:w-1/2" label="Code" />
                                <text-input v-model="color.name" :errors="getErrors('name')" class="mb-8 w-full lg:w-1/2" label="Name" />
                                <checkbox v-model="color.custom" :errors="getErrors('custom')" class="pb-8 text-lg w-full lg:w-1/2" label="Custom Team Color? " :width="4" :height="4" :checked="color.custom" />
                                <div class="flex w-full lg:w-1/2 mb-8 content-center">
                                    <span class="text-sm font-semibold mr-2 leading-tight">Type: </span>
                                    <span class="text-base font-medium">{{ color.type }}</span>
                                </div>
                            </div>
                            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                                <button v-if="! colorData.deleted_at" class="btn btn-text text-red-500 hover:underline" tabindex="-1" type="button" @click="destroy">Delete</button>
                                <loading-button :loading="sending" class="btn btn-blue ml-auto" type="submit">Update Color</loading-button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="w-full lg:w-1/2 px-2">
                    <div class="bg-white flex flex-col shadow overflow-hidden w-full p-8">
                        <div v-for="printer in printers" :key="printer.id" class="mb-12">
                            <color-for-printer :printer="printer" :color="colorData" />
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template v-else>
            <div class="flex flex-col p-2 mb-2">
                <div class="flex mb-2">
                    <span class="text-gray-800 font-black uppercase mr-2 w-160p">Color Name: </span>
                    <span class="text-gray-700 font-bold uppercase">{{ color.name }}</span>
                </div>
                <div class="flex mb-2">
                    <span class="text-gray-800 font-black uppercase mr-2 w-160p">Code: </span>
                    <span class="text-gray-700 font-bold uppercase">{{ color.code }}</span>
                </div>
                <div class="flex mb-2">
                    <span class="text-gray-800 font-black uppercase mr-2 w-160p">Type: </span>
                    <span class="text-gray-700 font-bold uppercase">{{ color.type }}</span>
                </div>
            </div>
            <div class="w-full md:w-2/5 flex bg-blue-500 px-4 py-2 mb-2">
                <h1 class="text-white text-base lg:text-sm font-semibold uppercase">Printers</h1>
                <icon-base icon-fill="fill-white" :height="14" :width="14" icon-name="printer" classes="ml-2">
                    <printer />
                </icon-base>
            </div>
            <div class="w-full md:w-2/5 flex flex-col">
                <div v-for="printer in colorData.printers" :key="printer.id" class="flex-col mb-2 bg-gray-300 p-2">
                    <div class="flex mb-2">
                        <inertia-link :href="route('printers.show', printer.id)" class="text-gray-800 font-black uppercase mr-2 w-100p">{{ printer.name }}</inertia-link>
                        <span class="text-gray-700 text-sm font-bold uppercase mr-2" :class="printer.pivot.approved ? 'text-green-500' : 'text-red-500'">( {{ printer.pivot.approved ? 'approved' : 'not approved' }} )</span>
                    </div>
                    <div class="flex">
                        <span class="text-gray-800 font-bold uppercase mr-2 mb-2 w-100p">CMYK: </span>
                        <span class="text-gray-700 font-bold uppercase">{{ getColorValues(printer.pivot) }}</span>
                    </div>
                </div>
            </div>
        </template>
    </layout>
</template>

<script>
import Layout from '@/Shared/Layout';
import Checkbox from '@/Shared/Checkbox';
import IconBase from '@/Shared/IconBase';
import TextInput from '@/Shared/TextInput';
import Artist from '@/Shared/Icons/Artist';
import Printer from '@/Shared/Icons/Printer';
import LoadingButton from '@/Shared/LoadingButton';
import TrashedMessage from '@/Shared/TrashedMessage';
import ColorForPrinter from '@/Partials/Colors/ColorForPrinter';

export default {
    components: {
        Layout,
        Checkbox,
        Artist,
        Printer,
        IconBase,
        TextInput,
        LoadingButton,
        TrashedMessage,
        ColorForPrinter,
    },
    props: ['colorData', 'printers'],
    data () {
        return {
            sending: false,
            color: {
                code: null,
                name: null,
                custom: false,
                type: null,
            },
        }
    },
    created () {
        this.setColorData();
    },
    methods: {
        setColorData () {
            this.color.code = this.colorData.code;
            this.color.name = this.colorData.name;
            this.color.custom = this.colorData.custom;
            this.color.type = this.colorData.type;
        },
        getColorValues (colors) {
            return `
                ${colors.cyan}-${colors.magenta}-${colors.yellow}-${colors.black}
            `
        },
        destroy () {
            this.$showDialog('warning', 'color', 'delete', () => {
                this.$inertia.delete(this.route('colors.destroy', this.colorData.id), { replace: false, preserveScroll: true, preserveState: true });
                this.$modal.hide('dialogModal');
            });
        },
        restore () {
            this.$showDialog('warning', 'color', 'restore', () => {
                this.$inertia.put(this.route('colors.restore', this.colorData.id), null, { replace: false, preserveScroll: true, preserveState: true });
                this.$modal.hide('dialogModal');
            });
        },
        submit () {
            this.sending = true;
            this.$inertia.put(this.route('colors.update', this.colorData.id), this.color)
                .then(() => this.sending = false);
        },
    },
}
</script>
