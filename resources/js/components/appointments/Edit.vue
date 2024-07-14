<script setup>
import {onMounted, reactive, ref} from "vue";
import axios from "axios";
import {useRoute, useRouter} from "vue-router";
import {useToastr} from "../../toastr.js";
import flatpickr from "flatpickr";
import "flatpickr/dist/themes/light.css";

//const toastr = useToastr();
const router = useRouter();
const route = useRoute()

let errors = ref([]);
let clients = ref([]);
let appointmentId = ref(null);

const form = reactive({
    'title': '',
    'client_id': '',
    'start_date': '',
    'end_time': '',
    'description': '',
})
onMounted(() => {
    flatpickr(".flatpikcr", {
        enableTime: true,
        dateFormat: "Y-m-d H:i K",
    });
    getAppointment();
    getClient();
});
const getAppointment = () => {
    axios.get(`/api/appointments/${route.params.id}` )
        .then(res => {
            form.value = res.data;
        }).catch(err => {
        errors.value = err.response.data.errors;
    })
}
const getClient = () => {
    axios.get('/api/clients')
        .then(res => {
            clients.value = res.data
        }).catch(err => {
        console.log(err);
    })
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
                            <form>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" v-model="form.value.title" class="form-control" id="title"
                                                   placeholder="Enter Title" :class="{'is-invalid': errors.title}">
                                            <span class="invalid-feedback"
                                                  v-if="errors && errors.title">{{ errors.title[0] }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="client">Client Name</label>
                                            <select id="client" v-model="form.value.client_id" class="form-control"
                                                    :class="{'is-invalid': errors.client_id}">
                                                <option :value="client.id" v-for="client in clients">
                                                    {{ client.first_name }}
                                                </option>
                                            </select>
                                            <span class="invalid-feedback"
                                                  v-if="errors && errors.client_id">{{ errors.client_id[0] }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date">Start Date</label>
                                            <input type="date" v-model="form.start_date" class="form-control flatpikcr"
                                                   id="date" :class="{'is-invalid': errors.start_date}">
                                            <span class="invalid-feedback"
                                                  v-if="errors && errors.start_date">{{ errors.start_date[0] }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="time">End Time</label>
                                            <input type="time" class="form-control flatpikcr" v-model="form.end_time"
                                                   id="time" :class="{'is-invalid': errors.end_time}">
                                            <span class="invalid-feedback"
                                                  v-if="errors && errors.end_time">{{ errors.end_time[0] }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" v-model="form.description" rows="3"
                                              placeholder="Enter Description"
                                              :class="{'is-invalid': errors.description}"></textarea>
                                    <span class="invalid-feedback"
                                          v-if="errors && errors.description">{{ errors.description[0] }}</span>
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
