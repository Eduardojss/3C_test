<script setup>
import Navbar from "./components/Navbar.vue";
</script>
<template>
  <div class="container montserrat">
    <Navbar />
    <router-view class="mt-navbar"/>
  </div>
</template>
<script>
export default {

  components: {
    Navbar,
  },
  mounted() {
    axios.get("/api/user").then((response) => {
        this.$store.commit("setUser", response.data.user);
        this.$store.commit("logged", false);
      });
  },
};
</script>
<style scoped>
.mt-navbar {
  margin-top: 5rem;
}
</style>