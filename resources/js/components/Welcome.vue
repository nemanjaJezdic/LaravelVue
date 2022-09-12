<template>
   <div class="container" id="parent">
        <h1 class="text-center">{{ title }}</h1>
        Unesi element lise: <input type="text" ref="input"/>
        <button type="button" @click="insert" ref="button">Unesi</button>
        <button type="button" @click="remove" ref="buttondelete">Izbrisi</button>
         <ul>
             <li v-for:="item in list" ref="list">
               {{ item }} 
              </li>
        </ul>
        <div class="circle" ref="circle">

        </div>
    </div>
    
    
</template>

<script>
export default {
    data(){
        return {
            title:'Hello vue',
            list:[]
        }
    },
    methods:{
       insert(){
         this.list.push(this.$refs.input.value)
         if(this.list.length>4){
            this.$refs.circle.style.backgroundColor="red"
         }
       },
       remove(){
          this.list.pop()
          if(this.list.length<=4){
            this.$refs.circle.style.backgroundColor="green"
          }
       }      
    }
}
</script>

<style scoped>
   .parent{
    position:relative;
   }
   .circle{
    position: absolute;
    left:50%;
    top:50%;
     width: 100px;
     height: 100px;
     background-color:green;
     border-radius:50%;
   }
</style>