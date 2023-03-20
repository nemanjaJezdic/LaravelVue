<template>
  <div class="container text-center mt-5">
    <h1>Reaction timer</h1>
    <button
      class="btn btn-primary"
      @click="start"
      ref="btnclick"
      :disabled="this.count > 0"
    >
      Start
    </button>
    <div class="container mt-5" v-if="show">
      <reaction-block></reaction-block>
    </div>
  </div>
</template>

<script>
import ReactionBlock from "./ReactionBlock.vue";
import swal from "sweetalert";
export default {
  components: { ReactionBlock},
  data() {
    return {
      show: false,
      timer: null,
      time: 0,
      count: 0,

    };
  },
  methods: {
    start() {
      this.count++;
      setTimeout(() => {
        this.startTimer();
        this.show = true;
      }, Math.random() * 5000);
    },
    startTimer() {
      this.timer = setInterval(() => {
        this.time += 10;
      }, 10);
    },
    stopTimer() {
      this.count--;
      clearInterval(this.timer);
      if (this.time < 500) {
        swal("Good Job!", "Your time is" + " " + this.time + "ms", "success");
      } else {
        swal("Too slow!", "Your time is" + " " + this.time + "ms", "error");
      }
      this.time = 0;
      this.show = false;
    },
  },
};
</script>

<style>
</style>