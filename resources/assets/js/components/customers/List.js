export default {
    name: 'list',
    mounted() {
        if (this.customers.length) {
            return;
        }

        this.$store.dispatch('getCustomers');
    },
    computed: {
        customers() {
            return this.$store.getters.customers;
        }
    }
}