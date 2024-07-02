<script setup>
import {reactive, ref} from "vue";
import axios from "axios";
import {useRouter} from "vue-router";
import {useToastr} from "../../toastr.js";

const toastr = useToastr();
const router = useRouter();

let errors = ref([])

const form = reactive({
    'title': '',
    'client_id': '',
    'start_date': '',
    'end_time': '',
    'description': '',
})
const createAppointment = () => {
    axios.post('/api/appointments', form)
        .then(res => {
            toastr.success('Appointment Inserted Successfully!!!');
            router.push('/admin/appointments')
        }).catch(err => {
        errors.value = err.response.data.errors;
    });
}
</script>

<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create Appointment</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <router-link to="/admin/dashboard">Home</router-link>
                        </li>
                        <li class="breadcrumb-item">
                            <router-link to="/admin/appointments">Appointments</router-link>
                        </li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form @submit.prevent="createAppointment()">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" v-model="form.title" class="form-control" id="title"
                                                   placeholder="Enter Title" :class="{'is-invalid': errors.title}">
                                            <span class="invalid-feedback" v-if="errors && errors.title">{{ errors.title[0] }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="client">Client Name</label>
                                            <select id="client" v-model="form.client_id" class="form-control" :class="{'is-invalid': errors.client_id}">
                                                <option value="1">Client One</option>
                                                <option value="2">Client Two</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date">Appointment Date</label>
                                            <input type="date" v-model="form.start_date" class="form-control" id="date" :class="{'is-invalid': errors.start_date}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="time">Appointment Time</label>
                                            <input type="time" class="form-control" v-model="form.end_time" id="time">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" v-model="form.description" rows="3"
                                              placeholder="Enter Description" :class="{'is-invalid': errors.description}"></textarea>
                                    <span class="invalid-feedback" v-if="errors && errors.description">{{ errors.description[0] }}</span>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
