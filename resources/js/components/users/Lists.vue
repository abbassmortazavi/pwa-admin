<script setup>
import {onMounted, reactive, ref} from "vue";
import axios from "axios";
import {useToastr} from "../../toastr.js";
import Swal from "sweetalert2";
import {formatDate} from "../../helper.js";


let users = ref([]);
let errors = ref([])
const editMode = ref(false)
const toastr = useToastr();

const roles = ref([
    {
        name: 'ADMIN',
        value: 1
    },
    {
        name: 'USER',
        value: 2
    }
]);


const form = ref({
    id: '',
    name: '',
    email: '',
    password: '',
})
onMounted(() => {
    getUsers()
})
const getUsers = () => {
    axios.get('/api/users').then(res => {
        users.value = res.data.data
    }).catch(err => {
        console.log(err)
    })
}
const createUser = () => {
    axios.post('/api/users', form.value).then(res => {
        form.value.name = '';
        form.value.email = '';
        form.value.password = '';
        $('#modal-secondary').modal('hide');
        //users.value.unshift(res.data.data)
        toastr.success('User Created Successfully!!!');
        getUsers();
    }).catch(err => {
        //toastr.error('Please Check The Requirements!!!');
        toast.fire({
            icon: "error",
            title: "Please Check The Requirements!!!"
        });
        errors.value = err.response.data.errors
    })
}

const addUser = () => {
    editMode.value = false;
    errors.value = [];
    form.value.name = "";
    form.value.email = "";
    form.value.password = "";
    $('#modal-secondary').modal('show');
}
const editUser = (user) => {
    editMode.value = true;
    errors.value = [];
    $('#modal-secondary').modal('show');
    form.value.name = user.name;
    form.value.email = user.email;
    form.value.id = user.id;
}

const updateUser = () => {
    axios.put('/api/users/' + form.value.id, form.value)
        .then(res => {
            getUsers();
            $('#modal-secondary').modal('hide');
            // toastr.success('User Update Successfully!!!');
            toast.fire({
                icon: "success",
                title: "User Update Successfully!!!"
            });

        }).catch(err => {
        //toastr.error('Please Check The Requirements!!!');
        toast.fire({
            icon: "error",
            title: "Please Check The Requirements!!!"
        });
        errors.value = err.response.data.errors
    });
}
const handelMethod = () => {
    if (editMode.value) {
        updateUser();
    } else {
        createUser();
    }
}

const deleteUser = (user) => {
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
            axios.delete('/api/users/' + user.id)
                .then(res => {
                    toast.fire({
                        icon: "success",
                        title: res.data.message
                    });
                    getUsers();
                }).catch(err => {
                toast.fire({
                    icon: "error",
                    title: "Please Check The Requirements!!!"
                });
            });
            setTimeout(() => {
                Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success",
                    timer: 2000,
                    timerProgressBar: true,
                });
            }, 2000)
        }
    });
}

const changeRole = (user, role) => {
    axios.put(`/api/user/${user.id}/change-role`, {
        role: role
    }).then(res => {
        console.log(res);
        toast.fire({
            icon: "success",
            title: "User Role Update Successfully!!!"
        });
    }).catch(err => {
        toast.fire({
            icon: "error",
            title: "Please Check The Requirements!!!"
        });
        errors.value = err.response.data.errors
    });
}
</script>

<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">User Page</h1>
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <button @click="addUser" type="button" class="btn btn-primary">
                                Register User
                            </button>
                        </div>
                        <!-- ./card-header -->
                        <div class="card-body">
                            <div class="card-body">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Email</th>
                                        <th>Register Date</th>
                                        <th>Role</th>
                                        <th>Options</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr data-widget="expandable-table" aria-expanded="false"
                                        v-for="(user, index) in users" :key="user.id">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ user.name }}</td>
                                        <td>{{ user.email }}</td>
                                        <td>{{ formatDate(user.created_at) }}</td>
                                        <td>
                                            <select class="form-control"
                                                    @change="changeRole(user, $event.target.value)">
                                                <option v-for="role in roles" :value=" role.value" :selected="(role.name === user.role)">
                                                    {{ role.name }}
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <a class="mr-3 text-info" @click.prevent="editUser(user)"><i
                                                class="fa fa-edit"></i></a>
                                            <a class="text-red" @click.prevent="deleteUser(user)"><i
                                                class="fa fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>

        </div>
        <div class="modal fade" id="modal-secondary">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-if="editMode">Edit User</h4>
                        <h4 class="modal-title" v-else>Add New User</h4>
                        <button type="button" class="close text-red" aria-label="Close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="handelMethod">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input v-model="form.name" type="text" class="form-control"
                                       :class="{'is-invalid': errors.name}" id="name" placeholder="Enter Name">
                                <span class="text-danger fs-6" v-if="errors && errors.name">{{ errors.name[0] }}</span>
                            </div>
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input v-model="form.email" type="email" class="form-control" id="email"
                                       placeholder="Enter email" :class="{'is-invalid': errors.email}">
                                <span class="text-danger fs-6" v-if="errors && errors.email">{{
                                        errors.email[0]
                                    }}</span>

                            </div>
                            <div class="form-group">
                                <label for="password">Enter Password</label>
                                <input v-model="form.password" type="password" class="form-control" id="password"
                                       placeholder="Enter password" :class="{'is-invalid': errors.password}">
                                <span class="text-danger fs-6" v-if="errors && errors.password">{{
                                        errors.password[0]
                                    }}</span>

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
