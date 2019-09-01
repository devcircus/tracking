<template>
    <div class="px-6 bg-blue-800 min-h-screen flex justify-center pt-8 mb-12">
        <div class="w-full max-w-sm">
            <form class="mt-8 bg-white rounded-lg shadow-lg overflow-hidden" @submit.prevent="submit">
                <div class="px-10 py-12">
                    <h1 class="text-center font-bold text-3xl">New Voucher</h1>
                    <div class="mx-auto mt-6 w-24 border-b-2" />
                    <datepicker :value="form.schedule_date" :errors="getErrors('schedule_date')" class="mt-6" label="Schedule Date" autofocus @input="setDate($event, 'schedule_date')" />
                    <text-input v-model="form.order_number" :errors="getErrors('order_number')" class="mt-6" type="number" label="Order" />
                    <text-input v-model="form.voucher" :errors="getErrors('voucher')" class="mt-6" type="number" label="Voucher" />
                    <select-input v-model="form.sew_house" class="w-1/2 mt-6" :error="getErrors('sew_house')" label="Sew House">
                        <option :value="null" />
                        <option value="CU">CU</option>
                        <option value="SU">SU</option>
                        <option value="NS">NS</option>
                    </select-input>
                    <text-input v-model="form.quantity" :errors="getErrors('quantity')" class="mt-6" type="number" label="Quantity" />
                    <text-input v-model="form.print_house" :errors="getErrors('print_house')" class="mt-6" type="text" label="Print House" disabled />
                    <datepicker :value="form.print_complete" :errors="getErrors('print_complete')" class="mt-6" label="Print Complete" @input="setDate($event, 'print_complete')" />
                    <datepicker :value="form.print_start" :errors="getErrors('print_start')" class="mt-6" label="Print Start" @input="setDate($event, 'print_start')" />
                    <datepicker :value="form.rush_date" :errors="getErrors('rush_date')" class="mt-6" label="Rush Date" @input="setDate($event, 'rush_date')" />
                    <text-input v-model="form.customer" :errors="getErrors('customer')" class="mt-6" type="text" label="Customer" />
                    <select-input v-model="form.remake" class="w-1/2 mt-6" :error="getErrors('remake')" label="Remake?">
                        <option :value="null" />
                        <option value="1">YES</option>
                        <option value="0">NO</option>
                    </select-input>
                    <datepicker :value="form.received_date" :errors="getErrors('received_date')" class="mt-6" label="Received at Plant" @input="setDate($event, 'received_date')" />
                    <datepicker :value="form.cut_date" :errors="getErrors('cut_date')" class="mt-6" label="Cut Date" @input="setDate($event, 'cut_date')" />
                    <text-input v-model="form.style" :errors="getErrors('style')" class="mt-6" type="text" label="Style" />
                    <select-input v-model="form.cut_house" class="w-1/2 mt-6" :errors="getErrors('cut_house')" label="Cut House">
                        <option :value="null" />
                        <option value="CU">CU</option>
                        <option value="SU">SU</option>
                        <option value="NS">NS</option>
                    </select-input>
                    <text-input v-model="form.report_created" :errors="getErrors('report_created')" class="mt-6" type="text" label="Report Created" tabindex="-1" disabled />
                    <text-input v-model="form.info" :errors="getErrors('info')" class="mt-6" type="text" label="Info" />
                </div>
                <div class="px-10 py-4 bg-gray-100 border-t border-gray-200 flex justify-between items-center">
                    <loading-button :loading="sending" class="btn btn-blue" type="submit">Create</loading-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import moment from 'moment';
import TextInput from '@/Shared/TextInput.vue';
import Datepicker from '@/Shared/Datepicker.vue';
import SelectInput from '@/Shared/SelectInput.vue';
import LoadingButton from '@/Shared/LoadingButton.vue';
import WatchesForErrors from 'Mixins/WatchesForErrors';

export default {
    components: {
        TextInput,
        SelectInput,
        LoadingButton,
        Datepicker,
    },
    mixins: [ WatchesForErrors ],
    props: {
        created: String,
    },
    data () {
        return {
            submitted: false,
            sending: false,
            form: {
                schedule_date: null,
                order_number: null,
                voucher: null,
                sew_house: null,
                quantity: null,
                print_house: 'CU',
                print_complete: null,
                print_start: null,
                days: null,
                rush_date: null,
                customer: null,
                remake: null,
                received_date: null,
                cut_date: null,
                style: null,
                cut_house: null,
                report_created: this.created,
                info: null,
            },
        }
    },
    methods: {
        submit () {
            this.sending = true;
            this.submitted = true;
            this.$inertia.post(this.route('orders.add'), this.form, { replace: false, preserveScroll: false, preserveState: false }).then(() => {
                this.sending = false;
            });
        },
        setDate (event, field) {
            this.form[field] = moment(event).format('YYYY-MM-DD');
        },
        resetForm () {
            this.$modal.hide('newVoucher');
        },
    },
}
</script>
