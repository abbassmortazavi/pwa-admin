<script setup>
import {reactive, ref} from "vue";
import axios from "axios";
import {useRouter} from "vue-router";

const router = useRouter();
const errors = ref([]);
const error = ref('');
const loading = ref(false)
let form = reactive({
    email: '',
    password: '',
});
const handleSubmit = () => {
    loading.value = true;
    error.value = "";
    axios.post('/login', form)
        .then(res => {
            window.location.href = "/admin/dashboard";
        }).catch(err => {

            errors.value = err.response.data.errors;
            error.value = err.response.data.message;
    }).finally(()=>{
        loading.value = false;
    });
}
</script>

<template>
    <div class="login-box">

        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1"><b>Admin</b>Login</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <p class="alert alert-danger" v-if="error">{{ error }}</p>
                <form @submit.prevent="handleSubmit">
                    <div class="input-group mb-3">
                        <input type="email" v-model="form.email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        <small class="text-danger" v-if="errors.email">{{ errors.email[0] }}</small>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" v-model="form.password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <small class="text-danger" v-if="errors.password">{{ errors.password[0] }}</small>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>

                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block" :disabled="loading">
                                <div v-if="loading" class="spinner-border text-warning" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <span v-else>Sign In</span>
                            </button>
                        </div>

                    </div>
                </form>

                <p class="mb-1">
                    <a href="forgot-password.html">I forgot my password</a>
                </p>
            </div>

        </div>
    </div>
</template>

<style scoped>

</style>
