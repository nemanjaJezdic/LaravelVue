<template>
  <div class="container">
    <h2>Insurances:</h2>
    <table class="table table-striped table-bordered mt-3">
      <thead class="thead-light">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Surname</th>
          <th scope="col">Phone</th>
          <th scope="col">Type</th>
          <th scope="col">Start</th>
          <th scope="col">End</th>
        </tr>
      </thead>
       <div class="container position-absolute top-50 start-50" v-if="loadingIns==true">
            <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
       </div> 
      <tbody v-if="loadingIns==false">
        <tr v-for:="currency in info">
          <th scope="row">{{ currency.id }}</th>
          <td>{{ currency.name }}</td>
          <td>{{ currency.surname }}</td>
          <td>{{ currency.phone }}</td>
          <td v-if="currency.type == 0">Individualno</td>
          <td v-if="currency.type == 1">
            Grupno
            <button
              class="btn btn-primary btn-sm"
              @click="getPersons(currency.id)"
            >
              Show persons
            </button>
          </td>
          <td>{{ format_date(currency.start_date) }}</td>
          <td>{{ format_date(currency.end_date) }}</td>
        </tr>
      </tbody>
    </table>
    <div>
      <vue-final-modal v-model="showModal">
         <div class="container position-absolute top-50 start-50" v-if="loadingPers==true">
            <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
         </div>   
         <div class="container">
      <table class="table table-striped table-bordered mt-3 bg-light" v-if="loadingPers==false">
        <thead class="thead-light">
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Surname</th>
            <th scope="col">Birthdate</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for:="pers in persons">
            <td>{{ pers.name }}</td>
            <td>{{ pers.surname }}</td>
            <td>{{ format_date(pers.birth_date) }}</td>
          </tr>
        </tbody>
      </table>
    </div>
      </vue-final-modal>
    </div>
  </div>
</template>

<script>
import moment from "moment";
import { $vfm, VueFinalModal, ModalsContainer } from "vue-final-modal";

export default {
  components: {
    VueFinalModal,
    ModalsContainer,
  },
  data() {
    return {
      info: null,
      persons: null,
      showModal: false,
      loadingIns:true,
      loadingPers:true,
    };
  },
  mounted() {
    axios
      .get("/admin/insurance")
      .then((response) => {
        this.info = response.data 
        this.loadingIns=false
        })
      .catch((error) => console.log(error));
  },
  methods: {
    getPersons(id) {
      this.loadingPers=true;
      this.showModal=true;
      axios
        .post("/admin/persons", {
          id,
        })
        .then((response) => {
          this.persons = response.data;
          this.loadingPers=false;
        })
        .catch((error) => console.log(error));
    },
    format_date(value) {
      if (value) {
        return moment(String(value)).format("D.M.Y");
      }
    },
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
  border: 8px solid #00FFFF;
  border-radius: 50%;
  animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
  border-color: #00FFFF transparent transparent transparent;
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