import Vue from 'vue'
import Vuex from 'vuex'
import firebase from 'firebase'


Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    events: [],
    groups: [],
    resources: []
  },
  mutations: {
    setEvents (state, events) {
      state.events = events
    },
    setGroups (state, groups) {
      state.groups = groups
    },
    setResources (state, resources) {
      state.resources = resources
    },
  },
  actions: {
    getEvents({ commit }) {
      return firebase
          .database()
          .ref('events/')
          .once('value', snapshot => {
              commit('setEvents', snapshot.val());
          });
    },
    getGroups({ commit }) {
      return firebase
          .database()
          .ref('groups/')
          .once('value', snapshot => {
              commit('setGroups', snapshot.val());
          });
    },
    getResources({ commit }) {
      return firebase
          .database()
          .ref('resources/')
          .once('value', snapshot => {
              commit('setResources', snapshot.val());
          });
    }
  },
  getters:{
    events: state => {
      return state.events
    },
    groups: state => {
      return state.groups
    },
    resources: state => {
      return state.resources
    }
  },
  modules: {
  }
})
