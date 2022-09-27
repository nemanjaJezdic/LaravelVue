<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <ul class="list-group">
          <li
            class="
              list-group-item
              d-flex
              justify-content-between
              align-items-center
            "
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
    };
  },
   mounted() {
     this.getResults();
  },
  methods:{
     getResults(page = 1) {
            axios.get('/news?page=' + page)
                .then(response => {
                    this.laravelData = response.data;
                });
        }
  },
};
</script>

<style scoped>
</style>