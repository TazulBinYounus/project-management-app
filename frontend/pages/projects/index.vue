<template>
    <v-card>
      <div class="container "><h4>Project List</h4></div>
      <v-card-title>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
      </v-card-title>
      <v-data-table
        :headers="headers"
        :items="desserts"
        :search="search"
      ></v-data-table>
    </v-card>
</template>


<script>
  export default {
    middleware: 'auth',

    data () {
      return {
        search: '',
        headers: [
          { text: 'Sl', value: 'id' },
          { text: 'Project Name', value: 'title' },
          { text: 'description', value: 'description' },
          { text: 'Assigned Members', value: 'memberNames' },

        ],
        desserts: [],
      }
    },

    computed: {
      loggedIn(){
        return this.$store.state.auth.loggedIn
      },
      user(){
        return this.$store.state.auth.user
      }
    },

    created() {
      this.getProjects();
    },

    methods: {
      async getProjects() {
        try {
          const response = await this.$axios.get('get-projects');
          this.desserts = response.data.data;
        } catch (err) {
          console.log(err)
        }
      }
    },


  }
</script>
