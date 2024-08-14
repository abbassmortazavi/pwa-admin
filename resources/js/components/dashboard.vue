<script setup>
import {onMounted, ref} from "vue";
import axios from "axios";

const count = ref(0);
const selectedAppointmentStatus = ref('all');
const getCountAppointment = () => {
    axios.get('/api/appointments-status', {
        params: {
            status: selectedAppointmentStatus.value
        }
    }).then(res => {
        count.value = res.data;
    })
    console.log(selectedAppointmentStatus.value);
}
onMounted(()=>{
    getCountAppointment();
})
</script>

<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard Page</h1>
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
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <div class="d-flex justify-content-between">
                                <h3>{{ count }}</h3>
                                <select v-model="selectedAppointmentStatus" @change="getCountAppointment()"
                                        style="height: 2rem; outline: 2px solid transparent;"
                                        class="px-1 rounded border-0">
                                    <option value="all">All</option>
                                    <option value="1">Scheduled</option>
                                    <option value="2">Confirmed</option>
                                    <option value="3">Cancelled</option>
                                </select>
                            </div>
                            <p>Appointments</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>

                        <router-link to="/admin/appointments" class="small-box-footer">
                            View Appointments
                            <i class="fas fa-arrow-circle-right"></i>
                        </router-link>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <div class="d-flex justify-content-between">
                                <h3>0</h3>
                                <select
                                    style="height: 2rem; outline: 2px solid transparent;" class="px-1 rounded border-0">
                                    <option value="TODAY">Today</option>
                                    <option value="30">30 days</option>
                                    <option value="60">60 days</option>
                                    <option value="360">360 days</option>
                                    <option value="MTD">Month to Date</option>
                                    <option value="YTD">Year to Date</option>
                                </select>
                            </div>
                            <p>Users</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <router-link to="/admin/users" class="small-box-footer">
                            View Users
                            <i class="fas fa-arrow-circle-right"></i>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
