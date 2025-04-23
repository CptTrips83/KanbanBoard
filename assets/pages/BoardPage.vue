<template>
  <TheBoardLayout>
    <template #statusCards>
      <div class="row">
        <div
            v-for="statusCard in this.statusCards"
            class="col"
            :key="statusCard.status"
        >
          <StatusCard
            :statusCard="statusCard"
            @taskEntry-clicked="onClickTaskEntry"
            @new-taskEntry-clicked="onClickNewTaskEntry"
          >
          </StatusCard>
        </div>
      </div>
    </template>
    <template #taskDetails>
      <TaskCreation
        v-if="this.newTaskStatusCardId !== -1"
        :status="this.newTaskStatusCardId"
        @new-taskEntry-created="onNewTaskCreated"
      >
      </TaskCreation>
      <TaskDetails
        v-else-if="this.selectedTaskEntryId !== 0"
        :taskEntry="selectedTaskEntry"
      >
      </TaskDetails>
    </template>
  </TheBoardLayout>
</template>

<script>
import StatusCard from "../components/board/StatusCard.vue";
import TheBoardLayout from "../layouts/TheBoardLayout.vue";
import TaskDetails from "../components/board/TaskDetails.vue";
import TaskCreation from "../components/board/TaskCreation.vue";

export default {
  name: "BoardPage",
  components: {
    TaskDetails,
    StatusCard,
    TheBoardLayout,
    TaskCreation,
  },
  data() {
    return {
      newTaskStatusCardId: -1,
      selectedTaskEntryId: 0,
      statusCards: [
        {
          title: "Backlog",
          titleClasses: "bg-secondary text-white",
          status: 0,
          newTasks: true,
        },
        {
          title: "In Bearbeitung",
          titleClasses: "bg-primary text-white",
          status: 1,
          newTasks: false,
        },
        {
          title: "Review",
          titleClasses: "bg-info text-white",
          status: 2,
          newTasks: false,
        },
        {
          title: "Test",
          titleClasses: "bg-warning text-white",
          status: 3,
          newTasks: false,
        },
        {
          title: "Erledigt",
          titleClasses: "bg-success text-white",
          status: 4,
          newTasks: false,
        },
      ]
    }
  },
  computed: {
    selectedTaskEntry() {
      return this.$store.getters.getTaskById(this.selectedTaskEntryId);
    }
  },
  methods: {
    onClickTaskEntry(taskEntryId) {
      this.newTaskStatusCardId = -1;
      this.selectedTaskEntryId = taskEntryId.content;
    },
    onClickNewTaskEntry(statusCard) {
      this.newTaskStatusCardId = statusCard.content;
      this.selectedTaskEntryId = 0;
    },
    onNewTaskCreated() {
      this.newTaskStatusCardId = -1;
      this.selectedTaskEntryId = 0;
    }
  },
}
</script>

<style scoped>

</style>