<style scoped>
    .img-profile {
        height:128px;
        width:128px;

    }
</style>

<template>
    <div>
    <div class="container" v-show="false">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header text-white" style="background-color: #343A40">
                <h3 class="widget-user-username">Elizabeth Pierce</h3>
                <h5 class="widget-user-desc">Web Designer</h5>
              </div>
              <div class="widget-user-image">
                <img class="img-circle" src="https://cdn3.iconfinder.com/data/icons/avatars-9/145/Avatar_Dog-512.png" alt="User Avatar">
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">3,200</h5>
                      <span class="description-text">SALES</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">13,000</h5>
                      <span class="description-text">FOLLOWERS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="description-header">35</h5>
                      <span class="description-text">PRODUCTS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            </div>
        </div>
    </div>
    <div class="container" v-show="edit_form">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title mb-0">Profile</h3>
            </div>
            <div class="col-md-12">
                <div class="card-widget widget-user">
                    <div class="tab-pane active" id="settings">
                      <form @submit.prevent="updateUser()" class="form-horizontal mt-3">
                      <!--   <div class="form-group">
                            <div class="widget-user-image">
                                <img class="img-circle" src="https://cdn3.iconfinder.com/data/icons/avatars-9/145/Avatar_Dog-512.png" alt="User Avatar">
                          </div>
                        </div> -->
                            <div class="form-group">
                                <label for="inputProfilePicture" class="col-sm-2 control-label">Profile Picture</label>
                                <div class="col-sm-10">
                                    <img class="img-circle img-profile" :src="`/img/profile/` + form.profile_picture" alt="User Avatar" v-if="form.profile_picture">
                                    <img class="img-circle img-profile" :src="`/img/customer-service.png`" alt="User Avatar" v-else>
                                    <input type="file" @change="uploadProfile" class="form-input" id="inputProfilePicture" :disabled="!mode">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" class="form-control" id="inputName" placeholder="Name" v-model="form.name" :disabled="!mode" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="inputEmail" placeholder="Email" v-model="form.email" :disabled="!mode">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10">
                                    <label>Role</label>
                                    <select name="role" v-model="form.role" id="role" class="form-control" :class="{ 'is-invalid': form.errors.has('role') }" :key="form.role" :disabled="!mode">
                                        <option value="" >Select User Role</option>
                                        <option value="admin">Admin</option>
                                        <option value="user">Standard User</option>
                                        <option value="author">Author</option>
                                    </select>
                                    <has-error :form="form" field="role"></has-error>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10" v-if="mode">
                                    <button type="submit" class="btn btn-success">Finish</button>
                                </div>
                            <div class="col-sm-offset-2 col-sm-10" v-else>
                            <button class="btn btn-info" @click.prevent="mode = !mode">Edit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</template>

<script>
    export default {
        data() {
            return {
                form: new Form({
                    id:'',
                    name: '',
                    email: '',
                    role: '',
                    profile_picture: '',
                }),
                edit_form: true,
                mode: false,
            };
        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
            this.form.get("api/profile").then(({ data }) => (this.form.fill(data)));
        },
       methods : {
            loadUser() {
                this.form.get("api/profile").then(({ data }) => (this.form.fill(data)));
            },
            updateUser() {
                if(this.edit_form == true){
                    this.$Progress.start();
                    this.form.put(`api/profile`)
                    .then(({ data }) => {
                        this.afterRequest(data, 'update');
                        this.mode = !this.mode;
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
                }
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
            uploadProfile(e) {
                let file = e.target.files[0];
                let reader = new FileReader();

                reader.onloadend = (file) => {
                    this.form.profile_picture = reader.result;
                }
                reader.readAsDataURL(file);
            }
        }
    }
</script>
