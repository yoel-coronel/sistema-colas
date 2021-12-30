import Vue from 'Vue';
import Vuex from 'vuex'

Vue.use(Vuex)

export default new  Vuex.Store({
  state: {
      MENU_SELECT_ROUTER:0,

  },
  mutations: {

  },
  actions:{
   /*
    async loadPedidoAsync({ commit , state}, data){
      try {
          state.isLoading = true;
          let response = await fetch(
            state.BaseUrl+'mesa/pedido/detalle/'+data.data.idPedido,
          );
           let responseJson = await response.json();
           let pedidos  = responseJson.data;
            commit('GET_PEDIDOS',pedidos)
            state.isLoading = false;
        } catch (error) {
          state.isLoading = false;
          console.error(error);
        }
    },*/

    }
});
