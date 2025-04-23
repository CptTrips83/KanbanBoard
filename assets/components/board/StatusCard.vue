<template>
  <div class="card kanban-statuscard"
       @drop="onDrop($event)"
       @dragover.prevent
       @dragenter.prevent
       @dragleave.prevent
       @dragend.prevent
  >
    <div
        class="card-header text-center"
        :class="this.statusCard.titleClasses"
    >
      <h4>{{ this.statusCard.title }}</h4>
    </div>
    <div class="card-body kanban-statuscard-body">
      <transition-group name="list" tag="TaskEntry">
        <TaskEntry
            v-if="isAuthenticated"
            v-for="(task) in getTasksByStatus(this.statusCard.status)"
            :key="task.id"
            :taskEntry="task"
            draggable="true"
            @dragstart="startDrag($event, task)"
            @click.exact="openTask(task.id)"
        >
        </TaskEntry>
      </transition-group>
    </div>
    <div
        class="card-footer align-content-center"
        v-if="statusCard.newTasks === true && this.isAuthenticated"
    >
      <button
          @click.exact="openNewTask"
          type="button"
          class="btn btn-primary btn-lg btn-block"
      >
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-plus" viewBox="0 0 16 16">
          <path d="M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7"/>
          <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
        </svg>
      </button>
    </div>
  </div>
</template>

<script>

import TaskEntry from "./TaskEntry.vue";
import {mapGetters} from "vuex";

export default {
  name: "StatusCard",
  components: {
    TaskEntry
  },
  emits: {
    "taskEntry-clicked": () => {
      return true;
    },
    "new-taskEntry-clicked": () => {
      return true;
    },
  },
  props: {
    statusCard: {
      type: Object,
      required: true,
      default: function() {
        return {
          title: "Neue Aufgabe",
          titleClasses: "",
          status: 0,
          newTasks: false,
        }
      }
    }
  },
  computed: {
    ...mapGetters([
       'getTasksByStatus',
       'isAuthenticated'
    ]),
  },
  methods: {
    openTask(taskEntryId) {
      this.$emit("taskEntry-clicked", {
        content: taskEntryId,
      });
    },
    startDrag(event, task) {
      event.dataTransfer.dropEffect = "move";
      event.dataTransfer.effectAllowed = "move";
      const taskId = task.id;
      event.dataTransfer.setData("taskId", taskId);
    },
    onDrop(event) {
      const taskId = event.dataTransfer.getData("taskId");
      const task = this.$store.getters.getTaskById(taskId);
      task.status = this.statusCard.status;
      this.$store.dispatch("saveTaskToDB", {task});
    },
    openNewTask() {
      this.$emit("new-taskEntry-clicked", {
        content: this.statusCard.status,
      });
    },
  }
}
</script>

<style scoped>
  .kanban-statuscard {
    height: 400px;
  }
  .kanban-statuscard-body {
    overflow-y: auto;
  }
  .list-move, /* apply transition to moving elements */
  .list-enter-active
  /*.list-leave-active*/ {
    transition: all 0.5s ease;
  }

  .list-enter-from
  /*.list-leave-to*/ {
    opacity: 0;
    transform: translateX(30px);
  }

  /* ensure leaving items are taken out of layout flow so that moving
     animations can be calculated correctly. */
  .list-leave-active {
    position: absolute;
  }
</style>