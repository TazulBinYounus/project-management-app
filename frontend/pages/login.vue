<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        Login
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="userLogin" @keydown="loginForm.onKeydown($event)">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" v-model="loginForm.email" name="email" class="form-control" placeholder="Enter name" :class="{ 'is-invalid': loginForm.errors.has('email') }">
                                <has-error :form="loginForm" field="email"></has-error>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" v-model="loginForm.password" class="form-control" name="password" placeholder="Enter password" :class="{ 'is-invalid': loginForm.errors.has('password') }">
                                <has-error :form="loginForm" field="password"></has-error>
                            </div>
                            <div class="form-group d-flex justify-content-between">

                                <button type="submit" :disabled="loginForm.busy" class="btn btn-primary">Login</button>
                                <nuxt-link :to="{ name: 'registration' }">Don't have Account?</nuxt-link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    auth: 'guest',
    data() {
        return {
            loginForm: this.$vform({
                email: '',
                password: ''
            }),
        }
    },
    methods: {
        async userLogin() {
            try {
                let { data } = await this.loginForm.post('/login');
                await this.$auth.setUserToken(data.access_token);
                this.loginForm.reset();
            } catch (err) {
                console.log(err)
            }
        }
    }
}
</script>
