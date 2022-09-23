<template>
  <div class="container">
    <div class="card mt-3 mx-auto" style="width: 18rem">
      <img
        class="card-img-top"
        :src="'/images/' + info.cover"
        alt="Card image cap"
      />
      <div class="card-body">
        <h5 class="card-title">{{ info.title }}</h5>
        <p class="card-text">
           {{ info.text }}
        </p>
        <p class="card-text">
          Created: {{ format_date(info.created_at) }}
        </p>
        <p class="card-text">
          Autor: {{ info.fullname }}
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import moment from "moment";
export default {

  data() {
    return {
      info: {
        cover: '',
        title:'',
        text:'',
        created:'',
        autor:''
      }
    };
  },
  mounted() {
    axios
      .get("/admin/onenews", {
        params: {
          id: this.$parent.newsid,
        },
      })
      .then((response) => (this.info = response.data))
      .catch((error) => console.log(error));
  },
  methods:{
    format_date(value) {
      if (value) {
        return moment(String(value)).format("D.M.Y");
      }
    }
  }
};
</script>

<style scoped>
</style>