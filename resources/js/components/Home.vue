<template>
  <div>
    <login />
  </div>
  <div v-if="show=='register'">
    <register />
  </div>
  <div v-if="show=='add'">
    <formres />
  </div>
  <div v-if="show=='posts'">
    <post-list />
  </div>

  <div v-if="loadingPosts==false">
    <footerex />
  </div>
</template>

<script>
import Login from './Login.vue'
import Register from './Register.vue'
import Footerex from './Footer.vue'
import Formres from './Formres.vue'
import PostList from './PostList.vue'

export default {
    components:{Login,Register,Footerex,Formres,PostList},
    data(){
        return {
            show:'register',
            loadingPosts:false
        }
    },
    methods:{
        showRegister(){
            this.show="register"
        },
        showAdd(){
            this.show="add"
        },
         showPosts(){
            this.show="posts"
        }
    }

};
</script>

<style>
</style>