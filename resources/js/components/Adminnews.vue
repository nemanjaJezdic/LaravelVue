<template>
  <div class="container">
    <h2>News:</h2>
    <div class="mt-3">
      <button
        class="border-none btn btn-primary text-light"
        @click="loadCreate"
      >
        Add new post/news
      </button>
    </div>
    <div class="container" v-if="show == 'create'">
      <create></create>
    </div>
    <div class="root">
      <teleport to="body">
        <div class="modal" v-if="show == 'preview'">
          <post></post>
          <button class="btn btn-primary" id="btnclose" @click="close">
            Close
          </button>
        </div>
      </teleport>
    </div>

    <table class="table table-striped table-bordered mt-3">
      <thead class="thead-light">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Created</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Status</th>
          <th scope="col">Published</th>
          <th scope="col">Autor</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for:="currency in info">
          <th scope="row">{{ currency.id }}</th>
          <td>{{ format_date(currency.created_at) }}</td>
          <td>{{ currency.title }}</td>
          <td>{{ currency.desc }}</td>
          <td>{{ currency.status }}</td>
          <td>{{ format_date(currency.published_at) }}</td>
          <td>{{ currency.fullname }}</td>
          <td class="position-relative">
            <i
              class="fa fa-ellipsis-v bg-light p-3 rounded-circle ms-1"
              id="icon"
              @click="showActions(currency.id)"
            ></i>
            <div
              class="bg-light position-absolute d-flex flex-column p-3 rounded showA"
              v-if="showAction == 'show' && actionid == currency.id"
            >
              <a
                href="#"
                @click="loadPreview(currency.id)"
                class="text-secondary text-decoration-none"
                >Preview</a
              >
              <a
                href="#"
                @click="loadEdit(currency)"
                class="text-secondary text-decoration-none"
                >Edit</a
              >
              <a
                href="#"
                @click="deleteNews(currency.id)"
                class="text-secondary text-decoration-none"
                >Delete</a
              >
              <a
                href="#"
                @click.prevent="publishNews(currency.id)"
                v-if="currency.status == 'in process'"
                class="text-secondary text-decoration-none"
                >Publish</a
              >
              <a
                href="#"
                @click.prevent="archiveNews(currency.id)"
                v-if="currency.status == 'published'"
                class="text-secondary text-decoration-none"
                >Archive</a
              >
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import moment from "moment";
import Create from "./Createnewsform.vue";
import Post from "./Post.vue";

export default {
  components: { Create, Post },
  data() {
    return {
      info: null,
      show: "",
      showAction: "",
      actionid: 0,
      newsid: 0,
      currentNews: null,
    };
  },
  mounted() {
    axios
      .get("/admin/news")
      .then((response) => (this.info = response.data))
      .catch((error) => console.log(error));
  },
  methods: {
    format_date(value) {
      if (value) {
        return moment(String(value)).format("D.M.Y");
      }
    },
    loadCreate() {
      this.showAction=""
      if (this.show == "create") {
        this.currentNews = null;
        return (this.show = "");
      }
      this.currentNews = null;
      return (this.show = "create");
    },
    loadEdit(current) {
           this.showAction=""
      if (this.show == "create") {
        this.currentNews = null;
        return (this.show = "");
      }
      this.currentNews = current;
      return (this.show = "create");
    },
    loadPreview(id, e) {
           this.showAction=""
      if (this.show == "preview") {
        this.newsid = 0;
        return (this.show = "");
      }
      this.newsid = id;
      return (this.show = "preview");
    },
    close() {
      return (this.show = "");
    },
    deleteNews(id) {
      axios
        .get("/admin/delete/" + id)
        .then((response) => (this.info = response.data))
        .catch((error) => console.log(error));
    },
    showActions(id) {
      if (this.showAction == "show") {
        this.actionid = 0;
        return (this.showAction = "");
      }
      this.actionid = id;
      return (this.showAction = "show");
    },
    publishNews(id) {
      axios
        .get("/admin/publish/" + id)
        .then((response) => (this.info = response.data))
        .catch((error) => console.log(error));
    },
    archiveNews(id) {
      axios
        .get("/admin/archive/" + id)
        .then((response) => (this.info = response.data))
        .catch((error) => console.log(error));
    },
  },
};
</script>

<style scoped>
.root {
  position: relative;
}
.modal {
  position: absolute;
  top: 0;
  left: 0;
  background-color: rgba(0, 0, 0, 0.1);
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}
.modal > div {
  background-color: #fff;
  padding: 50px;
  border-radius: 10px;
}
#btnclose {
  position: absolute;
  top: 25%;
  left: 80%;
}
#icon:hover {
  cursor: pointer;
  background-color: gray !important;
  color: white;
}
a:hover {
  background-color: white;
}
.showA{
  top:0px;
  right:60px;
}
</style>