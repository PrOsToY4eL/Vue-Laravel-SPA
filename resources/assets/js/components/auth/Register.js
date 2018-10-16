
import { registration } from "../../helpers/auth";

export default {
    name: "register",
    data() {
        return {
            form: {
                email: "test@gmail.com",
                password: "qazwsxedc",
                confirmPassword: "qazwsxedc",
                name: "Yaroslav"
            },
            error: null
        };
    },
    methods: {
        register() {
            this.$store.dispatch("register");

            registration(this.$data.form)
                .then(res => {
                    console.log(res);
                    this.$store.commit("registerSuccess", res);
                    this.$router.push({path: '/'});
                })
                .catch(err => {
                    this.$store.commit("registerFailed", err.response.data );
                });
        }
    },
    computed: {
        authError() {
            return this.$store.getters.authError;
        },
    }
};