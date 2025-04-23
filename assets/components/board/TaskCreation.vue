<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3>Neue Aufgabe erstellen</h3>
            <div class="form-group">
              <label for="textInputTitle">Titel</label>
              <input
                  class="form-control"
                  id="textInputTitle"
                  placeholder="Titel der Aufgabe"
                  v-model="this.title"
              />
            </div>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label for="textAreaDescription">Beschreibung</label>
              <textarea
                class="form-control"
                placeholder="Beschreibung der Aufgabe"
                v-model="this.description"
              />
            </div>
            <div class="form-group">
              <label for="selectPriority">Priorität</label>
              <select
                class="form-control"
                id="selectPriority"
                v-model="this.priority"
              >
                <option value="0">Niedrig</option>
                <option value="1">Normal</option>
                <option value="2">Hoch</option>
              </select>
            </div>
            <div>
              <button
                  type="submit"
                  class="btn btn-primary btn-lg btn-block"
                  :disabled="this.hasTitle"
                  @click.exact="saveTaskEntry"
              >
                Speichern
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import TaskComment from "./TaskComment.vue";

export default {
  name: "TaskCreation",
  data() {
    return {
      title: "",
      description: "",
      priority: 0,
    }
  },
  computed: {
    hasTitle() {
      return this.title === "";
    }
  },
  emits: {
    "new-taskEntry-created": () => {
      return true;
    },
  },
  props: {
    status: Number,
  },
  components: {TaskComment},
  methods: {
    saveTaskEntry() {
      if(this.title === "") return "";
      // Task erstellen
      const task = this.createTask();

      console.log(task);

      // Task speichern
      this.$store.dispatch("addTaskEntry",{task});

      this.$emit("new-taskEntry-created");
    },
    createTask() {
      const date = new Date();
      const dateString = `${date.getFullYear()}-${date.getMonth()}-${date.getDay()} ${date.getHours()}:${date.getMinutes()}:${date.getSeconds()}`

      return {
        id: (this.$store.getters.getTaskEntryMaxId + 1),
        title: this.title,
        description: "Mehr Details zu dieser Aufgaben",
        status: this.status,
        ownerId: this.$store.getters.getUserId,
        ownerName: this.$store.getters.getUserIdentifier,
        lastChange: dateString,
        priority: this.priority,
        synchron: false,
        comments: []
      };
    }
  }
}
</script>

<style scoped>
  input, label {
    display:block;
  }
</style>