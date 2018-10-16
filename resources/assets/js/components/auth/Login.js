import {login} from '../../helpers/auth';

export default {
    name: "login",
    data() {
        return {
            form: {
                email: 'test@gmail.com',
                password: 'qazwsxedc'
            },
            error: null
        };
    },
    methods: {
        authenticate() {
            this.$store.dispatch('login');

            login(this.$data.form)
                .then((res) => {
                    this.$store.commit("loginSuccess", res);
                    this.$router.push({path: '/'});
                })
                .catch((error) => {
                    this.$store.commit("loginFailed", {error});
                });
        }
    },
    computed: {
        authError() {
            return this.$store.getters.authError;
        }
    }
}