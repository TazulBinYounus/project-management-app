<template>
  <div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <nuxt-link class="navbar-brand" :to="{ name: 'index'}">Project Management App</nuxt-link>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <nuxt-link v-if="!loggedIn" class="nav-link" :to="{ name: 'login' }">Login</nuxt-link>
            </li>
            <li class="nav-item">
              <nuxt-link v-if="!loggedIn" class="nav-link" :to="{ name: 'registration' }">Register</nuxt-link>
            </li>

            <li class="nav-item">
              <nuxt-link v-if="loggedIn" class="nav-link" :to="{ name: 'projects' }">Projects</nuxt-link>
            </li>



            <li class="nav-item">
              <span v-if="loggedIn" class="nav-link" >
                {{ user.data.name }}({{ user.data.email}})
              </span>
            </li>



            <li class="nav-item">
              <a v-if="loggedIn" class=" nav-link text-danger" href="#" @click.prevent="logout">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container mt-3">
      <Nuxt/>
    </div>
  </div>
</template>

<script>
  export default {
    methods: {
      async logout() {
        await this.$auth.logout();
        this.$router.push('login');
      }
    },
    computed: {
      loggedIn() {
        return this.$store.state.auth.loggedIn;
      },
      user() {
        return this.$store.state.auth.user;
      },
    }

  }
</script>

<style>
  @import url('https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css');
</style>
