<template>
   <div class="container" id="parent">
        <h1 class="text-center">{{ title }}</h1>
        Unesi element lise: <input type="text" class="border border-success" ref="input"/>
        <button type="button" @click="insert" class="btn btn-primary m-3" ref="button">Unesi</button>
        <button type="button" @click="remove" class="btn btn-danger m-3" ref="buttondelete">Izbrisi</button>
         <ul class="list-group">
             <li v-for:="(item, index) in list" ref="list"  class="list-group-item d-flex justify-content-between">
               <p>{{ item }}</p><button type="button" @click="removeitem(index)" class="btn btn-danger m-3" ref="buttonremove">Izbrisi</button>
              </li>
        </ul>
        <div class="circle" :class="{'bg-danger': list.length > 5, 'bg-success':list.length <=5 }" ref="circle">
                  <p>{{listlength}}</p>
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
       },
       remove(){
          this.list.pop()       
       },
       removeitem(index){
          var newlist=[]
          for(var i=0;i<this.list.length;i++){
            if(i==index){
                continue;
            }
            newlist.push(this.list[i])
          }
          this.list=newlist
       }        
    },
    computed:{
      listlength(){
        return this.list.length
      }
    }  

}
</script>

<style scoped>
  
   .circle{
    position: absolute;
    left:50%;
    top:50%;
     width: 100px;
     height: 100px;
     background-color:green;
     border-radius:50%;
     padding:10px;
     padding-left:35px;
     color:white;
     font-size:50px;
   }
   
   
</style>