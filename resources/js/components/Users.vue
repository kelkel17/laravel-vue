<template>
    <div class="container">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">User List</h3>

                    <div class="card-tools d-flex align-items-center w-75 justify-content-between">
                        <div class="input-group input-group-sm w-75">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>

                        <a data-toggle="modal" data-target="#addNewModal"><i class="fas fa-user-plus text-success"></i></a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0 h-100">
                    <table class="table table-head-fixed">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Joined At</th>
                                <th>Modify</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user, index in users" :key="user.id">
                                <td>{{ doMath(index) }}</td>
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td>{{ user.role | capitalize }}</td>
                                <td>{{ user.created_at | moment }}</td>
                                <td>
                                    <a href="#">
                                        <i class="fa fa-edit text-warning"></i>
                                    </a> | <a href="#" @click.prevent="deleteUser(user.id)">
                                        <i class="fa fa-trash text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="addNewModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="createUser" @keydown="form.onKeydown($event)">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input v-model="form.name" type="text" name="name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input v-model="form.email" type="email" name="email"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input v-model="form.password" type="password" name="password"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Role</label>
                                <select name="role" v-model="form.role" id="role" class="form-control" :class="{ 'is-invalid': form.errors.has('role') }">
                                    <option value="">Select User Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">Standard User</option>
                                    <option value="author">Author</option>
                                </select>
                                <has-error :form="form" field="role"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button :disabled="form.busy" type="submit" class="btn btn-primary">Create User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                users: {},
                form: new Form({
                    name: '',
                    email: '',
                    password: '',
                    role: '',
                })
            }
        },
        methods: {
            loadUsers() {
                this.form.get('api/user')
                    .then(({ data }) => { this.users = data });
            },
            doMath: function (index) {
                return parseInt(index, 10) + 1;
            },
            createUser() {
                this.$Progress.start();
                this.form.post('api/user')
                    .then(({ data }) => {
                        this.$Progress.finish();
                        toast.fire({
                          type: 'success',
                          title: `${data.name} successfully added`
                        }).then(() => {
                            this.$emit('loadNewUser');
                            $('#addNewModal').modal('hide');
                            this.form.reset();
                        })
                    })
                    .catch(() => {
                        this.$Progress.finish();
                        Swal.fire({
                          type: 'error',
                          title: "Something went wrong!",
                          text: "User was not added, please try again",
                        }).then(() => {
                            $('#addNewModal').modal('hide');
                        })
                    });
            },
            deleteUser(id) {
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.value) {
                    this.form.delete(`api/user/${id}`)
                    .then((response) => {
                        Swal.fire(
                          'Deleted!',
                          'Your file has been deleted.',
                          'success'
                        )
                        this.$emit('loadNewUser');
                    })
                    .catch(() => {})
                  }
                })
            }
        },
        created() {
            this.loadUsers();
            this.$on('loadNewUser', () => {
                this.loadUsers();
            })
        }
    }
</script>
