<template>
    <div>
        <modal-component name="fetching" width="80%" :max-width="1000" :adaptive="true" :delay="250" height="auto" class="text-center center">
            <div id="loader-wrapper">
                <div id="loader-label">
                    <h2 class="loader">Fetching Report Data</h2>
                    <p class="loader">Dashboard will update automatically.</p>
                </div>
            </div>
        </modal-component>
        <modal-component name="uploading" width="80%" :max-width="1000" :adaptive="true" :delay="250" height="auto" class="text-center center">
            <div id="loader-wrapper">
                <div id="preloader" />
                <div id="loader-label">
                    <h2 class="loader">Uploading Spreadsheet</h2>
                    <p class="loader">Dashboard will update automatically.</p>
                </div>
            </div>
        </modal-component>
        <modal-component name="voucherActions" width="80%" :max-width="400" :adaptive="true" :delay="250" height="auto" class="text-center center" @before-open="beforeOpenVoucherActions($event)">
            <voucher-actions-modal :voucher="voucherActions.voucher" :type="voucherActions.type" />
        </modal-component>
        <modal-component name="newVoucher" width="80%" :max-width="600" :adaptive="true" :scrollable="true" :delay="250" height="auto" class="text-center center" @before-open="beforeOpenNewVoucher($event)">
            <new-voucher-modal :created="newVoucher.created" />
        </modal-component>
        <modal-component name="dialogModal" width="80%" :max-width="400" :adaptive="true" :delay="250" height="auto" class="text-center center" @before-open="beforeOpenDialog($event)">
            <dialog-modal :title="dialog.title" :text="dialog.text" :buttons="dialog.buttons" />
        </modal-component>
    </div>
</template>

<script>
import DialogModal from '@/Modals/DialogModal';
import NewVoucherModal from '@/Modals/NewVoucherModal';
import VoucherActionsModal from '@/Modals/VoucherActionsModal';

export default {
    components: {
        DialogModal,
        NewVoucherModal,
        VoucherActionsModal,
    },
    data () {
        return {
            voucherActions: {
                voucher: null,
                type: null,
            },
            newVoucher: {
                created: null,
            },
            dialog: {
                title: null,
                text: null,
                buttons: [],
            },
        }
    },
    methods: {
        beforeOpenDialog (event) {
            this.dialog.title = event.params.title;
            this.dialog.text = event.params.text;
            this.dialog.buttons = event.params.buttons;
        },
        beforeOpenVoucherActions (event) {
            this.voucherActions.voucher = event.params.voucher;
            this.voucherActions.type = event.params.type;
        },
        beforeOpenNewVoucher (event) {
            this.newVoucher.created = event.params.created;
            if (! this.isObjectEmpty(this.$page.errors)) {
                this.$page.errors = {};
            }
        },
    }
}
</script>
