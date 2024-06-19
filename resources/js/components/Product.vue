<template>
  <div class="card text-center rounded">
    <p class="card-title fs-4">{{ product.name }}</p>
    <div class="card-header">R$ {{ product.price }}</div>
    <div class="card-body">
      <p v-if="product.description" class="card-text">
        {{ truncatedDescription }}
      </p>
      <p v-else class="card-text">Sem descrição</p>
    </div>
    <div class="card-footer">
      <button v-if="!createdBy" class="btn details-button rounded-pill">
        Mais Detalhes
      </button>
      <div v-if="createdBy">
        <button @click="editProduct" class="btn details-button rounded-pill">
          Editar
        </button>
        <button
          data-bs-toggle="modal"
          data-bs-target="#deleteModal"
          class="btn delete-button rounded-pill"
        >
          Excluir
        </button>
      </div>
    </div>
    <!-- Delete Modal start-->
    <div class="modal" id="deleteModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">
              Deseja realmente excluir este produto?
            </h1>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Cancelar
            </button>
            <button @click="deleteProduct" type="button" class="btn btn-danger">Delete</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Delete Modal ends-->
  </div>
</template>
<script>
import axios from 'axios';

export default {
  data() {
    return {
      createdBy: false,
    };
  },
  props: {
    product: Object,
  },
  computed: {
    truncatedDescription() {
      if (this.product.description.length > 100) {
        return this.product.description.substring(0, 100) + "...";
      } else {
        return this.product.description;
      }
    },
    matchCreator() {
      if (this.product.user_id == this.$store.state.user.id) {
        this.createdBy = true;
        return;
      }
    },
  },
  mounted() {
    this.matchCreator;
  },
  methods: {
    editProduct() {
      this.$router.push({
        name: "EditProduct",
        params: { id: this.product.id },
      });
    },
    deleteProduct() {
      axios.delete("api/products/" + this.product.id)
        .then((response) => {
          this.$router.go();
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>

<style scoped>
.details-button {
  color: white;
  background-color: #0026fd;
}
.delete-button {
  color: white;
  background-color: #ff0000;
}
</style>
