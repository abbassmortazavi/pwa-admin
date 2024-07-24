<script setup>

import {computed, onMounted, reactive, ref} from "vue";
import axios from "axios";
import flatpickr from "flatpickr";
import "flatpickr/dist/themes/light.css";
import {useRouter} from "vue-router";
import {useToastr} from "../../toastr.js";
import Swal from "sweetalert2";

const toastr = useToastr();
const router = useRouter();

let appointments = ref([]);
let getAllStatus = ref([]);
let errors = ref([]);
let clients = ref([]);
let selectedStatus = ref(null);
const form = ref({
    id: '',
    title: '',
    client_id: '',
    description: '',
    start_date: '',
    end_time: '',
})
const getClient = () => {
    axios.get('/api/clients')
        .then(res => {
            clients.value = res.data
        }).catch(err => {
        console.log(err);
    })
}
const getStatus = () => {
    axios('/api/appointment-status').then(res => {
        getAllStatus.value = res.data;
    }).catch(err => {
        console.log(err);
    });
}


onMounted(() => {
    getAppointments();
    getStatus();
    selectedStatus.value = null;
    getClient();
    flatpickr(".flatpikcr", {
        enableTime: true,
        dateFormat: "Y-m-d H:i k",
    });
});
const appointmentCount = computed(() => {
    return getAllStatus.value.map(status => status.count).reduce((sum, count) => sum + count, 0);
})
const getAppointments = (status) => {
    let params = {};
    if (status === null) {
        selectedStatus.value = null;
    } else {
        selectedStatus.value = status;
    }
    if (status) {
        params.status = status;
    }
    axios('/api/appointments', {
        params: params
    }).then(res => {
        appointments.value = res.data.data.data;
    }).catch(err => {
        console.log(err);
    });
}
const editAppointment = (appointment) => {
    $('#modal-secondary').modal('show');
    form.value = appointment;
}
const update = () => {
    axios.put(`/api/appointments/${form.value.id}`, form.value)
        .then(res => {
            toastr.success('Appointment Updated Successfully!!!');
            $('#modal-secondary').modal('hide');
            getAppointments();
        }).catch(err => {
        console.log(err);
    });
}
const deleteAppointment = (appointment) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to Delete this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`/api/appointments/${appointment.id}`)
                .then(res => {
                    toastr.success('Appointment Deleted Successfully!!!');
                    setTimeout(() => {
                        getAppointments();
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success",
                            timer: 2000,
                            timerProgressBar: true,
                        });
                    }, 2000)

                }).catch(err => {
                toast.fire({
                    icon: "error",
                    title: "Please Check The Requirements!!!"
                });
            });
        }
    });
}
</script>

<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Appointments Page </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Starter Page</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-between mb-2">
                        <div>

                            <router-link to="/admin/appointments/create" class="btn btn-primary"><i
                                class="fa fa-plus-circle mr-1"></i> Add New
                                Appointment
                            </router-link>

                        </div>
                        <div class="btn-group">
                            <button type="button" @click="getAppointments(null)" class="btn"
                                    :class="[ selectedStatus === null ? 'btn-secondary' : 'btn-default']">
                                <span class="mr-1">All</span>
                                <span class="badge badge-pill badge-info">{{ appointmentCount }}</span>
                            </button>

                            <button v-for="status in getAllStatus" type="button"
                                    @click="getAppointments(status.value)"
                                    class="btn"
                                    :class="[selectedStatus === status.value ? 'btn-secondary' : 'btn-default']">
                                <span class="mr-1">{{ status.name }}</span>
                                <span class="badge badge-pill" :class="`badge-${status.color}`">{{
                                        status.count
                                    }}</span>
                            </button>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Client Name</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Options</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="appointment in appointments">
                                    <td>{{ appointment.id }}</td>
                                    <td>{{ appointment.client.full_name }}</td>
                                    <td>{{ appointment.start_date }}</td>
                                    <td>{{ appointment.end_time }}</td>
                                    <td>
                                        <span class="badge" :class="`badge-${appointment.status.color}`">{{
                                                appointment.status.name
                                            }}</span>
                                    </td>
                                    <td>
                                        <a role="button" @click.prevent="editAppointment(appointment)"><i
                                            class="fa fa-edit mr-2"></i></a>
                                        <a role="button" @click="deleteAppointment(appointment)"><i
                                            class="fa fa-trash text-danger"></i></a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="modal-secondary">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Appointment</h4>
                        <button type="button" class="close text-red" aria-label="Close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="update()">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" v-model="form.title" class="form-control" id="title"
                                           placeholder="Enter Title" :class="{'is-invalid': errors.title}">
                                    <span class="invalid-feedback"
                                          v-if="errors && errors.title">{{ errors.title[0] }}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="client">Client Name</label>
                                    <select id="client" v-model="form.client_id" class="form-control"
                                            :class="{'is-invalid': errors.client_id}">
                                        <option :value="client.id" v-for="client in clients"
                                                :key="client.id">
                                            {{ client.first_name }}
                                        </option>
                                    </select>
                                    <span class="invalid-feedback"
                                          v-if="errors && errors.client_id">{{ errors.client_id[0] }}</span>
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
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-outline-primary" value="Save Data"/>
                        </div>
                    </form>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>

</template>

<style scoped>

</style>
