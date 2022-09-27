<template>
   <div class="bg-success rounded w-50 mx-auto h-50 block" @click="this.$parent.stopTimer">
   </div>
</template>

<script>
export default {
    data(){
        return {
            info:0
        }
    },
}
</script>

<style>
.block{
    min-height: 500px;
}
</style>