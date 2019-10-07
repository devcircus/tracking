import { has, get } from 'lodash';

export default {
    data () {
        return {
            errorBag: 'default',
        }
    },
    methods: {
        getErrors (field) {
            let errors = this.$page.errors;

            if (has(errors, this.errorBag)) {
                let errorBag = get(errors, this.errorBag);
                if (has(errorBag, field)) {
                    return get(errorBag, field);
                }
            }

            return [];
        },
    },
}
