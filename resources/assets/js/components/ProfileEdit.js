
import { profileEdit } from "../helpers/auth";
import { getFormData } from "../helpers/general";

export default {
    name: "profile-edit",
    data() {
        return {
            form: {
                email: "",
                password: "qazwsxedc",
                newPassword: "qazwsxedc",
                confirmNewPassword: "qazwsxedc",
                name: ""
            },
            avatarPath: null,
            error: null
        };
    },
    mounted(){
      this.setUp();
    },
    methods: {
        setUp(){
            let user = this.$store.getters.currentUser;
            this.form.email = user.email;
            this.form.name = user.name;
            this.avatarPath =  user.avatar;
        },
        edit() {
            let formData = getFormData(this.$data, document.getElementById('avatar'));

            this.$store.dispatch("edit");

            profileEdit(formData)
                .then(res => {
                    console.log('profile result edit', res);
                    this.imgPath = res.avatar;
                    this.$store.commit("editSuccess", res);
                    this.setUp();
                    //this.$router.push({path: '/'});
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