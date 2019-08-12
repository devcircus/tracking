<template>
    <div>
        <div class="w-full bg-blue-800 p-4">
            <h1 class="text-white text-lg md:text-xl font-semibold uppercase">Activate a tag</h1>
        </div>
        <div class="bg-white rounded shadow overflow-hidden w-full p-4">
            <form @submit.prevent="submit">
                <div class="flex flex-col">
                    <text-input v-model="form.package_number" :errors="getErrors('package_number')" class="mb-6 w-full md:w-1/2" label="Package Number" />
                    <select-input v-model="form.item_id" class="mb-6 w-full md:w-1/2" :errors="getErrors('item_id')" label="Item">
                        <option v-for="item in $page.items" :key="item.id" :value="item.id" :selected="item.name">{{ item.name|capitalize }}</option>
                    </select-input>
                    <datepicker id="receivedDatepicker" v-model="form.received_at" class="mb-6 w-full md:w-1/2" :errors="getErrors('received_at')" label="Received Date" position="datepicker-top" @input="setDate($event, 'received_at')" />
                    <datepicker id="finishedDatepicker" v-model="form.finished_at" class="mb-6 w-full md:w-1/2" :errors="getErrors('finished_at')" label="Finished Date" position="datepicker-top" @input="setDate($event, 'finished_at')" />
                </div>
                <div class="bg-gray-100 border-t border-gray-200 flex items-center">
                    <loading-button :loading="sending" class="btn btn-blue ml-auto" type="submit">Activate Tag</loading-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import moment from 'moment-timezone';
import TextInput from '@/Shared/TextInput';
import Datepicker from '@/Shared/Datepicker';
import SelectInput from '@/Shared/SelectInput';
import WatchesForErrors from 'Mixins/WatchesForErrors';
import LoadingButton from '@/Shared/LoadingButton';

export default {
    components: {
        TextInput,
        Datepicker,
        SelectInput,
        LoadingButton,
    },
    mixins: [ WatchesForErrors ],
    remember: {
        data: ['form'],
        key: () => 'Tag-Activate',
    },
    data () {
        return {
            sending: false,
            errorBag: 'tag',
            form: {
                package_number: null,
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
            this.$inertia.post(this.route('tags.store'), this.form).then(() => {
                this.sending = false;
            })
        },
        setDate (event, field) {
            this.form[field] = moment.utc(event).format('YYYY-MM-DD');
        },
        resetForm () {
            this.form.package_number = null;
            this.form.item_id = null;
            this.$dispatch('clearDateField');
        },
    },
}
</script>
