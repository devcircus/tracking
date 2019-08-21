<template>
    <loading-button :loading="sending" class="btn" :class="buttonClasses(voucher)" type="button" @clicked="toggleArtComplete(voucher.id)">{{ buttonText(voucher) }}</loading-button>
</template>

<script>
import LoadingButton from '@/Shared/LoadingButton';

export default {
    components: { LoadingButton },
    props: {
        voucher: Object,
    },
    data () {
        return {
            sending: false,
        }
    },
    methods: {
        buttonText (voucher) {
            return voucher.art_complete ? 'Mark not complete' : 'Mark complete';
        },
        buttonClasses (voucher) {
            return voucher.art_complete ? 'btn-green' : 'btn-red';
        },
        toggleArtComplete (id) {
            this.sending = true;
            this.$inertia.put(this.route('vouchers.art', id), null, { replace: false, preserveScroll: true, preserveState: true }).then(() => this.sending = false);
        },
    },
}
</script>
