<template>
  <div class="container">
    <h1 class="text-center m-3">{{ title }}</h1>
    <div class="bg-success" v-if="response.success">
      <p class="text-center text-light">{{ response.success }}</p>
    </div>
    <div class="bg-danger" v-if="response.errors">
      <p class="text-center text-light">{{ response.errors.join("") }}</p>
    </div>
    <form @submit.prevent="submitForm" class="needs-validation">
      <div class="form-group mt-3">
        <label for="email">Name</label>
        <input
          type="text"
          class="form-control"
          id="email"
          v-model="name"
          @keyup="v$.name.$touch"
          placeholder="Enter your name"
          :class="{'is-invalid': v$.name.$errors.length > 0}"
        />
        <div class="text-danger" v-if="v$.name.$error">
          {{ v$.name.$errors[0].$message }}
        </div>
      </div>
      <div class="form-group mt-3">
        <label for="surname">Surname</label>
        <input
          type="text"
          class="form-control"
          id="surname"
          @keyup="v$.surname.$touch"
          v-model="surname"
          placeholder="Enter your surname"
          :class="{'is-invalid': v$.surname.$errors.length > 0}"
        />
        <div class="text-danger" v-if="v$.surname.$error">
          {{ v$.surname.$errors[0].$message }}
        </div>
      </div>
      <div class="form-group mt-3">
        <label for="phone">Phone number</label>
        <input
          type="text"
          class="form-control"
          id="phone"
          @keyup="v$.phone.$touch"
          v-model="phone"
          :class="{'is-invalid': v$.phone.$errors.length > 0 }"
          placeholder="Enter your phone"
        />
        <div class="text-danger" v-if="v$.phone.$error">
          {{ v$.phone.$errors[0].$message }}
        </div>
      </div>
      <div class="mt-3">
        <p>Choose type of insurance</p>
        <select
          v-model="type"
          class="form-select mt-3"
          aria-label="Default select example"
        >
          <option value="0">Individualno</option>
          <option value="1">Grupno</option>
        </select>
      </div>
      <div class="mt-3 row align-items-center" v-if="type == 1">
        <div class="form-group col-3">
          <label for="email">Name</label>
          <input
            type="text"
            class="form-control"
            id="name2"
            v-model="name2"
            @keyup="v$.name2.$touch"
            placeholder="Enter your name"
            :class="{'is-invalid': v$.name2.$errors.length > 0  }"
          />
          <div class="text-danger" v-if="v$.name2.$error">
            {{ v$.name2.$errors[0].$message }}
          </div>
        </div>
        <div class="form-group col-3">
          <label for="surname">Surname</label>
          <input
            type="text"
            class="form-control"
            id="surname2"
            @keyup="v$.surname2.$touch"
            v-model="surname2"
            placeholder="Enter your surname"
            :class="{'is-invalid': v$.surname2.$errors.length > 0 }"
          />
          <div class="text-danger" v-if="v$.surname2.$error">
            {{ v$.surname2.$errors[0].$message }}
          </div>
        </div>
        <div class="form-group mb-3 col-3">
          <p>Birth Date</p>
          <Datepicker
            id="birthdate"
            v-model="birthdate"
            :format="format"
          ></Datepicker>
        </div>
        <div class="col-3">
          <button
            type="button"
            ref="buttonadd"
            @click="addPerson"
            class="btn btn-primary mt-3 ms-3"
          >
            Add person
          </button>
        </div>
        <div class="mt-3" v-if="list.length > 0">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Surname</th>
                <th scope="col">Birthdate</th>
                <th scopre="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for:="(currency, index) in list">
                <th scope="row">{{ index }}</th>
                <td>{{ currency.name2 }}</td>
                <td>{{ currency.surname2 }}</td>
                <td>{{ format_date(currency.birthdate) }}</td>
                <td>
                  <button
                    type="button"
                    @click="removePerson(index)"
                    class="btn btn-danger btn-sm"
                    ref="buttonremove"
                  >
                    Remove
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="mt-3 row">
        <div class="col-4">
          <p>Start Date</p>
          <Datepicker
            v-model="startdate"
            :format="format"
            @blur="countDays"
          ></Datepicker>
        </div>
        <div class="col-4">
          <p>End Date</p>
          <Datepicker
            v-model="enddate"
            :format="format"
            @blur="countDays"
          ></Datepicker>
        </div>
        <div class="col-4">
          <p class="text-center">Number of days</p>
          <p class="text-center">{{ numberOfDays }}</p>
          <p class="text-center text-danger" ref="daysError"></p>
        </div>
      </div>
      <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>
  </div>
</template>

<script>
import { ref } from "vue";
import {
  minLength,
  required,
  maxLength,
  alpha,
  numeric,
} from "@vuelidate/validators";
import { useVuelidate } from "@vuelidate/core";
import moment from "moment";
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import axios from "axios";

export default {
  setup() {
    const date = ref(new Date());
    const format = (date) => {
      const day = date.getDate();
      const month = date.getMonth() + 1;
      const year = date.getFullYear();
      return `${day}.${month}.${year}`;
    };
    return {
      v$: useVuelidate(),
      date,
      format,
    };
  },
  data() {
    return {
      title: "Add insurance",
      name: "",
      surname: "",
      phone: "",
      type: 0,
      startdate: null,
      enddate: null,
      number_of_days: 0,
      birthdate: null,
      name2: "",
      surname2: "",
      list: [],
      response: [],
    };
  },
  validations() {
    return {
      name: {
        required,
        minLengthValue: minLength(3),
        maxLengthValue: maxLength(10),
        alpha,
      },
      surname: {
        required,
        minLengthValue: minLength(3),
        maxLengthValue: maxLength(10),
        alpha,
      },
      phone: {
        required,
        minLengthValue: minLength(7),
        maxLengthValue: maxLength(7),
        numeric,
      },
      name2: {
        required,
        minLengthValue: minLength(3),
        maxLengthValue: maxLength(10),
        alpha,
      },
      surname2: {
        required,
        minLengthValue: minLength(3),
        maxLengthValue: maxLength(10),
        alpha,
      },
    };
  },
  methods: {
    countDays() {
      var diff = new Date(this.enddate) - new Date(this.startdate);
      this.number_of_days = Math.ceil(diff / (1000 * 60 * 60 * 24));
      if (this.number_of_days < 0) {
        this.number_of_days = 0;
      }
    },
    submitForm() {
      const iscor=this.v$.$validate()
      if(!iscor) return;
      if (this.number_of_days > 0) {
        this.$refs.daysError.innerHTML = "";
        axios
          .post("/storein", {
            name: this.name,
            surname: this.surname,
            phone: this.phone,
            type: this.type,
            startdate: this.startdate,
            enddate: this.enddate,
            persons: this.list,
          })
          .then((response) => (this.response = response.data))
          .catch((error) => console.log(error));
      } else {
        this.$refs.daysError.innerHTML = "Number of days can't be 0";
      }
    },
    addPerson() {
      let person = {
        name2: this.name2,
        surname2: this.surname2,
        birthdate: this.birthdate,
      };

      this.list.push(person);
    },
    removePerson(index) {
      var newlist = [];
      for (var i = 0; i < this.list.length; i++) {
        if (i == index) {
          continue;
        }
        newlist.push(this.list[i]);
      }
      this.list = newlist;
    },
    format_date(value) {
      if (value) {
        return moment(String(value)).format("D.M.Y");
      }
    },
  },
  components: {
    Datepicker,
  },
  computed: {
    numberOfDays() {
      return this.number_of_days;
    },
  },
};
</script>

<style scoped>
</style>