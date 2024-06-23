import Vuex from 'vuex';


export default new Vuex.Store({
    state: {
        category: ''
    },
    mutations: {
        UPDATE_CATEGORY(state, payload) {
            state.category = payload;
        }
    },
    actions:{
        updateCategory(context,cat){
            context.commit('UPDATE_CATEGORY',cat);
        }
    }
});
