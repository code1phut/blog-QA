import Vue from "vue";
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
   state: {
       counter: 1000,
       deleteModalBased: {
           showModalDelete: false,
           deleteUrl: '',
           data: {},
           deletingIndex: -1,
           isDeleted: false
       },
   },

    getters: {
        getCounter(state) {
            return state.counter;
        },

        getDeleteModalBased(state) {
            return state.deleteModalBased
        }

    },

   mutations: {
       changeCounter(state, data) {
           state.counter += data;
       },
       setShowDeleteModal(state, data) {
           const deleteModalBased = {
               showModalDelete: false,
               deleteUrl: '',
               data: {},
               deletingIndex: -1,
               isDeleted: data
           }

           state.deleteModalBased = deleteModalBased;
       },

       setDeleteModal(state, data) {
           state.deleteModalBased = data;
       }
   },

   actions: {
       changeCounterByAction({commit}, data) {
           commit('changeCounter', data);
       }
   }
});
