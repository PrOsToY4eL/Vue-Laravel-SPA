
import { registration } from "../../helpers/auth";
import {getFormData} from "../../helpers/general";

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

            let formData = getFormData(this.$data, document.getElementById('avatar'));

            registration(formData)
                .then(res => {
                    this.$store.commit("registerSuccess", res);
                    //this.$router.push({path: '/'});
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