<template>
    <div class="ks-page">
        <div class="ks-page-content" style="padding-top: 100px">
            <router-link to="/" class="ks-logo">
                <img src="/images/fs-logo.png" style="width: 200px" />
            </router-link>
            <div class="card panel panel-default ks-light ks-panel ks-login">
                <div class="card-block">
                    <form class="form-container" @submit.prevent="login">
                        <div v-show="invalid" class="form-group has-error" style="margin-bottom: 2px; text-align: center">
                            <span class="help-block form-error">*** Username or password doesn't match. ***</span>
                        </div>
                        <h4 class="ks-header">Login</h4>
                        <div class="form-group" :class="{'has-error': errors.has('email')}">
                            <div class="input-icon icon-left icon-lg icon-color-primary">
                                <input type="text" name="email" class="form-control" placeholder="Email/User Name" v-model="loginForm.username" autocomplete="off" autofocus/>
                                <span class="icon-addon">
                                    <span class="la la-at"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group" :class="{'has-error': errors.has('password')}">
                            <div class="input-icon icon-left icon-lg icon-color-primary">
                                <input type="password" name="password" class="form-control" placeholder="Password" v-model="loginForm.password" />
                                <span class="icon-addon">
                                    <span class="la la-key"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <login-button :loading="loading" :options="button" :disabled="!valid" @action="login">Login</login-button>
                        </div>
                    </form>
                    <div align="center" style="padding-top:4px;padding-bottom:7px;">
                        <div class="left-line"><hr /></div>
                        OR
                        <div class="right-line"><hr /></div>
                    </div>
                    <div class="form-group">
                        <a href="/login/google" class="btn btn-danger btn-block google-btn">
                            <i class="fa fa-google-plus-square fa-lg" aria-hidden="true"></i> Login with Google
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped src="./auth.min.css">
</style>

<style type="text/css">
    .google-btn {
        color: white;
        width: 100%;
        background: #d34836;
        border: #d34836;
    }
    .left-line {
        width: 45%;
        float: left;
        position: relative;
        top: -7px;
    }
    .right-line {
        width: 45%;
        float: right;
        position: relative;
        top: -7px;
    }
</style>

<script>
import OAuth from '@common/oauth/OAuth';

import { User } from '@common/model/User';
import LoginButton from '@components/form/button.vue';
import AppMessaging from '@components/messaging.vue';
import jQuery from 'jquery';
import _ from 'lodash';
import defineAbilityFor from '@common/oauth/ability';

/* Mixins */
import StringHelperMixin from '@common/mixin/StringHelperMixin';
import ObjectHelperMixin from '@common/mixin/ObjectHelperMixin';

import { mapActions } from 'vuex';

export default {
    data() {
        return {
            loading: false,
            loginForm: {
                username: '',
                password: ''
            },
            validation: {
                username: {
                    required: true
                },
                password: {
                    required: true
                }
            },
            button: {
                class: 'btn btn-success btn-block',
                width: '100%',
                type: 'submit'
            },
            invalid: false,
            dataInclude: [
                'leaveRequests',
                'leaveCredits'
            ]
        }
    },
    created() {
        let $ = jQuery;
        $(document).ready(function() {
            localStorage.removeItem('vuex');
        });
    },
    methods: {
        ...mapActions({
            setAuth : 'auth/setAuthData',
            getRoles: 'roles/getRoles',
            getLoggedInEmployee: 'employees/getLoggedInEmployee'
        }),
        login() {
            this.loading = true;

            OAuth.authenticate(this.loginForm).then(response => {
                this.loading = false;
                if (response == true) {
                    this.invalid = false;
                    User.me(true).then((res) => {
                        // redirect to dashboard
                        this.setAuth(res);
                        this.getRoles({}); //this is needed for the sidebar. this needs to be loaded first before the sidebar.vue
                        this.getLoggedInEmployee({
                            user_id: res.data.id,
                            include: _.join(this.dataInclude, ',')
                        }); //this is only used during login to insert value in loggedInEmployee.
                        this.$router.push('/dashboard');
                        
                        let roleData = res.data.roles.data.filter(role => role.is_enabled === 1);
                        this.$ability.update(defineAbilityFor(roleData[0]));
                    })
                } else {
                    this.invalid = true;
                }
            });
        }
    },
    computed: {
        valid: function() {
            return !this.isEmpty(this.loginForm.username) && !this.isEmpty(this.loginForm.password);
        }
    },
    components: {
        LoginButton,
        AppMessaging
    },
    mixins: [
        StringHelperMixin,
        ObjectHelperMixin
    ]
}
</script>
