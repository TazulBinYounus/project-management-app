<template>
  <div class="container col-md-6 offset-md-3">

    <div class="card">
      <h6 class="container text-center">Create Project</h6>
      <div class="alert alert-success text-center" role="alert" v-show="successMessage">
        Project Created Successfully!
      </div>

      <div class="alert alert-warning text-center" role="alert" v-show="errorMessage">
       Failed! Please try again
      </div>
      <div class="card-body">
        <form @submit.prevent="submitProject">
          <div class="col-md-12">
            <label class="typo__label">Select Group</label>
            <multiselect v-model="form.groupsValue" deselect-label="Can't remove this value" track-by="id" label="title"
                         placeholder="Select one" :options="form.groups" :searchable="false" :allow-empty="false">
              <template slot="singleLabel" slot-scope="{ option }"><strong>{{ option.title }} </strong></template>
            </multiselect>
            <div class="text-danger" v-if="errors.length > 0" v-for="error in errors">{{ error.group }}</div>
          </div>

          <div class="col-md-12">
            <label class="typo__label">Project Title</label>
            <input
              type="text"
              class="form-control"
              id="title"
              name="title"

              v-model="form.title">
            <div class="text-danger" v-if="errors.length > 0" v-for="error in errors">{{ error.title }}</div>
          </div>

          <div class="col-md-12">
            <label class="typo__label">Project Description</label>
            <textarea name="description" id="description" cols="30" rows="2" class="form-control"
                      v-model="form.description"></textarea>
            <div class="text-danger" v-if="errors.length > 0" v-for="error in errors">{{ error.description }}</div>
          </div>


          <div class="col-md-12">
            <label class="typo__label">Add Members</label>
            <multiselect v-model="form.membersValue" tag-placeholder="Add this as new tag"
                         placeholder="Search or add a tag"
                         label="name" track-by="id" :options="form.members" :multiple="true" :taggable="true"
                         @tag="addTag">
            </multiselect>
            <div class="text-danger" v-if="errors.length > 0" v-for="error in errors">{{ error.member }}</div>
          </div>

          <div class="col-md-12">
            <div class="form-group d-flex justify-content-between">
              <button type="submit" class="btn btn-secondary" >Submit</button>
            </div>
          </div>

        </form>

      </div>
    </div>


  </div>
</template>

<script>
  import Vue from 'vue';
  import Multiselect from 'vue-multiselect';
  // register globally
  Vue.component('multiselect', Multiselect)

  export default {
    components: {
      Multiselect,
    },
    name: "create",
    data() {
      return {
        errors: [],
        errorMessage: false,
        form: {
          title: null,
          description: null,
          groupsValue: [],
          groups: [],
          membersValue: [],
          members: [],
          memberIds: [],
        },
      }
    },


    created() {
      this.getGroups();
      this.getMembers();
    },

    methods: {
      async getGroups() {
        try {
          const response = await this.$axios.get('get-groups');
          this.form.groups = response.data.data;
        } catch (err) {
          console.log(err)
        }
      },

      async getMembers() {
        try {
          const response = await this.$axios.get('get-users');
          this.form.members = response.data.data;
          console.log(this.members);
        } catch (err) {
          console.log(err)
        }
      },

      addTag(newTag) {
        const tag = {
          name: newTag,
        }
        this.membersValue.push(tag)
      },

      async storeProject(data) {
        const response = await this.$axios.post('/project-submit', data)
        if(response.data.code === 200){
          this.$router.push({ name: 'projects' })
        }else {
          this.errorMessage = true;
        }
      },

      submitProject() {
        if (this.form.title && this.form.description && this.form.groupsValue.length > 0 && this.form.membersValue.length > 0) {
          this.form.membersValue.forEach((item) => {
            this.form.memberIds.push(item.id);
          });
          const data = new FormData();
          data.append('group_id', this.form.groupsValue.id);
          data.append('title', this.form.title);
          data.append('description', this.form.description);
          data.append('memberIds', this.form.memberIds);
          this.storeProject(data);
        }

        this.errors = [];
        if (!this.form.title) {
          this.errors.push({
            title: 'Title required.'
          });
        }

        if (!this.form.description) {
          this.errors.push({
            description: 'Description required.'
          });
        }

        if (this.form.groupsValue.length <= 0) {
          this.errors.push({
            group:'Group required.'
          });
        }

        if (this.form.membersValue.length <= 0) {
          this.errors.push({
            member:'Members required.'
          });
        }

      },
    }

  }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>

</style>
