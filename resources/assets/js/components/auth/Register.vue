<template>
    <div class="login row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Register</div>
                <div class="card-body">
                    <form @submit.prevent="register">
                        <div class="form-group row">
                            <label for="email">Email:</label>
                            <input type="email" v-model="form.email" class="form-control" placeholder="Email Address">
                        </div>
                        <div class="form-group row">
                            <label for="email">Name:</label>
                            <input type="text" v-model="form.name" class="form-control" placeholder="Name">
                        </div>
                        <div class="form-group row">
                            <label for="password">Password:</label>
                            <input type="password" v-model="form.password" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group row">
                            <label for="password">Corfirm password:</label>
                            <input type="password" v-model="form.corfirmPassword" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group row">
                            <input type="submit" value="Register">
                        </div>
                        <div class="form-group row" v-if="authError">
                            <p class="error">
                                {{ authError }}
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { registration } from "../../helpers/auth";

export default {
  name: "register",
  data() {
    return {
      form: {
        email: "test@gmail.com",
        password: "qazwsxedc",
        corfirmPassword: "qazwsxedc",
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
            console.log('Data from server ');
            console.log(res.data);
          //this.$store.commit("loginSuccess", res);
          //this.$router.push({ path: "/" });
        })
        .catch(error => {
          console.log(error);
          //this.$store.commit("loginFailed", { error });
        });
    }
  },
  computed: {
    authError() {
      return this.$store.getters.authError;
    }
  }
};
</script>

<style scoped>
.error {
  text-align: center;
  color: red;
}
</style>

