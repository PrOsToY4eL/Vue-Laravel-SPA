export default {
    name: 'home',
    computed: {
        welcome() {
            return this.$store.getters.welcome
        }
    }
}