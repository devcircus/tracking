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
                if (this.$obj.has(newErrors, this.errorBag) && ! this.form) {
                    let errorBag = newErrors[this.errorBag];
                    if (this.$obj.has(errorBag, this.errorField)) {
                        this.$page.warning.warning = errorBag[this.errorField][0];
                    }
                }
                if (! this.$obj.has(newErrors, this.errorBag) && this.form && this.submitted) {
                    this.submitted = false;

                    return this.resetForm();
                }
            },
            deep: true,
        },
    },
}
