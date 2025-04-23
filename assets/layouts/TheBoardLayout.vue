<template>
  <main>
    <div class="container mt-2">
      <div class="row">
        <div class="col-12">
          <slot name="statusCards">
          </slot>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-12">
          <slot name="taskDetails">
          </slot>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  name: "TheBoardLayout"
}
</script>

<style scoped>

</style>