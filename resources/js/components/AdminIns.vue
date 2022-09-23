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
      <tbody>
        <tr v-for:="currency in info">
          <th scope="row">{{ currency.id }}</th>
          <td>{{ currency.name }}</td>
          <td>{{ currency.surname }}</td>
          <td>{{ currency.phone }}</td>
          <td v-if="currency.type == 0">Individualno</td>
          <td v-if="currency.type == 1">Grupno</td>
          <td>{{ format_date(currency.start_date) }}</td>
          <td>{{ format_date(currency.end_date) }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import moment from "moment";

export default {
  data() {
    return {
      info: null,
    };
  },
  mounted() {
    axios
      .get("/admin/insurance")
      .then((response) => (this.info = response.data))
      .catch((error) => console.log(error));
  },
  methods: {
    format_date(value) {
      if (value) {
        return moment(String(value)).format("D.M.Y");
      }
    },
  },
};
</script>

<style scoped>
</style>