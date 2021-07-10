<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Edit Profile</h3>
                        <!--<div class="card-tools pull-right">
                            <a href="#" class="btn btn-sm bg-olive">
                                <i class="fa fa-plus"></i>
                                Save
                            </a>
                        </div>-->
                    </div>
                    <form class="form-horizontal" v-if="!loading">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="offset-sm-1 col-sm-1 col-form-label">Avatar</label>
                                <div class="col-sm-8">
                                    <small class="form-text text-muted mb-3">You can change your avatar here or remove the
                                        current avatar</small>
                                    <avatar :user="user"></avatar>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="offset-sm-1 col-sm-1 col-form-label">Full Name</label>
                                <div class="col-sm-8">
                                    <input type="text" id="name" class="form-control" :class="{'is-invalid': errors.name}" v-model="user.name">
                                    <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="offset-sm-1 col-sm-1 col-form-label">Email</label>
                                <div class="col-sm-8">
                                    <input type="email" id="email" class="form-control" :class="{'is-invalid': errors.email}" v-model="user.email">
                                    <div class="invalid-feedback" v-if="errors.email">{{errors.email[0]}}</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-8">
                                    <a class="btn btn-link pl-0" :href="passwordUrl">
                                        <span class="ml-1">Change password</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="fa-pull-right">
                                <a class="btn btn-primary"  href="#" :disabled="submiting" @click.prevent="updateAuthUser">
                                    <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
                                    <i class="fas fa-check" v-else></i>
                                    <span class="ml-1">Save</span>
                                </a>
                            </div>
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
    import avatar from './Avatar.vue'

    export default {
        data() {
            return {
                user: {},
                errors: {},
                loading: true,
                submiting: false
            }
        },
        components: {
            avatar
        },
        mounted() {
            this.getAuthUser()
        },
        props: {
            passwordUrl: { default: "/admin/profile/password" },
        },
        methods: {
            getAuthUser() {
                this.loading = true
                axios.get(`/admin/api/profile/getAuthUser`)
                    .then(response => {
                        this.user = response.data
                        this.loading = false
                    })
            },
            updateAuthUser() {
                if (!this.submiting) {
                    this.submiting = true
                    axios.put(`/admin/api/profile/updateAuthUser`, this.user)
                        .then(response => {
                            this.errors = {}
                            this.submiting = false
                            this.$toasted.global.error('Profile updated!');
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
