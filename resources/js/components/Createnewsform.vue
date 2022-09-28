<template>
  <div class="container">
    <h1 class="text-center m-3">{{ title }}</h1>
    <form @submit.prevent="submitForm" enctype="multipart/form-data">
      <div class="form-group mt-3">
        <label for="email">Title</label>
        <input
          type="text"
          class="form-control"
          id="email"
          v-model="newstitle"
          placeholder="Enter your title"
          @keyup="v$.newstitle.$touch"
          required
        />
        <div class="text-danger" v-if="v$.newstitle.$error">
          {{ v$.newstitle.$errors[0].$message }}
        </div>
      </div>
      <div class="form-group">
        <label for="exampleFormControlTextarea1">Description</label>
        <textarea
          class="form-control"
          id="exampleFormControlTextarea1"
          rows="3"
          v-model="desc"
          placeholder="Enter your description"
          @keyup="v$.desc.$touch"
          required
        ></textarea>
        <div class="text-danger" v-if="v$.desc.$error">
          {{ v$.desc.$errors[0].$message }}
        </div>
      </div>
      <div class="form-group">
        <label>Text</label>
        <QuillEditor
          theme="snow"
          v-model:content="text"
          contentType="text"
          style="min-height: 300px"
          placeholder="Enter your text"
          ref="quillEditor"
          @keyup="v$.text.$touch"
          required
        ></QuillEditor>
        <div class="text-danger" v-if="v$.text.$error">
          {{ v$.text.$errors[0].$message }}
        </div>
      </div>
      <div class="mt-3">
        <p>Choose type of post</p>
        <select
          v-model="type"
          class="form-select mt-3"
          aria-label="Default select example"
        >
          <option value="0">News</option>
          <option value="1">Post</option>
        </select>
      </div>
      <div class="mt-3">
        <label for="formFile" class="form-label">Pick image</label>
        <input
          class="form-control"
          type="file"
          id="formFile"
          @change="onChange"
        />
      </div>

      <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>
  </div>
</template>

<script>
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import axios from "axios";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import {
  minLength,
  required,
  maxLength,
  alpha,
  numeric,
} from "@vuelidate/validators";
import { useVuelidate } from "@vuelidate/core";
import swal from 'sweetalert';

export default {
  components: { QuillEditor },
  setup() {
    return {
      v$: useVuelidate(),
    };
  },
  data() {
    return {
      title: "Add",
      newstitle: "",
      type: 0,
      desc: "",
      text: "",
      image: null,
      imgname: "",
      info: null,
      id: 0,
      response: [],
    };
  },
  validations() {
    return {
      newstitle: {
        required,
        minLengthValue: minLength(3),
        maxLengthValue: maxLength(10),
      },
      desc: {
        required,
        minLengthValue: minLength(10),
        maxLengthValue: maxLength(255),
      },
      text: {
        minLengthValue: minLength(10),
        maxLengthValue: maxLength(500),
      },
    };
  },
  mounted() {
    this.info = this.$parent.currentNews;
    if (this.info != null) {
      this.title = "Edit";
      this.newstitle = this.info.title;
      this.type = this.info.news_type;
      this.desc = this.info.desc;
      this.text = this.info.text;
      this.id = this.info.id;
    }
    if (this.info == null) {
      this.title = "Add";
    }

    let t = this.$refs.quillEditor;

    t.setContents(this.text);
  },
  methods: {
    onChange(e) {
      this.image = e.target.files[0];
    },
    submitForm() {
      let fd = new FormData();
      fd.append("img", this.image);
      if (this.v$.$errors.length == 0) {
        if (this.image == undefined) {
          axios
            .post("/storenews", {
              title: this.newstitle,
              type: this.type,
              desc: this.desc,
              text: this.text,
              imgname: this.imgname,
              id: this.id,
            })
            .then((response) => {
              this.response = response.data;
              swal("Good Job!", "News successfuly created", "success");
              axios
                .get("/admin/news")
                .then((response) => (this.$parent.items = response.data))
                .catch((error) => console.log(error));
            })
            .catch((error) => console.log(error));
        } else {
          axios
            .post("/storenews", fd)
            .then((response) => {
              this.imgname = response.data;
              axios
                .post("/storenews", {
                  title: this.newstitle,
                  type: this.type,
                  desc: this.desc,
                  text: this.text,
                  imgname: this.imgname,
                  id: this.id,
                })
                .then((response) => {
                  this.response = response.data;
                  swal("Good Job!", "News successfuly created", "success");
                  axios
                    .get("/admin/news")
                    .then((response) => (this.$parent.items = response.data))
                    .catch((error) => console.log(error));
                })
                .catch((error) => console.log(error));
            })
            .catch((error) => console.log(error));
        }
      }else{
        swal("Warning!", "Your inputs are not valid", "error");
      }
    },
  },
};
</script>

<style scoped>
</style>