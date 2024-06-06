<script setup>

</script>

<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Appointments Page</h1>
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
                            <div>
                                <button type="button" class="btn btn-primary">
                                    <i class="fa fa-plus-circle mr-1"></i>
                                    Register User
                                </button>
                                <button type="button" class="btn btn-danger ml-2"><i class="fa fa-trash-alt ml-1"></i>
                                    Delete Selected User
                                </button>
                                <span class="ml-2">Selected 1 Users</span>
                            </div>
                            <div class="float-lg-right">
                                <input type="text" name="search" id="search" class="form-control">
                            </div>
                        </div>
                        <!-- ./card-header -->
                        <div class="card-body">
                            <div class="card-body">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th><input type="checkbox"></th>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Email</th>
                                        <th>Register Date</th>
                                        <th>Options</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr data-widget="expandable-table" aria-expanded="false">
                                        <th><input type="checkbox"></th>
                                        <td>s</td>
                                        <td>s</td>
                                        <td>s</td>
                                        <td>s</td>
                                        <td>
                                            <a class="mr-3 text-info"><i class="fa fa-edit"></i></a>
                                            <a class="text-red"><i class="fa fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tbody>
                                    <tr>
                                        <td colspan="6" class="text-center text-primary"> No Data Found!!</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-2">
                                    <span>Pagination</span>
                                </div>
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
                        <h4 class="modal-title">Add New User</h4>
                        <button type="button" class="close text-red" aria-label="Close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input  type="text" class="form-control" id="name" placeholder="Enter Name">
                                <span class="text-danger fs-6" >error</span>
                            </div>
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email"
                                       placeholder="Enter email">
                                <span class="text-danger fs-6" >error</span>

                            </div>
                            <div class="form-group">
                                <label for="password">Enter Password</label>
                                <input type="password" class="form-control" id="password"
                                       placeholder="Enter password">
                                <span class="text-danger fs-6"></span>

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
