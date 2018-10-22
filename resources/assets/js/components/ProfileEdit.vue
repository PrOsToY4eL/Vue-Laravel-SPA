<template>
    <div class="login row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Profile Edit</div>
                <div class="card-body">
                    <form @submit.prevent="edit">
                        <div class="form-group row">
                            <input id="avatar" type="file" v-on:change="uploadFile" class="form-control"
                                   placeholder="Upload your avatar">
                        </div>
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
                            <input id="password" type="password" v-model="form.password" class="form-control" placeholder="Current password">
                        </div>
                        <div class="form-group row">
                            <label for="new-password">New password:</label>
                            <input id="new-password" type="password" v-model="form.newPassword" class="form-control" placeholder="New password">
                        </div>
                        <div class="form-group row">
                            <label for="confirm-new-password">Confirm new password:</label>
                            <input id="confirm-new-password" type="password" v-model="form.confirmNewPassword" class="form-control" placeholder="Confirm password">
                        </div>
                        <div class="form-group row">
                            <span class="danger" v-show="form.newPassword !== form.confirmNewPassword">Your confirm password is incorrect</span>
                            <span class="success" v-show="form.newPassword === form.confirmPassword" >Your confirm password is correct</span>
                        </div>

                        <div class="form-group row">
                            <input type="submit" value="Edit profile">
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

<script src="./ProfileEdit.js"></script>

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

