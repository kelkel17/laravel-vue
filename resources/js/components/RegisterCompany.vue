<template>
	<div class="container">
		<form @submit.prevent="registerCompany" @keydown="form.onKeydown($event)">
			<div class="row justify-content-center">
				<div class="col-12 col-md-6">
					<div class="card">
						<div class="card-header">Register a Company</div>
						<div class="card-body">
							<div class="form-group">
								<label>Company Name</label>
								<input v-model="form.company_name" type="text" name="company_name"
								class="form-control" :class="{ 'is-invalid': form.errors.has('company_name') }">
								<has-error :form="form" field="company_name"></has-error>
							</div>
							<div class="form-group">
								<label>Company Email</label>
								<input v-model="form.company_email" type="email" name="company_email"
								class="form-control" :class="{ 'is-invalid': form.errors.has('company_email') }">
								<has-error :form="form" field="company_email"></has-error>
							</div>
							<div class="form-group">
								<label>Company Contact Number</label>
								<input v-model="form.company_contact" type="text" name="company_contact"
								class="form-control" :class="{ 'is-invalid': form.errors.has('company_contact') }">
								<has-error :form="form" field="company_contact"></has-error>
							</div>
							<div class="form-group">
								<label>Company Logo</label>
								<input v-on="form.company_logo" type="file" name="company_logo"
								class="" :class="{ 'is-invalid': form.errors.has('company_logo') }">
								<has-error :form="form" field="company_logo"></has-error>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-6">
					<div class="card">
						<div class="card-header">Admin Details</div>
						<div class="card-body">
							<div class="form-group">
								<label>Admin Name</label>
								<input v-model="form.admin_name" type="text" name="admin_name"
								class="form-control" :class="{ 'is-invalid': form.errors.has('admin_name') }">
								<has-error :form="form" field="admin_name"></has-error>
							</div>
							<div class="form-group">
								<label>Admin Email</label>
								<input v-model="form.admin_email" type="email" name="admin_email"
								class="form-control" :class="{ 'is-invalid': form.errors.has('admin_email') }">
								<has-error :form="form" field="admin_email"></has-error>
							</div>
							<div class="form-group">
								<label>Password</label>
								<input v-model="form.password" type="password" name="password"
								class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
								<has-error :form="form" field="password"></has-error>
							</div>
							<div class="form-group">
								<label>Profile Picture</label>
								<input v-on="form.admin_profile_picture" type="file" name="admin_profile_picture"
								class="" :class="{ 'is-invalid': form.errors.has('admin_profile_picture') }">
								<has-error :form="form" field="admin_profile_picture"></has-error>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row justify-content-center">
				<button :disabled="form.busy" type="submit" class="btn btn-primary">Create Company</button>
			</div>
		</form>
	</div>
</template>

<script>
    export default {
        data() {
            return {
	            form: new Form({
	                company_name: '',
	                company_email: '',
	                company_contact: '',
	                company_logo: '',
	                admin_name: '',
	                admin_email: '',
	                admin_profile_picture: '',
	                password: '',
	            })
            }
        },
        methods: {
        	registerCompany() {
        		this.$Progress.start();
                this.form.post('/company/register')
                    .then(({ data }) => {
                        this.$Progress.finish();
		                toast.fire({
		                	type: 'success',
		                	title: `${data.company.company_name} thank you for register and welcome!`
		                }).then(() => {
		                	toast.fire({
		                	type: 'success',
		                	title: `${data.admin.name} has been set as the admin to your company`
		                	}).then(() => {
		                    	window.location.href = "/home";
		                	})
		                })
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
        	}
        }
    }
</script>