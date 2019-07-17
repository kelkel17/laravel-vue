<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Latest Activities</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>User</th>
                                        <th>Activity</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="activity in activities" :key="activity.id">
                                        <td>{{ activity.user.id }}</td>
                                        <td>{{ activity.user.name }}</td>
                                        <td>{{ activity.content }}</td>
                                        <td>{{ activity.created_at | moment }}</td>
                                        <td>{{ activity.created_at | time }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All
                            Activities</a>
                    </div>
                    <!-- /.card-footer -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                activities: {},
                form: new Form({
                    user_id: '',
                    content: '',
                    created_at: ''
                })
            }
        },
        methods: {
            loadActivities() {
                this.form.get('api/activity').then(({data}) => (this.activities = data));
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
            this.loadActivities();
        }
    }

</script>
