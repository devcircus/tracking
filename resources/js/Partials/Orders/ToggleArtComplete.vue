<template>
    <loading-button :loading="sending" class="flex btn shadow-md p-2" :class="buttonClasses(voucher)" type="button" @clicked="toggleArtComplete(voucher.id)">
        <icon-base v-if="voucher.art_complete" :height="14" :width="14" icon-fill="fill-white" icon-name="thumbs-up" classes="mr-2">
            <thumbs-up />
        </icon-base>
        <icon-base v-else icon-fill="fill-white" :height="14" :width="14" icon-name="thumbs-down" classes="mr-2">
            <thumbs-down />
        </icon-base>
        {{ buttonText(voucher) }}
    </loading-button>
</template>

<script>
import IconBase from '@/Shared/IconBase';
import ThumbsUp from '@/Shared/Icons/ThumbsUp';
import LoadingButton from '@/Shared/LoadingButton';
import ThumbsDown from '@/Shared/Icons/ThumbsDown';

export default {
    components: {
        IconBase,
        ThumbsUp,
        ThumbsDown,
        LoadingButton,
    },
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
            return voucher.art_complete ? 'Complete' : 'Not Complete';
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
