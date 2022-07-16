<template>
    <v-card>
      <div class="container ">
        <div class="row">
          <div class="col-md-10">
            <h4>Project List</h4>
          </div>
          <div class="col-md-2">
            <a  class="btn btn-secondary d-block" href="/projects/create" >Add Project</a>
          </div>
        </div>

      </div>
      <form @submit.prevent="filterProject" @keydown="filterForm.onKeydown($event)">
        <div class="container">
          <div class="row">
            <div class="col-md-3">
              <div class="mb-3">
                <label for="from_date" class="form-label">From Date</label>
                <input type="date" v-model="filterForm.from_date" name="from_date" class="form-control" placeholder="from date" :class="{ 'is-invalid': filterForm.errors.has('from_date') }">
                <has-error :form="filterForm" field="from_date"></has-error>
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label for="to_date" class="form-label">To Date</label>
                <input type="date" v-model="filterForm.to_date" name="to_date" class="form-control" placeholder="to date" :class="{ 'is-invalid': filterForm.errors.has('to_date') }">
                <has-error :form="filterForm" field="to_date"></has-error>
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label for="name" class="form-label">Member Name</label>
                <input type="name" v-model="filterForm.name" name="name" class="form-control" placeholder="Enter name" :class="{ 'is-invalid': filterForm.errors.has('name') }">
                <has-error :form="filterForm" field="name"></has-error>
              </div>
            </div>
            <div class="col-md-2 mt-2 ">
                <label class="form-label"></label>
              <div class="form-group d-flex justify-content-between">
                <button type="submit"  class="btn btn-secondary">Search</button>
              </div>
            </div>
          </div>
        </div>
      </form>

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
        filterForm: this.$vform({
          name: '',
          from_date: '',
          to_date: '',
        }),
        search: '',
        headers: [
          { text: 'Id', value: 'id' },
          { text: 'Project Name', value: 'title' },
          { text: 'Group/workspace ', value: 'group.title' },
          { text: 'Assigned Members', value: 'memberNames' },
          { text: 'Created At', value: 'created_at' },
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
      },
      async filterProject() {
        try {
          console.log(this.filterForm);
          const response = await this.filterForm.post('filter-projects');
          this.desserts = response.data.data;
          this.filterForm.reset();
        } catch (err) {
          console.log(err)
        }
      }
    },




  }
</script>
