
import { profileEdit } from "../helpers/auth";

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
            console.log('setup maethod ',this.avatarPath);
        },
        edit() {
            let formData = new FormData();
            formData.append('email', this.form.email);
            formData.append('password', this.form.password);
            formData.append('newPassword', this.form.newPassword);
            formData.append('confirmNewPassword', this.form.confirmNewPassword);
            formData.append('name', this.form.name);

            let avatar = document.getElementById('avatar');

            formData.append('avatar', avatar.files[0]);

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