<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <ul class="list-group position-relative">
          <div class="container position-absolute top-50 start-50" v-if="loading==true">
            <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
           </div>
          <li
            class="
              list-group-item
              d-flex
              justify-content-between
              align-items-center
            "
            v-if="loading==false"
            v-for:="currency in laravelData.data"
          >
          
            <div class="col-4">
              <img
                :src="'/images/' + currency.cover"
                class="img-fluid"
                alt="quixote"
              />
            </div>
            <div class="title col-4 p-3">
              <p class="fw-bold">Title: <i class="fw-normal">{{currency.title}}</i></p>
              <p class="fw-bold">
                Created: <i class="fw-normal">{{currency.created_at}}</i>
              </p>
              <p class="fw-bold">Autor: <i class="fw-normal">{{currency.fullname}}</i></p>
            </div>
            <div class="text col-4">
              {{ currency.text }}
            </div>          
          </li>     
        </ul>
        <Pagination :data="laravelData" @pagination-change-page="getResults" />
      </div>
    </div>
  </div>
</template>

<script>
import LaravelVuePagination from 'laravel-vue-pagination';
export default {
  components:{
    'Pagination': LaravelVuePagination
  },
  data() {
    return {
      laravelData: {},
      loading:true
    };
  },
   mounted() {
    this.$parent.loadingPosts=true
     this.getResults();
  },
  methods:{
     getResults(page = 1) {
            this.loading=true
            this.$parent.loadingPosts=true
            axios.get('/news?page=' + page)
                .then(response => {
                    this.laravelData = response.data;
                    this.loading=false
                    this.$parent.loadingPosts=false
                });
        }
  },
};
</script>

<style scoped>
.lds-ring {
  display: inline-block;
  position: relative;
  width: 80px;
  height: 80px;
}
.lds-ring div {
  box-sizing: border-box;
  display: block;
  position: absolute;
  width: 64px;
  height: 64px;
  margin: 8px;
  border: 8px solid #dc3545;
  border-radius: 50%;
  animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
  border-color: #dc3545 transparent transparent transparent;
}
.lds-ring div:nth-child(1) {
  animation-delay: -0.45s;
}
.lds-ring div:nth-child(2) {
  animation-delay: -0.3s;
}
.lds-ring div:nth-child(3) {
  animation-delay: -0.15s;
}
@keyframes lds-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>