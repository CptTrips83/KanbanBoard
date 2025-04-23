<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3>#{{ this.taskEntry.id }} {{ this.taskEntry.title }}</h3>
            <small>{{ this.lastChange }}</small>
          </div>
          <div class="card-body">
            {{ this.taskEntry.description }}
            <hr>
            <br>
            <h4>Kommentare</h4>
              <TaskCommentCreation
                :task-entry-id="this.taskEntry.id"
              />
            <div class="comment-container">
              <!--<transition-group name="list" tag="TaskComment">-->
                <TaskComment v-for="comment in this.sortedComments" :key="comment.id" :comment="comment" />
              <!--</transition-group>-->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import TaskComment from "./TaskComment.vue";
import {getDateTimeString} from "../../mixins/date";
import TaskCommentCreation from "./TaskCommentCreation.vue";

export default {
  name: "TaskDetails",
  mixins: [
    getDateTimeString,
  ],
  computed: {
    lastChange() {
      return getDateTimeString(this.taskEntry.lastChange, "Zuletzt aktualisiert am");
    },
    sortedComments() {
      return this.taskEntry.comments.sort((commentA, commentB) => {
        if(Date.parse(commentA.date) > Date.parse(commentA.date)) {
          return 1;
        } else if (Date.parse(commentA.date) < Date.parse(commentB.date)) {
          return -1;
        } else {
          return 0;
        }
      })
    },
  },
  components: {TaskCommentCreation, TaskComment},
  props: {
    taskEntry: {
      type: Object,
      required: true,
      default: function () {
        return {
          id: 1,
          title: "Neue Aufgabe",
          description: "Mehr Details zu dieser Aufgaben",
          status: 0,
          ownerId: 1,
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
  }
}
</script>

<style scoped>
  .comment-container {
    height: 180px;
    width: 100%;
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