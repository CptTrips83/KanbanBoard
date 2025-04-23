<template>
  <div class="container">
    <router-view />
  </div>
</template>

<script>
export default {
  name: "App",
  /**
   * Executes the authentication process at regular intervals.
   * Calls the "checkAuthentication" action of the Vuex store every 30 seconds.
   */
  mounted() {
    this.$store.dispatch("checkAuthentication", {});
    this.$store.dispatch("loadTasksFromDB");
    setInterval(() => {
      this.$store.dispatch("checkAuthentication", {});
    }, 30000);
    /*
    const entry1 = {
      id: 1,
      title: "Neue Aufgabe",
      titleClasses: "alert-success",
      status: 0,
    };
    const entry2 = {
      id: 1,
      title: "Neue Aufgabe",
      titleClasses: "alert-warning",
      status: 2,
    };
    this.$store.dispatch("addTaskEntry", entry1);
    this.$store.dispatch("addTaskEntry", entry2);

     */
  }
};
</script>

<style>
@import "~bootstrap/dist/css/bootstrap.min.css";
@import "~animate.css/animate.min.css";
</style>