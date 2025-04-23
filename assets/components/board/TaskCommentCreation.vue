<template>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="form-group">
            <label for="comment">Neuer Kommentar</label>
            <textarea
              id="comment"
              class="form-control"
              v-model="this.text"
            ></textarea>
            <button
              class="btn btn-primary"
              :disabled="this.hasCommentText"
              @click.exact="submitComment"
            >
            Kommentar hinzufügen
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "TaskCommentCreation",
  data() {
    return {
      text: "",
    }
  },
  props: {
    taskEntryId : Number,
  },
  computed: {
    hasCommentText() {
      return this.text === "";
    }
  },
  methods: {
    submitComment() {
      const newComment = this.createComment();
      this.$store.dispatch("addCommentToTask", {taskEntryId : this.taskEntryId, comment : newComment});
      this.$nextTick(() =>{
        this.text = "";
      });
    },
    createComment() {
      const newId = this.$store.getters.getTaskCommentMaxId;
      const userId = this.$store.getters.getUserId;
      const userIdentifier = this.$store.getters.getUserIdentifier;

      const date = new Date();
      const dateString = `${date.getFullYear()}-${date.getMonth()}-${date.getDay()} ${date.getHours()}:${date.getMinutes()}:${date.getSeconds()}`

      return {
        id : newId + 1,
        text: this.text,
        authorId: userId,
        authorName: userIdentifier,
        date: dateString,
        synchron: false,
      }
    }
  }
}
</script>

<style scoped>

</style>