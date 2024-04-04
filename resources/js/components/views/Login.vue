<template>
    <!-- Login Content -->
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Login</h1>
                                    </div>

                                    <div v-if="errors.message" class="alert alert-danger">
                                        <strong>Error!</strong> <span>{{ errors.message }}</span>
                                    </div>

                                    <form action="" method="POST" class="user" @submit.prevent="submitForm()">

                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control"
                                                :class="{ 'is-invalid': errors.email }" id="exampleInputEmail"
                                                aria-describedby="emailHelp" placeholder="Enter Email Address"
                                                v-model="form.email">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control"
                                                :class="{ 'is-invalid': errors.password }" id="exampleInputPassword"
                                                placeholder="Password" v-model.trim="form.password">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small"
                                                style="line-height: 1.5rem;">
                                                <input type="checkbox" name="remember" class="custom-control-input"
                                                    id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                                        </div>
                                    </form>
                                    <div class="text-center">
                                        <a class="font-weight-bold small" href="register.html">Forgot password</a>
                                    </div>
                                    <div class="text-center">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Content -->
</template>

<script>
import { initManualClass } from '../../helpers/authUtils'
import { postRequest } from '../../helpers/api'
import useValidate from '@vuelidate/core'
import { required } from '@vuelidate/validators'
import axios from 'axios'
// import { createNamespacedHelpers } from 'vuex'
// const { mapState, mapActions } = createNamespacedHelpers('auth')

export default {
    data() {
        return {
            v$: useValidate(),
            form: {
                email: "",
                password: "",
                rememberme: "",
            },
            errors: {
                email: false,
                password: false,
                message: ""
            },
        };
    },
    computed: {
        checkProperty: function () {
            if (checkValidity === true) return true;
            return false;
        }
    },
    methods: {
        submitForm() {
            this.v$.$validate() // checks all inputs
            if (!this.v$.$error) {
                this.errors.message = ""
                this.attemptLogin()
            } else {
                this.errors.email = !this.form.email
                this.errors.password = !this.form.password
                // this.redirect('dashboard');
            }
        },
        
        attemptLogin() {

            postRequest('admin/login', this.form)
                .then(response => {
                    if (response.status === 200) {
                        this.form.password = "";
                        initManualClass().setAuthToken(response.data.data.token)
                        initManualClass().setAuthData(response.data.data.name)
                        this.$router.push({ name: 'AdminIndex' })
                    }
                }).catch((error) => {
                    this.form.password = ""
                    this.errors.message = error.response.data.message ?? "invalid login details"
                }).finally(() => this.isLoading = false)
        },

        loginWithState() {
            this.$store.dispatch('login', this.form)
                .then(() => this.$router.push({ name: 'AdminIndex' }))
                .catch(error => this.error = error)
        }
        // ...mapActions(['login']),
    },
    validations() {
        return {
            form: {
                email: { required },
                password: { required },
                rememberme: {},
            }
        }
    },
}
</script>