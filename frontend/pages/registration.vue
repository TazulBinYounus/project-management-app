<template>
  <div>
    <div class="row justify-content-center">
      <div class="col-6">
        <div class="card">
          <div class="card-header">
            Register
          </div>
          <div class="card-body">
            <form @submit.prevent="userRegister" @keydown="registerForm.onKeydown($event)">
              <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" v-model="registerForm.name" class="form-control" name="name"
                       placeholder="Enter email" :class="{ 'is-invalid': registerForm.errors.has('name') }">
                <has-error :form="registerForm" field="name"></has-error>
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="text" v-model="registerForm.email" class="form-control" name="email"
                       placeholder="Enter email" :class="{ 'is-invalid': registerForm.errors.has('email') }">
                <has-error :form="registerForm" field="email"></has-error>
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" v-model="registerForm.password" class="form-control" name="password"
                       placeholder="Enter password" :class="{ 'is-invalid': registerForm.errors.has('password') }">
                <has-error :form="registerForm" field="password"></has-error>
              </div>
              <div class="form-group d-flex justify-content-between">

                <button type="submit" class="btn btn-primary">Register</button>
                <nuxt-link :to="{ name: 'login' }">Already have Account?</nuxt-link>
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
        registerForm: this.$vform({
          name: '',
          email: '',
          password: ''
        }),
      }
    },
    methods: {
      async userRegister() {
        try {
          let data = await this.$axios.post('/registration', this.registerForm);
          await this.$auth.setUserToken(data.data.access_token);
          this.registerForm.reset();
        } catch (err) {
          console.log(err)
        }
      }
    }
  }
</script>
