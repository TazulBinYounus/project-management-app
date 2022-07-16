<template>
  <div>
    <div class="row justify-content-center">
      <div class="col-6">
        <div class="card">
          <div class="card-header">
            Login
          </div>
          <div class="card-body">

            <div class="alert alert-danger text-center" role="alert" v-show="errorMessage">
              Username or password incorrect!
            </div>

            <form @submit.prevent="submitLogin">
              <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email"
                       v-model="loginForm.email"
                       name="email"
                       class="form-control"
                       placeholder="Enter email"
                >
                <div class="text-danger" v-if="errors.length > 0" v-for="error in errors">{{ error.email }}</div>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password"
                       v-model="loginForm.password"
                       class="form-control"
                       name="password"
                       placeholder="Enter password">
                <div class="text-danger" v-if="errors.length > 0" v-for="error in errors">{{ error.password }}</div>

              </div>
              <div class="form-group d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Login</button>
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
        errors: [],
        errorMessage: false,
        loginForm: {
          email: null,
          password:null
        },
      }
    },
    methods: {
      async userLogin(data) {
        const response = await this.$axios.post('/login', data)
        console.log(response)
        if (response.data.code === 200) {
          await this.$auth.setUserToken(response.data.access_token);
          this.loginForm.reset();
        } else {
          this.errorMessage = true;
        }
      },

      submitLogin() {
        this.errors = [];
        if (!this.loginForm.email) {
          this.errors.push({
            email: 'Email required.'
          });
        }

        if (!this.loginForm.password) {
          this.errors.push({
            password: 'Password required.'
          });
        }

        if (this.loginForm.email && this.loginForm.password) {
          const data = new FormData();
          data.append('email', this.loginForm.email);
          data.append('password', this.loginForm.password);
          this.userLogin(data);
        }
      }


    }
  }
</script>
