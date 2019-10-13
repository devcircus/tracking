<template>
    <layout :title="`Fabric - ${fabric.name}`">
        <div class="w-full md:w-2/5 flex bg-blue-800 p-4 mb-2">
            <h1 class="text-white text-lg lg:text-xl font-semibold uppercase">{{ fabric.name }}</h1>
            <icon-base icon-fill="fill-white" icon-name="shirt" classes="ml-2">
                <shirt />
            </icon-base>
        </div>
        <template v-if="can('administerFabrics')">
            <trashed-message v-if="fabricData.deleted_at" class="w-full md:w-2/5 mb-6" @restore="restore">
                This fabric has been deleted.
            </trashed-message>
            <div class="bg-white shadow overflow-hidden w-full md:w-2/5">
                <form @submit.prevent="submit">
                    <div class="p-8 -mr-6 -mb-8 flex flex-col">
                        <div class="flex flex-col">
                            <text-input v-model="fabric.code" :errors="getErrors('code')" class="pr-6 pb-8 w-full lg:w-1/2" label="Code" />
                            <text-input v-model="fabric.name" :errors="getErrors('name')" class="pb-8 w-full lg:w-1/2" label="Name" />
                            <text-input v-model="fabric.manufacturer" :errors="getErrors('manufacturer')" class="pb-8 w-full lg:w-1/2" label="Manufacturer" />
                            <text-input v-model="fabric.press_speed" type="number" :step="0.1" :errors="getErrors('press_speed')" class="pb-8 w-full lg:w-1/2" label="Press Speed" />
                            <select-input v-model="fabric.cross_grain" class="pb-8 w-full lg:w-1/2" :error="getErrors('cross_grain')" label="Cross Grain">
                                <option :value="0">No</option>
                                <option :value="1">Yes</option>
                            </select-input>
                        </div>
                    </div>
                    <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                        <button v-if="! fabricData.deleted_at" class="btn btn-text text-red-500 hover:underline" tabindex="-1" type="button" @click="destroy">Delete</button>
                        <loading-button :loading="sending" class="btn btn-blue ml-auto" type="submit">Update Fabric</loading-button>
                    </div>
                </form>
            </div>
        </template>
        <template v-else>
            <div class="flex flex-col p-2 mb-2">
                <div class="flex mb-2">
                    <span class="text-gray-800 font-black uppercase mr-2 w-160p">Fabric Name: </span>
                    <span class="text-gray-700 font-bold uppercase">{{ fabric.name }}</span>
                </div>
                <div class="flex mb-2">
                    <span class="text-gray-800 font-black uppercase mr-2 w-160p">Code: </span>
                    <span class="text-gray-700 font-bold uppercase">{{ fabric.code }}</span>
                </div>
                <div class="flex mb-2">
                    <span class="text-gray-800 font-black uppercase mr-2 w-160p">Cross-grain: </span>
                    <span class="text-gray-700 font-bold uppercase">{{ fabric.cross_grain ? 'yes' : 'no' }}</span>
                </div>
                <div class="flex mb-2">
                    <span class="text-gray-800 font-black uppercase mr-2 w-160p">Press Speed: </span>
                    <span class="text-gray-700 font-bold uppercase">{{ fabric.press_speed }}</span>
                </div>
            </div>
        </template>
    </layout>
</template>

<script>
import Layout from '@/Shared/Layout';
import IconBase from '@/Shared/IconBase';
import Shirt from '@/Shared/Icons/Shirt';
import TextInput from '@/Shared/TextInput';
import SelectInput from '@/Shared/SelectInput';
import LoadingButton from '@/Shared/LoadingButton';
import TrashedMessage from '@/Shared/TrashedMessage';

export default {
    components: {
        Shirt,
        Layout,
        IconBase,
        TextInput,
        SelectInput,
        LoadingButton,
        TrashedMessage,
    },
    props: ['fabricData'],
    data () {
        return {
            sending: false,
            fabric: {
                code: null,
                name: null,
                manufacturer: null,
                cross_grain: 0,
                press_speed: null,
            },
        }
    },
    created () {
        this.setFabricData();
    },
    methods: {
        setFabricData () {
            this.fabric.code = this.fabricData.code;
            this.fabric.name = this.fabricData.name;
            this.fabric.manufacturer = this.fabricData.manufacturer;
            this.fabric.cross_grain = this.fabricData.cross_grain;
            this.fabric.press_speed = this.fabricData.press_speed;
        },
        destroy () {
            this.$showDialog('warning', 'fabric', 'delete', () => {
                this.$inertia.delete(this.route('fabrics.destroy', this.fabricData.id), { replace: false, preserveScroll: true, preserveState: true });
                this.$modal.hide('dialogModal');
            });
        },
        restore () {
            this.$showDialog('warning', 'fabric', 'restore', () => {
                this.$inertia.put(this.route('fabrics.restore', this.fabricData.id), null, { replace: false, preserveScroll: true, preserveState: true });
                this.$modal.hide('dialogModal');
            });
        },
        submit () {
            this.sending = true;
            this.$inertia.put(this.route('fabrics.update', this.fabricData.id), this.fabric)
                .then(() => this.sending = false);
        },
    },
}
</script>
