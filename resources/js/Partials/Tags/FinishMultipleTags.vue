<template>
    <div>
        <div class="w-full bg-blue-800 p-4">
            <h1 class="text-white text-lg lg:text-xl font-semibold uppercase">Finish multiple tags</h1>
        </div>
        <div class="bg-white rounded shadow overflow-hidden w-full p-4">
            <form @submit.prevent="submit">
                <div class="flex flex-col">
                    <text-input v-model="form.starting_package_number" :errors="getErrors('starting_package_number')" class="mb-6 w-full lg:w-1/2" label="Starting Package Number" />
                    <text-input v-model="form.ending_package_number" :errors="getErrors('ending_package_number')" class="mb-6 w-full lg:w-1/2" label="Ending Package Number" />
                </div>
                <div class="bg-gray-100 border-t border-gray-200 flex items-center">
                    <loading-button :loading="sending" class="btn btn-blue ml-auto" type="submit">Finish Tags</loading-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import TextInput from '@/Shared/TextInput';
import LoadingButton from '@/Shared/LoadingButton';
import WatchesForErrors from 'Mixins/WatchesForErrors';

export default {
    components: {
        TextInput,
        LoadingButton,
    },
    remember: {
        data: ['form'],
        key: () => 'Tags-Finish',
    },
    mixins: [ WatchesForErrors ],
    data () {
        return {
            sending: false,
            submitted: false,
            errorBag: 'tags_finish',
            form: {
                starting_package_number: null,
                ending_package_number: null,
            },
        }
    },
    methods: {
        submit () {
            this.sending = true;
            this.submitted = true;
            this.$inertia.put(this.route('tags.finish.multiple'), this.form, { preserveScroll: true }).then(() => {
                this.sending = false;
            })
        },
        resetForm () {
            this.form.starting_package_number = null;
            this.form.ending_package_number = null;
        },
    },
}
</script>
