<template>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h5>{{ this.comment.text }}</h5>
          <small>{{ this.lastChange }} von {{ this.author }}</small>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {getDateTimeString} from "../../mixins/date";

export default {
  name: "TaskComment",
  mixins: [
    getDateTimeString
  ],
  computed: {
    author() {
      return this.comment.authorName;
    },
    lastChange() {
      return getDateTimeString(this.comment.date, "Kommentiert am");
    }
  },
  mounted() {

  },
  props: {
    comment:
    {
      type: Object,
      required: true,
      default: function () {
        return {
          id: 1,
          text: "Sample Comment 1",
          authorId: 2,
          authorName: "hknorz",
          date: "2024-05-25 15:00:00",
        };
      }
    },
  },
}
</script>

<style scoped>

</style>