export default {
    name: 'view',
    created() {
        if (this.customers.length) {
            this.customer = this.customers.find((customer) => customer.id == this.$route.params.id);
        } else {
            axios.get(`/api/customers/${this.$route.params.id}`)
                .then((response) => {
                    this.customer = response.data.customer
                });
        }
    },
    data() {
        return {
            customer: null
        };
    },
    computed: {
        currentUser() {
            return this.$store.getters.currentUser;
        },
        customers() {
            return this.$store.getters.customers;
        }
    }
}