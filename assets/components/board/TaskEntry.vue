<template>
  <div
      class="text-center"
      :class="this.titleClasses"
  >
    {{ this.taskEntry.title }}
    <hr/>
    <div class="text-end">
      <small>
        {{ this.owner }}
        <br>
        {{ this.lastChange }}
      </small></div>
  </div>
</template>

<script>
import {getDateTimeString} from "../../mixins/date";

export default {
  name: "TaskEntry",
  mixins: [
    getDateTimeString,
  ],
  props: {
    taskEntry: {
      type: Object,
      required: true,
      default: function () {
        return {
          id: 1,
          title: "Neue Aufgabe",
          status: 0,
          ownerId: 1,
          ownerName: "",
          lastChange: "2024-05-24 15:00:00",
          priority: 1,
          synchron: false,
          comments: [
            {
              id : 1,
              text: "Sample Comment",
              authorId: 2,
              date: "2024-05-25 15:00:00",
              synchron: false,
            }
          ]
        }
      }
    }
  },
  computed: {
    lastChange() {
      return getDateTimeString(this.taskEntry.lastChange, "Letzte Änderung:");
    },
    titleClasses() {
      return `alert alert-${this.priorityColor}`;
    },
    priorityColor() {
      switch (this.taskEntry.priority) {
        case 0:
          return "success";
        case 1:
          return "warning";
        case 2:
          return "danger";
        default:
          return "danger";
      }
    },
    owner() {
      return this.taskEntry.ownerName;
    }
  },
  mounted() {

  },
  methods: {

  }
}
</script>

<style scoped>

</style>