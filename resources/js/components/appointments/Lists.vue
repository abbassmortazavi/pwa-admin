<script setup>

import {computed, onMounted, ref} from "vue";
import axios from "axios";

let appointments = ref([]);
let getAllStatus = ref([]);
let selectedStatus = ref(null);

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
                            <a href="">
                                <button class="btn btn-primary"><i class="fa fa-plus-circle mr-1"></i> Add New
                                    Appointment
                                </button>
                            </a>
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
                                    <td>{{ appointment.start_time }}</td>
                                    <td>{{ appointment.end_time }}</td>
                                    <td>
                                        <span class="badge" :class="`badge-${appointment.status.color}`">{{
                                                appointment.status.name
                                            }}</span>
                                    </td>
                                    <td>
                                        <a href="">
                                            <i class="fa fa-edit mr-2"></i>
                                        </a>

                                        <a href="">
                                            <i class="fa fa-trash text-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<style scoped>

</style>
