<template>
  <div id="nav" class="main_app-container">
    <Header ref="componentToReload"/>
    <router-view
      v-on:logged-user="handleSubmitLoggin"
    />
    <Footer />
  </div>
</template>

<script>
import Header from "@/components/Header.vue";
import Footer from "@/components/Footer.vue";
import storage from "@/plugins/storage.js";

export default {
  name: "Home",
  components: {
    Header,
    Footer,
  },
  data() {
    return {
      currentUserData: "",
    };
  },
  methods: {
    async handleSubmitLoggin() {
      this.currentUserData = await storage.get("data_from_user");
      if (this.currentUserData) {
        this.$refs.componentToReload.methodsToReload();
      }
    },
  },
};
</script>

<style lang="scss">
@import url('https://fonts.googleapis.com/css2?family=Mansalva&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Fredericka+the+Great&family=Mansalva&family=Patua+One&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Fredericka+the+Great&family=Mansalva&family=New+Rocker&family=Patua+One&display=swap');
body{
  max-width: 100vw;
}

.main_app-container {
  display: flex;
  flex-direction: column;
  height: 100vh;
}
body,
.navbar {
  min-width: 343px;
}
</style>
