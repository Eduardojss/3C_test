<template>
  <div class="container-register shadow p-3 mb-5 row form-group">
    <small class="title pb-3 fs-3 text-center">Cadastrar novo Produto</small>
    <div class="row-sm pb-3">
      <input
        type="name"
        class="form-control rounded-pill border border-dark-subtle"
        id="inputName"
        placeholder="Nome do Produto"
        v-model="product.name"
      />
    </div>
    <div class="row-sm pb-4">
      <textarea
        class="form-control rounded border border-dark-subtle"
        id="inputDescription"
        placeholder="Descrição"
        v-model="product.description"
      ></textarea>
    </div>
    <div class="row-sm pb-3">
      <input
        type="number"
        step="0.01"
        class="form-control rounded-pill border border-dark-subtle"
        id="inputPrice"
        placeholder="Preço"
        v-model="product.price"
      />
    </div>
    <div class="row-sm pb-3">
      <button @click="register" class="btn register-button rounded-pill">
        Cadastrar
      </button>
    </div>
  </div>
</template>
<script>
export default {
    data(){
        return {
            product: {
                name: "",
                description: "",
                price: 0,
            },
        }
    },
  methods: {
    register() {
        let productData = {
        name: this.product.name,
        price: this.product.price,
        };
        if (this.product.description) {
            productData.description = this.product.description;
        }

      axios.post("api/products", productData)
        .then((response) => {
          this.$router.push({ name: "Home" });
        })
        .catch((error) => {
          console.log(error);
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

.container-register {
  margin-top: 20vh;
  margin-left: auto;
  margin-right: auto;
  max-width: 390px;
}

.register-button {
  color: white;
  background-color: #0026fd;
  width: 100%;
}
</style>