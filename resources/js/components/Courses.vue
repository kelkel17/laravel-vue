<template>
    <div class="container">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Course List</h3>

                    <div class="card-tools d-flex align-items-center w-75 justify-content-between">
                        <div class="input-group input-group-sm w-75">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                        <a @click="newUserModal"><i class="fas fa-book-medical text-success"></i></a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0 h-100">
                    <table class="table table-head-fixed">
                        <thead>
                            <tr>
                                <th>Course ID</th>
                                <th>Course Name</th>
                                <th>Course Details</th>
                                <th>Mastery Score</th>
                                <th>Owner</th>
                                <th>Last modified</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1234</td>
                                <td>Test Course</td>
                                <td>This is a test Course</td>
                                <td>100</td>
                                <td>Sun Asterisk</td>
                                <td>July 20, 2019</td>
                            </tr>
                            <!-- <tr v-for="user, index in users" :key="user.id">
                                <td>{{ doMath(index) }}</td>
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td>{{ user.role | capitalize }}</td>
                                <td>{{ user.created_at | moment }}</td>
                                <td>
                                    <a href="#" @click="editUserModal(user)">
                                        <i class="fa fa-edit text-warning"></i>
                                    </a> |
                                    <a href="#" @click.prevent="deleteUser(user.id)">
                                        <i class="fa fa-trash text-danger"></i>
                                    </a>
                                </td>
                            </tr> -->
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
                        <h5 class="modal-title" id="exampleModalLongTitle">{{ editMode ? 'Update User' : 'Add User' }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? updateUser() : createUser()" @keydown="form.onKeydown($event)">
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
                            <button :disabled="form.busy" type="submit" class="btn btn-primary">{{ editMode ? 'Update' : 'Create User' }}</button>
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
                editMode: false,
                users: {},
                form: new Form({
                    id: '',
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
            newUserModal() {
                this.editMode = false;
                this.form.reset();
                $('#addNewModal').modal('show');
            },
            editUserModal(user) {
                this.editMode = true;
                this.form.reset();
                $('#addNewModal').modal('show');
                this.form.fill(user);
            },
            afterRequest(data, type) {
                this.$Progress.finish();
                let title;

                if (type == 'create') {
                    title = `${data.name} successfully added`
                } else {
                    title = `${data.name}'s information has been updated successfully`
                }

                toast.fire({
                  type: 'success',
                  title: title
                }).then(() => {
                    this.$emit('loadNewUser');
                    $('#addNewModal').modal('hide');
                })
            },
            createUser() {
                this.$Progress.start();
                this.form.post('api/user')
                    .then(({ data }) => {
                        this.afterRequest(data, 'create');
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },
            updateUser() {
                this.$Progress.start();
                this.form.put(`api/user/${this.form.id}`)
                .then(({ data }) => {
                    this.afterRequest(data, 'update');
                })
                .catch(() => {
                    this.$Progress.fail();
                })
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
            },
        },
        created() {
            this.loadUsers();
            this.$on('loadNewUser', () => {
                this.loadUsers();
            })
        }
    }
</script>