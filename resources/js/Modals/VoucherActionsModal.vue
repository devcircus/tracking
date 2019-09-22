<template>
    <div class="flex flex-col">
        <div class="flex flex-col bg-blue-900 h-20 w-full text-center pt-4">
            <span class="text-white text-3xl uppercase">
                {{ voucher.order_number }} - {{ voucher.voucher }}
            </span>
            <span class="text-white text-xl italic">
                {{ voucher.customer }}
            </span>
        </div>
        <div class="bg-white m-8">
            <div class="w-full max-w-sm mb-12">
                <form class="flex flex-col bg-white overflow-hidden" @submit.prevent="submit">
                    <text-input v-model="form.info" :errors="$page.errors.info" class="mt-6 mb-4" type="text" label="Info" />
                    <loading-button :loading="sendingInfo" class="btn btn-muted self-end" type="submit">Update Info</loading-button>
                </form>
            </div>
            <div class="flex justify-between w-full">
                <loading-button v-if="type === 'prototype'" :loading="sendingComplete" class="btn btn-blue mr-2" type="button" @clicked="markAsComplete">Complete</loading-button>
                <loading-button :loading="sendingDelete" class="btn btn-red" type="button" @clicked="deleteVoucher">Delete</loading-button>
            </div>
        </div>
    </div>
</template>

<script>
import LoadingButton from '@/Shared/LoadingButton';
import TextInput from '@/Shared/TextInput';

export default {
    components: { LoadingButton, TextInput },
    props: {
        voucher: Object,
        type: String,
    },
    data () {
        return {
            sendingInfo: false,
            sendingComplete: false,
            sendingDelete: false,
            form: {
                info: this.voucher.info,
            },
        }
    },
    methods: {
        submit () {
            this.sendingInfo = true;
            this.$inertia.patch(
                this.route('orders.update', { id: this.voucher.id }),
                this.form,
                { replace: true, preserveScroll: true, preserveState: false }).then(() => {
                    this.sendingInfo = false;
                    this.$modal.hide('voucherActions');
                });
        },
        closeModal () {
            this.$modal.hide('voucherActions');
        },
        markAsComplete () {
            this.sendingComplete = true;
            this.$inertia.post(this.route('orders.complete', { id: this.voucher.id }), this.form, { replace: false, preserveScroll: true, preserveState: false })
            .then(() => {
                this.sendingComplete = false;
                this.$modal.hide('voucherActions');
            });
        },
        deleteVoucher () {
            this.sendingDelete = true;
            this.$inertia.delete(this.route('orders.delete', { id: this.voucher.id }), this.form)
            .then(() => {
                this.sendingDelete = false;
                this.$modal.hide('voucherActions');
            });
        },
    },
}
</script>
