
<template>
  <div class="flex-fill">
    <div v-if="this.$store.state.user.id" class="container text-center">
      <button
        @click="goToRegisterProduct"
        class="btn btn-lg border btn-warning"
      >
        Adicionar Produto <i class="bi bi-plus"></i>
      </button>
    </div>
    <hr />
    <div class="row g-4">
      <Product
        class="col-12 col-sm-6 col-md-4 col-lg-3"
        v-for="product in products"
        :key="product.id"
        :product="product"
      />
    </div>
    <div class="d-flex justify-content-center mt-4">
      <pagination
        v-model="page"
        :records="productsMeta.total"
        :per-page="12"
        @paginate="changePage"
      />
    </div>
  </div>
</template>
<script>
import { mapState } from "vuex";
import Product from "../components/Product.vue";
import Pagination from "v-pagination-3";

export default {
  data() {
    return {
      page: 1,
    };
  },
  components: {
    Product,
    Pagination,
  },
  computed: {
    ...mapState(["products"]),
    ...mapState(["productsMeta"]),
  },
  created() {
    this.$store.dispatch("fetchProducts");
  },
  methods: {
    goToRegisterProduct() {
      this.$router.push({ name: "NewProduct" });
    },
    changePage(page) {
      this.page = page;
      this.$store.dispatch("fetchProducts", page);
    },
  },
};
</script>
