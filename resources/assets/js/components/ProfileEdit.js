
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
            imgExtension: '',
            error: null
        };
    },
    mounted() {
      let user = this.$store.getters.currentUser;
      this.form.email = user.email;
      this.form.name = user.name;
    },
    methods: {
        uploadFile(event) {
            this.imgExtension = event.target.files[0].name.split('.').pop();
        },
        edit() {
            let formData = new FormData();
            formData.append('email', this.form.email);
            formData.append('password', this.form.password);
            formData.append('newPassword', this.form.newPassword);
            formData.append('confirmNewPassword', this.form.confirmNewPassword);
            formData.append('name', this.form.name);
            formData.append('imgExtension', this.imgExtension);

            let avatar = document.getElementById('avatar');

            formData.append('avatar', avatar.files[0]);

            // Display the key/value pairs
            for (var pair of formData.entries()) {
                console.log(pair[0]+ ', ' + pair[1]);
            }
            this.$store.dispatch("edit");

            profileEdit(formData)
                .then(res => {
                    console.log('profile result edit', res);
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