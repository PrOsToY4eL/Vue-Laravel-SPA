<template>
    <div class="login row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Register</div>
                <div class="card-body">
                    <form @submit.prevent="register">
                        <div class="form-group row">
                            <label for="email">Email:</label>
                            <input id="email" type="email" v-model="form.email" class="form-control" placeholder="Email Address">
                        </div>
                        <div class="form-group row">
                            <label for="name">Name:</label>
                            <input id="name" type="text" v-model="form.name" class="form-control" placeholder="Name">
                        </div>
                        <div class="form-group row">
                            <label for="password">Password:</label>
                            <input id="password" type="password" v-model="form.password" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group row">
                            <label for="confirm">Confirm password:</label>
                            <input id="confirm" type="password" v-model="form.confirmPassword" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group row">
                            <span class="danger" v-show="!(form.password === form.confirmPassword)">Your confirm password is incorrect</span>
                            <span class="success"v-show="form.password === form.confirmPassword" >Your confirm password is correct</span>
                        </div>

                        <div class="form-group row">
                            <input type="submit" value="Register">
                        </div>
                        <div class="form-group row" v-if="authError">
                            <span class="error" v-for="(errs, key) in authError">
                                {{ key }}:
                                <ul>
                            <li v-for="err in errs ">{{ err }}</li>
                        </ul>
                            </span>
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
</script>

<style scoped>
.error {
  text-align: left;
  color: red;
}
    .danger {
        color: red;
    }
    .success  {
        color: green;
    }
</style>

