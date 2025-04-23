<template>
  <div class="container">
    <h5>TestPage</h5>
    <router-link to="/home">Home</router-link>
  </div>
</template>

<script>
  import ajaxRequests from "../mixins/ajaxRequests";
  export default{
    name: "TestPage",
    mixins: [
      ajaxRequests
    ],
    mounted() {
      this.getData('/api/test', {"test": "1"});
      this.postData('/api/test', {"test" : "1"});
    }
  }
</script>

<style scoped>

</style>