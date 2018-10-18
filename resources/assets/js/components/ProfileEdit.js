
import { edit } from "../helpers/auth";

export default {
    name: "profile-edit",
    data() {
        return {
            form: {
                email: "",
                currentPassword: "qazwsxedc",
                newPassword: "12345678",
                confirmNewPassword: "123456789",
                name: ""
            },
            error: null
        };
    },
    mounted() {
      console.log("profile edit mounted");
      let user = this.$store.getters.currentUser;
      this.form.email = user.email;
      this.form.name = user.name;
    },
    methods: {
        edit() {
            this.$store.dispatch("edit");

            edit(this.$data.form)
                .then(res => {
                    console.log(res);
                    this.$store.commit("editSuccess", res);
                    this.$router.push({path: '/'});
                })
                .catch(err => {
                    this.$store.commit("editFailed", err.response.data );
                });
        }
    },
    computed: {
        authError() {
            return this.$store.getters.authError;
        },
    }
};