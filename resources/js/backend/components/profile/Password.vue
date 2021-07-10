<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Edit Password</h3>
                        <!--<div class="card-tools pull-right">
                            <a href="#" class="btn btn-sm bg-olive">
                                <i class="fa fa-plus"></i>
                                Save
                            </a>
                        </div>-->
                    </div>
                    <form class="form-horizontal">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="offset-sm-1 col-sm-1 col-form-label">Current password</label>
                                <div class="col-sm-8">
                                    <input class="form-control" :class="{'is-invalid': errors.current}" type="password" v-model="password.current">
                                    <small class="form-text text-muted">You must provide your current password in order to change it.</small>
                                    <div class="invalid-feedback" v-if="errors.current">{{errors.current[0]}}</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="offset-sm-1 col-sm-1 col-form-label">New password</label>
                                <div class="col-sm-8">
                                    <input class="form-control" :class="{'is-invalid': errors.email}"  type="email"   v-model="password.password">
                                    <div class="invalid-feedback" v-if="errors.password">{{errors.password[0]}}</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="offset-sm-1 col-sm-1 col-form-label">Password confirmation</label>
                                <div class="col-sm-8">
                                    <input class="form-control" :class="{'is-invalid': errors.password_confirmation}" type="password" v-model="password.password_confirmation">
                                    <div class="invalid-feedback" v-if="errors.password_confirmation">
                                        {{errors.password_confirmation[0]}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a class="btn btn-primary fa-pull-right"  href="" :disabled="submiting" @click.prevent="updatePasswordAuthUser">
                                <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
                                <i class="fas fa-check" v-else></i>
                                <span class="ml-1">Save</span>
                            </a>
                        </div>
                        <!-- /.card-footer -->
                    </form>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                password: {},
                errors: {},
                submiting: false
            }
        },
        methods: {
            updatePasswordAuthUser() {
                if (!this.submiting) {
                    this.submiting = true
                    axios.put(`/backend/api/profile/updatePasswordAuthUser`, this.password)
                        .then(response => {
                            this.password = {}
                            this.errors = {}
                            this.submiting = false
                            this.$toasted.global.error('Password changed!');
                        })
                        .catch(error => {
                            this.errors = error.response.data.errors
                            this.submiting = false
                        })
                }
            }
        }
    }
</script>
