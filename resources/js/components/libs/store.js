import Vuex from 'vuex';


export default new Vuex.Store({
    state: {
        category: '',
        quantities: [],
    },
    mutations: {
        UPDATE_CATEGORY(state, payload) {
            state.category = payload;
        },
        UPDATE_QUANTITIES(state, payload) {
            state.quantities = payload;
        },
    },
    actions:{
        updateCategory(context,cat){
            context.commit('UPDATE_CATEGORY',cat);
        },
        updateQuantities(context,idz){
            context.commit('UPDATE_QUANTITIES',idz);
        },
    }
});
