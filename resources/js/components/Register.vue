<template>
  <div class="container">
    <div class="register-photo">
      <div class="bg-success" v-if="response.success">
        <p class="text-center text-light">{{ response.success }}</p>
      </div>
      <div class="bg-danger" v-if="response.errors">
        <p class="text-center text-light">{{ response.errors.join("") }}</p>
      </div>
      <div class="form-container">
        <div class="image-holder"></div>
        <form @submit.prevent="submitForm">
          <h2 class="text-center"><strong>Create</strong> an account.</h2>
          <div class="form-group">
            <input
              class="form-control"
              type="email"
              name="email"
              placeholder="Email"
              v-model="email"
              @keyup="v$.email.$touch"
            />
              <div class="text-danger" v-if="v$.email.$error">
            {{ v$.email.$errors[0].$message }}
          </div>
          </div>
          <div class="form-group">
            <input
              class="form-control"
              type="password"
              name="password"
              placeholder="Password"
              v-model="password"
              @keyup="v$.password.$touch"
            />
              <div class="text-danger" v-if="v$.password.$error">
            {{ v$.password.$errors[0].$message }}
          </div>
          </div>
          <div class="form-group">
            <input
              class="form-control"
              type="text"
              name="name"
              placeholder="Name"
              v-model="name"
              @keyup="v$.name.$touch"
            />
              <div class="text-danger" v-if="v$.name.$error">
            {{ v$.name.$errors[0].$message }}
          </div>
          </div>
          <div class="form-group">
            <input
              class="form-control"
              type="text"
              name="surname"
              placeholder="Surname"
              v-model="surname"
              @keyup="v$.surname.$touch"
            />
              <div class="text-danger" v-if="v$.surname.$error">
            {{ v$.surname.$errors[0].$message }}
          </div>
          </div>
          <div class="form-group">
            <input
              class="form-control"
              type="text"
              name="phone"
              placeholder="Phone number"
              v-model="phone"
              @keyup="v$.phone.$touch"
            />
              <div class="text-danger" v-if="v$.phone.$error">
            {{ v$.phone.$errors[0].$message }}
          </div>
          </div>
          <div class="form-group">
            <Datepicker
              class="form-control"
              type="text"
              name="birthdate"
              placeholder="Birth date"
              :format="format"
              v-model="birthdate"
            ></Datepicker>
          </div>
          <div class="form-group">
            <button class="btn btn-primary btn-block" type="submit">
              Sign Up
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from "vue";
import moment from "moment";
import Datepicker from "@vuepic/vue-datepicker";
import {
  minLength,
  required,
  maxLength,
  alpha,
  numeric,
  email
} from "@vuelidate/validators";
import { useVuelidate } from "@vuelidate/core";

export default {
  components: { Datepicker },
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
      title: "Register here",
      email: "",
      password: "",
      name: "",
      surname: "",
      phone: "",
      birthdate: "",
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
        .post("/register", {
          name: this.name,
          surname: this.surname,
          phone: this.phone,
          email: this.email,
          password: this.password,
          birthdate: this.birthdate,
        })
        .then((response) => (this.response = response.data))
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
.register-photo {
  background: #f1f7fc;
  padding: 80px 0;
}

.register-photo .image-holder {
  display: table-cell;
  width: auto;
  background: url(https://cdn.travelpulse.com/images/99999999-9999-9999-9999-999999999999/87ddf328-9f4b-1d6e-159d-35519a58969d/630x355.jpg);
  background-size: cover;
}

.register-photo .form-container {
  display: table;
  max-width: 900px;
  width: 90%;
  margin: 0 auto;
  box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.1);
}

.register-photo form {
  display: table-cell;
  width: 400px;
  background-color: #ffffff;
  padding: 40px 60px;
  color: #505e6c;
}

@media (max-width: 991px) {
  .register-photo form {
    padding: 40px;
  }
}

.register-photo form h2 {
  font-size: 24px;
  line-height: 1.5;
  margin-bottom: 30px;
}

.register-photo form .form-control {
  background: #f7f9fc;
  border: none;
  border-bottom: 1px solid #dfe7f1;
  border-radius: 0;
  box-shadow: none;
  outline: none;
  color: inherit;
  text-indent: 6px;
  height: 40px;
}

.register-photo form .form-check {
  font-size: 13px;
  line-height: 20px;
}

.register-photo form .btn-primary {
  background: #f4476b;
  border: none;
  border-radius: 4px;
  padding: 11px;
  box-shadow: none;
  margin-top: 35px;
  text-shadow: none;
  outline: none !important;
}

.register-photo form .btn-primary:hover,
.register-photo form .btn-primary:active {
  background: #eb3b60;
}

.register-photo form .btn-primary:active {
  transform: translateY(1px);
}

.register-photo form .already {
  display: block;
  text-align: center;
  font-size: 12px;
  color: #6f7a85;
  opacity: 0.9;
  text-decoration: none;
}
</style>