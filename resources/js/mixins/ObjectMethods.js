export default {
    methods: {
        isObjectEmpty (obj) {
            return ! Object.values(obj).length >= 1;
        },
        objectContains (obj, needle) {
            if (typeof obj === 'object' && obj !== null) {
                return obj.hasOwnProperty(needle);
            }

            return false;
        },
    },
}
