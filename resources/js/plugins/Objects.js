import Sugar from 'sugar';

export default {
    install (Vue, options) {
        Vue.prototype.$obj = Sugar.Object;
    },
}
