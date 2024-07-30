import Vuex from 'vuex';


export default new Vuex.Store({
    state: {
        test: '',
    },
    mutations: {
        UPDATE_TEST(state, payload) {
            state.test = payload;
        },
    },
    actions:{
        updateTest(context,val){
            context.commit('UPDATE_TEST',val);
        },
    }
});
