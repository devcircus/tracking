<template>
    <div class="px-6 bg-blue-800 min-h-screen flex justify-center pt-8 mb-12">
        <div class="w-full max-w-sm">
            <form class="mt-8 bg-white rounded-lg shadow-lg overflow-hidden" @submit.prevent="submit">
                <div class="px-10 py-12">
                    <h1 class="text-center font-bold text-3xl">New Voucher</h1>
                    <div class="mx-auto mt-6 w-24 border-b-2" />
                    <datepicker :value="form.schedule_date" :errors="$page.errors.schedule_date" class="mt-6" label="Schedule Date" autofocus @input="setDate($event, 'schedule_date')" />
                    <text-input v-model="form.order_number" :errors="$page.errors.order_number" class="mt-6" type="number" label="Order" />
                    <text-input v-model="form.voucher" :errors="$page.errors.voucher" class="mt-6" type="number" label="Voucher" />
                    <select-input v-model="form.sew_house" class="w-1/2 mt-6" :error="$page.errors.sew_house" label="Sew House">
                        <option :value="null" />
                        <option value="CU">CU</option>
                        <option value="SU">SU</option>
                        <option value="NS">NS</option>
                    </select-input>
                    <text-input v-model="form.quantity" :errors="$page.errors.quantity" class="mt-6" type="number" label="Quantity" />
                    <text-input v-model="form.print_house" :errors="$page.errors.print_house" class="mt-6" type="text" label="Print House" disabled />
                    <datepicker :value="form.print_complete" :errors="$page.errors.print_complete" class="mt-6" label="Print Complete" @input="setDate($event, 'print_complete')" />
                    <datepicker :value="form.print_start" :errors="$page.errors.print_start" class="mt-6" label="Print Start" @input="setDate($event, 'print_start')" />
                    <datepicker :value="form.rush_date" :errors="$page.errors.rush_date" class="mt-6" label="Rush Date" @input="setDate($event, 'rush_date')" />
                    <text-input v-model="form.customer" :errors="$page.errors.customer" class="mt-6" type="text" label="Customer" />
                    <select-input v-model="form.remake" class="w-1/2 mt-6" :error="$page.errors.remake" label="Remake?">
                        <option :value="null" />
                        <option value="1">YES</option>
                        <option value="0">NO</option>
                    </select-input>
                    <datepicker :value="form.received_date" :errors="$page.errors.received_date" class="mt-6" label="Received at Plant" @input="setDate($event, 'received_date')" />
                    <datepicker :value="form.cut_date" :errors="$page.errors.cut_date" class="mt-6" label="Cut Date" @input="setDate($event, 'cut_date')" />
                    <text-input v-model="form.style" :errors="$page.errors.style" class="mt-6" type="text" label="Style" />
                    <select-input v-model="form.cut_house" class="w-1/2 mt-6" :error="$page.errors.cut_house" label="Cut House">
                        <option :value="null" />
                        <option value="CU">CU</option>
                        <option value="SU">SU</option>
                        <option value="NS">NS</option>
                    </select-input>
                    <text-input v-model="form.report_created" :errors="$page.errors.report_created" class="mt-6" type="text" label="Report Created" tabindex="-1" disabled />
                    <text-input v-model="form.info" :errors="$page.errors.info" class="mt-6" type="text" label="Info" />
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

export default {
    components: {
        TextInput,
        SelectInput,
        LoadingButton,
        Datepicker,
    },
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
    watch: {
        '$page.errors': {
            immediate: true,
            handler (newErrors, oldErrors) {
                if (this.isObjectEmpty(newErrors) && this.submitted === true) {
                    this.$modal.hide('newVoucher');
                    this.submitted = false;
                }
            },
            deep: true,
        },
    },
    methods: {
        submit () {
            this.sending = true;
            this.submitted = true;
            this.$inertia.post(this.route('orders.add'), this.form).then(() => {
                this.sending = false;
            });
        },
        setDate (event, field) {
            this.form[field] = moment(event).format('YYYY-MM-DD');
        },
    },
}
</script>
