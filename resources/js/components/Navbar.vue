<template>
  <nav
    class="navbar navbar-expand-sm px-4 fixed-top nav-bar flex justify-content-around"
  >
    <a class="navbar-brand fs-3 fw-bold" href="/">Loja</a>
    <div class="d-flex">
      <form class="form-inline my-2 my-lg-0">
        <input
          class="form-control mr-sm-2"
          type="search"
          placeholder="Search"
          aria-label="Search"
          v-model="searchTerm"
        />
      </form>
      <button @click="search" class="btn text-black btn-yellow my-2 my-sm-0 ms-2" type="submit">
        Search
      </button>
    </div>
    <button
      v-if="this.$store.state.showLogin"
      class="userInfo rounded"
      @click="goToLogin"
    >
      <p class="m-auto">Login <i class="ps-2 bi bi-box-arrow-in-right"></i></p>
    </button>
    <div v-else class="dropdown">
      <button class="userInfo rounded dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        {{ truncatedName }}
      </button>
        <ul class="dropdown-menu">
          <li class="dropdown-item">
            <a class="m-auto remove-style" @click="logout">
              Logout
              <i class="mx-3 ps-sm-0 bi bi-box-arrow-right"></i>
            </a>
          </li>
        </ul>

    </div>
  </nav>
</template>

<script>
export default {
  data() {
    return {
      searchTerm: "",
    };
  },  
  computed:{
    truncatedName() {
      let name = this.$store.state.user.name
      if (name.length > 12) {
        return name.substring(0, 12) + "...";
      } else {
        return name;
      }
    },
  },
  methods: {
    goToLogin() {
      this.$router.push("/login");
    },
    logout() {
      axios.post("api/logout").then((response) => {
        localStorage.removeItem("token");
        this.$router.push("/");
        location.reload();
      });
    },
    search(){
      if(this.searchTerm == ""){
        this.$store.dispatch("fetchProducts");
        return;
      }
      this.$store.dispatch("searchProducts", this.searchTerm);
    },
  },
};
</script>
<style scoped>
.nav-bar {
  font-family: "Montserrat", sans-serif !important;
  background-color: #f7b624;
}
.userInfo {
  min-width: 120px;
  height: 35px;
  background-color: #ffc02c;
  color: inherit;
  border: none;
  font: inherit;
  margin-right: 5vw;
}
.btn-yellow {
  background-color: #ffc02c;
}
.remove-style{
  text-decoration: none;
  color: black;
}
</style>