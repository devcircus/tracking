<template>
    <div class="w-full flex items-center" :class="logoPosition">
        <h1 class="inline-block font-bold text-lg lg:text-2xl text-blue-500">SUBLIMATION</h1><span class="inline-block font-semibold text-lg lg:text-2xl text-white">REPORTS</span>
    </div>
</template>

<script>
export default {
    props: {
        position: {
            type: String,
            default: 'center',
        },
    },
    computed: {
        logoPosition () {
            if (this.position === 'left') {
                return 'text-left';
            } else if (this.position === 'center') {
                return 'text-center mx-auto';
            } else {
                return 'text-right';
            }
        },
    },
}
</script>
