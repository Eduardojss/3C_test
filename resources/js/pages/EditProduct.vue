<template>
  <div class="container-update shadow p-3 mb-5 row form-group">
    <small class="title pb-3 fs-3 text-center">Cadastrar novo Produto</small>
    <div class="row-sm pb-3">
      <label for="inputName" class="form-label">Nome</label>
      <input
        type="name"
        class="form-control rounded-pill border border-dark-subtle"
        id="inputName"
        placeholder="Nome do Produto"
        v-model="product.name"
      />
    </div>
    <div class="row-sm pb-4">
      <label for="inputDescription" class="form-label">Descrição</label>
      <textarea
        class="form-control rounded border border-dark-subtle"
        id="inputDescription"
        placeholder="Descrição"
        v-model="product.description"
      ></textarea>
    </div>
    <div class="row-sm pb-3">
      <label for="inputPrice" class="form-label">Preço</label>
      <input
        type="number"
        step="0.01"
        class="form-control rounded-pill border border-dark-subtle"
        id="inputPrice"
        placeholder="Preço"
        v-model="product.price"
      />
      <p class="p-2 color-gray">
        (utilize "." para adicionar as casas decimais)
      </p>
    </div>
    <div class="row-sm pb-3">
      <button @click="save" class="btn update-button rounded-pill">
        Atualizar
      </button>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      product: {
        name: "",
        description: "",
        price: 0,
      },
    };
  },
  props: ["id"],
  mounted() {
    this.fetchProduct();
  },
  methods: {
    fetchProduct() {
      axios.get("/api/products/" + this.$route.params.id).then((response) => {
        this.product = response.data.productDetails;
      });
    },
    save() {
      let productData = {
        name: this.product.name,
        price: this.product.price,
      };
      if (this.product.description) {
        productData.description = this.product.description;
      }

      axios
        .put("/api/products/" + this.$route.params.id, productData)
        .then((response) => {
          this.$router.push({ name: "Home" });
        });
    },
  },
};
</script>
<style scoped>
body {
  display: flex;
  align-items: center;
  justify-content: center !important;
}

.title {
  font-size: 1rem;
  font-weight: 600;
  margin-bottom: 1rem;
  color: #0026fd;
  font-family: "Montserrat", sans-serif;
  font-optical-sizing: auto;
}

.container-update {
  margin-top: 20vh;
  margin-left: auto;
  margin-right: auto;
  max-width: 390px;
}

.update-button {
  color: white;
  background-color: #0026fd;
  width: 100%;
}
.color-gray {
  color: #6c757d;
}
</style>