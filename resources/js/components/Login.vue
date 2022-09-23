<template>
  <div class="container bg-dark">
    <div class="bg-danger" v-if="response.msg">
      <p class="text-center text-light">{{ response.msg }}</p>
    </div>
    <div class="bg-danger" v-if="response.errors">
      <p class="text-center text-light">{{ response.errors.join("") }}</p>
    </div>
    <form @submit.prevent="submitForm">
      <div class="row p-3 container w-75 mx-auto">
        <div class="form-group col-4">
          <input
            type="email"
            class="form-control bggray"
            id="exampleInputEmail1"
            aria-describedby="emailHelp"
            placeholder="Enter email"
            v-model="email"
             @keyup="v$.email.$touch"
          />
           <div class="text-danger" v-if="v$.email.$error">
            {{ v$.email.$errors[0].$message }}
          </div>
        </div>
        <div class="form-group col-4">
          <input
            type="password"
            class="form-control bggray"
            id="exampleInputPassword1"
            placeholder="Password"
            v-model="password"
             @keyup="v$.password.$touch"
          />
           <div class="text-danger" v-if="v$.password.$error">
            {{ v$.password.$errors[0].$message }}
          </div>
        </div>
        <div class="form-group col-4">
          <button type="submit" class="btn btn-danger">Login</button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import { ref } from "vue";
import {
  minLength,
  required,
  email
} from "@vuelidate/validators";
import { useVuelidate } from "@vuelidate/core";
import moment from "moment";
export default {
  setup(){
    return {
        v$: useVuelidate(),
    }
  },
  data() {
    return {
      title: "Login here",
      email: "",
      password: "",
      response: [],
    };
  },
  validations() {
    return {
      email: {
        required,
        minLengthValue: minLength(3),
        email
      },
      password: {
        required,
        minLengthValue: minLength(3),
      },
    };
  },
  methods: {
    submitForm() {
      axios
        .post("/login", {
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          },
          email: this.email,
          password: this.password,
        })
        .then((response) => (response.data.success ? window.location.href="/admin" :this.response = response.data))
        .catch((error) => (this.response = error.data));
    },
  },
};
</script>

<style scoped>
.bggray {
  background: #f7f9fc;
}
</style>