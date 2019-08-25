<template>
    <div>
        <div class="w-full bg-blue-800 p-4">
            <h1 class="text-white text-lg lg:text-xl font-semibold uppercase">Activate multiple tags</h1>
        </div>
        <div class="bg-white rounded shadow overflow-hidden w-full p-4">
            <form @submit.prevent="submit">
                <div class="flex flex-col">
                    <text-input v-model="form.starting_package_number" :errors="getErrors('starting_package_number')" class="mb-6 w-full lg:w-1/2" label="Starting Package Number" />
                    <text-input v-model="form.ending_package_number" :errors="getErrors('ending_package_number')" class="mb-6 w-full lg:w-1/2" label="Ending Package Number" />
                    <select-input v-model="form.item_id" class="mb-6 w-full lg:w-1/2" :errors="getErrors('item_id')" label="Item">
                        <option v-for="item in items" :key="item.id" :value="item.id" :selected="item.name">{{ item.name|capitalize }}</option>
                    </select-input>
                    <datepicker v-model="form.received_at" class="mb-6 w-full lg:w-1/2" :errors="getErrors('received_at')" label="Received Date" position="datepicker-top" @input="setDate($event, 'received_at')" />
                    <datepicker v-model="form.finished_at" class="mb-6 w-full lg:w-1/2" :errors="getErrors('finished_at')" label="Finished Date" position="datepicker-top" @input="setDate($event, 'finished_at')" />
                </div>
                <div class="bg-gray-100 border-t border-gray-200 flex items-center">
                    <loading-button :loading="sending" class="btn btn-blue ml-auto" type="submit">Activate Tags</loading-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import moment from 'moment';
import TextInput from '@/Shared/TextInput';
import Datepicker from '@/Shared/Datepicker';
import SelectInput from '@/Shared/SelectInput';
import LoadingButton from '@/Shared/LoadingButton';
import WatchesForErrors from 'Mixins/WatchesForErrors';

export default {
    components: {
        TextInput,
        Datepicker,
        SelectInput,
        LoadingButton,
    },
    mixins: [ WatchesForErrors ],
    props: ['items'],
    remember: {
        data: ['form'],
        key: () => 'Tags-Activate',
    },
    data () {
        return {
            sending: false,
            errorBag: 'tags',
            form: {
                starting_package_number: null,
                ending_package_number: null,
                item_id: null,
                received_at: null,
                finished_at: null,
            },
        }
    },
    methods: {
        submit () {
            this.sending = true;
            this.submitted = true;
            this.$inertia.post(this.route('tags.store.multiple'), this.form, { preserveScroll: true }).then(() => {
                this.sending = false;
            })
        },
        setDate (event, field) {
            this.form[field] = moment(event).format('YYYY-MM-DD');
        },
        resetForm () {
            this.form = _.mapValues(this.form, () => null);
            this.$dispatch('clearDateField');
        },
    },
}
</script>
