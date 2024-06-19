import { createStore } from "vuex";

export default createStore({
    state: {
      user:{
        name: null,
        email: null,
      },
      showLogin: true,
      products: null,
      productsMeta: null
    },
    mutations: {
      setUser(state, user){
        state.user = user;
      },
      logged(state, logged){
        state.showLogin = logged;
      },
      setProducts(state, products){
        state.products = products;
      },
      setProductsPaginationMeta(state, meta){
        state.productsMeta = meta;
      }
    },
    actions: {
      fetchProducts({ commit }, page) {
        if(!page) page = 1 ;
        axios.get('/api/products?page=' + page)
        .then(response => {
          commit('setProducts', response.data.products);
          commit('setProductsPaginationMeta', response.data.meta);
        });
    },
      searchProducts({ commit }, search) {
        axios.post('/api/products/search', {searchTerm: search})
        .then(response => {
          commit('setProducts', response.data.products);
        });
      }
    },
    modules: {}
})