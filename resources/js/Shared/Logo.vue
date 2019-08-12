<template>
    <div class="w-full" :class="logoPosition">
        <h1 class="inline-block font-bold text-lg md:text-2xl text-blue-500">SUBLIMATION<span class="font-medium text-white">REPORTS</span></h1>
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
