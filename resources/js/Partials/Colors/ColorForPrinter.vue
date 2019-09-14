<template>
    <div class="w-full">
        <div class="flex flex-col md:flex-row mb-8">
            <h1 class="text-blue-600 text-base font-semibold uppercase mr-2 mb-2 md:mb-0">{{ printer.name }}-{{ printer.model }}-{{ printer.ink.type }}</h1>
            <span class="text-sm font-bold uppercase" :class="form.approved ? 'text-green-600' : 'text-red-600'">
                ( {{ form.approved ? 'approved' : 'not approved' }} )
            </span>
        </div>
        <form @submit.prevent="setColorForPrinter()">
            <div class="flex flex-col">
                <select-input v-model="form.approved" class="pb-8 w-1/3 lg:w-1/5" :error="getErrors('approved')" label="Approved">
                    <option :value="1">Yes</option>
                    <option :value="0">No</option>
                </select-input>
                <text-input v-model="form.cyan" :errors="getErrors('cyan')" class="pb-8 w-full" label="Cyan" />
                <text-input v-model="form.magenta" :errors="getErrors('magenta')" class="pb-8 w-full" label="Magenta" />
                <text-input v-model="form.yellow" :errors="getErrors('yellow')" class="pb-8 w-full" label="Yellow" />
                <text-input v-model="form.black" :errors="getErrors('black')" class="pb-2 w-full" label="Black" />
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                <loading-button :loading="sending" class="btn btn-blue ml-auto" type="submit">Update Color</loading-button>
            </div>
        </form>
    </div>
</template>

<script>
import { find } from 'lodash';
import TextInput from '@/Shared/TextInput';
import SelectInput from '@/Shared/SelectInput';
import LoadingButton from '@/Shared/LoadingButton';

export default {
    components: {
        TextInput,
        SelectInput,
        LoadingButton,
    },
    props: ['printer', 'color'],
    data () {
        return {
            sending: false,
            printerColor: null,
            form: {
                approved: false,
                cyan: null,
                magenta: null,
                yellow: null,
                black: null,
            },
        }
    },
    created () {
        this.setInitialColors();
    },
    methods: {
        setColorForPrinter () {
            this.sending = true;
            this.$inertia.put(this.route('colors.set',{ color: this.color.id, printer: this.printer.id}), this.form).then( () => this.sending = false);
        },
        setInitialColors () {
            this.printerColor = find(this.printer.colors, color => {
                return color.code === this.color.code && color.type === this.color.type;
            });

            this.form.cyan = this.printerColor.pivot.cyan;
            this.form.magenta = this.printerColor.pivot.magenta;
            this.form.yellow = this.printerColor.pivot.yellow;
            this.form.black = this.printerColor.pivot.black;
            this.form.approved = this.printerColor.pivot.approved;
        },
    },
}
</script>
