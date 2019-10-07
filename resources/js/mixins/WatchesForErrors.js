import { has, get } from 'lodash'

export default {
    data () {
        return {
            errorField: 'id',
            errorBag: 'default',
        }
    },
    watch: {
        '$page.errors': {
            immediate: true,
            handler (newErrors) {
                if (has(newErrors, this.errorBag) && ! this.form) {
                    let errorBag = get(newErrors, this.errorBag);

                    if (has(errorBag, this.errorField)) {
                        this.$page.warning.warning = get(errorBag, this.errorField[0]);
                    }
                }
                if (! has(newErrors, this.errorBag) && this.form && this.submitted) {
                    this.submitted = false;
                    this.resetForm();
                    this.$inertia.visit(window.location.pathname, { method: 'get', data: {}, preserveScroll: false, preserveState: false });
                }
            },
            deep: true,
        },
    },
}
