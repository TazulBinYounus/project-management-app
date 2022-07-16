<template>
  <div>
    <div class="row justify-content-center">
      <div class="col-6">
        <div class="card">
          <div class="card-header">
            Register
          </div>
          <div class="card-body">
            <form @submit.prevent="submitRegistration" >
              <div class="alert alert-danger text-center" role="alert" v-show="errorMessage">
                Registration Failed! Please Try Again
              </div>

              <div class="alert alert-success text-center" role="alert" v-show="successMessage">
                Registration Successfully Done!
              </div>
              <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" v-model="registerForm.name" class="form-control" name="name"
                       placeholder="Enter email" >
                <div class="text-danger" v-if="errors.length > 0" v-for="error in errors">{{ error.name }}</div>
              </div>

              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" v-model="registerForm.email" class="form-control" name="email"
                       placeholder="Enter email">
                <div class="text-danger" v-if="errors.length > 0" v-for="error in errors">{{ error.email }}</div>
              </div>

              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password"
                       v-model="registerForm.password"
                       class="form-control"
                       name="password"
                       placeholder="Enter password" >
                <div class="text-danger" v-if="errors.length > 0" v-for="error in errors">{{ error.password }}</div>
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
        errors: [],
        errorMessage: false,
        successMessage: false,
        registerForm: {
          name: null,
          email: null,
          password: null
        },
      }
    },
    methods: {
      async userRegister(data) {
        try {
          const response = await this.$axios.post('/registration', data)
          console.log(response)
          this.errorMessage = false;
          this.successMessage = true;
          // this.registerForm.reset();
        } catch (err) {
          console.log(err)
          this.successMessage = false;
          this.errorMessage = true;

        }
      },

      submitRegistration() {
        this.errors = [];

        if (!this.registerForm.name) {
          this.errors.push({
            name: 'Name required.'
          });
        }
        if (!this.registerForm.email) {
          this.errors.push({
            email: 'Email required.'
          });
        }

        if (!this.registerForm.password) {
          this.errors.push({
            password: 'Password required.'
          });
        }

        if (this.registerForm.name && this.registerForm.email && this.registerForm.password) {
          const data = new FormData();
          data.append('name', this.registerForm.name);
          data.append('email', this.registerForm.email);
          data.append('password', this.registerForm.password);
          this.userRegister(data);
        }
      }
    }
  }
</script>
