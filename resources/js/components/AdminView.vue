<template>
  <div class="container">
    <h1 class="text-center mt-3">{{ title }}</h1>
    <div class="row mt-3">
         <a href="#" class="col-6 text-center link-info text-decoration-none border p-3 bg-dark" @click.prevent="loadIns">Insurance</a>
         <a href="#" class="col-6 text-center link-info text-decoration-none border p-3 bg-dark" @click.prevent="loadNews">News</a>
         <a href="#" class="col-6 text-center link-info text-decoration-none border p-3 bg-dark" @click.prevent="loadAdd">Add Insurance</a>
         <a href="/logout" class="col-6 text-center link-info text-decoration-none border p-3 bg-dark">Logout</a>
    </div>  
    <div class="container mt-3">
      <div v-if="show=='news'">
             <news></news>
      </div>    
    </div>
    <div v-if="show=='insurance'">
          <insurance></insurance>
      </div>
      <div v-if="show=='formres'">
          <formres></formres>
      </div>  
  </div>
</template>

<script>
import { defineAsyncComponent } from 'vue'
import Insurance from './AdminIns.vue'
import News from './Adminnews.vue'
import Formres from './Formres.vue'

export default {
  components:{Insurance, News ,Formres},
  data() {
    return {
      title: "Admin view",
      show:'',
    };
  },
  methods:{
    loadIns(){
      this.show="insurance"
    },
    loadNews(){
       this.show="news"
    },
    loadAdd(){
      this.show="formres"
    }
  }
};
</script>

<style scoped>
</style>