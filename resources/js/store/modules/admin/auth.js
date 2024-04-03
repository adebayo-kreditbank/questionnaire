import { initManualClass } from '../../../helpers/authUtils'
import { axios as http } from '../../../helpers/api'

const state = {
    currentUser: initManualClass().getAuthenticatedUser(),
    token: initManualClass().getAuthToken(),
    userType: initManualClass().getUserType(),
}

const mutations = {
    SET_CURRENT_USER (state, newValue) {
        state.currentUser = newValue
        initManualClass().setAuthData(newValue)
    },
    SET_AUTH_TOKEN (state, newValue) {
        state.token = newValue
        initManualClass().setAuthToken(newValue)
    },
    SET_USER_TYPE (state, newValue) {
        state.userType = newValue
        initManualClass().setUserType(newValue)
    },
}

const getters = {
    isLoggedIn: state => !!state.currentUser,
    currentUser : state => state.currentUser,
    userType : state => state.userType
}

const actions = {
    /**
     * This is automatically run in `src/state/store.js` when the app
     * starts, along with any other actions named `init` in other modules.
     */ 
    // eslint-disable-next-line no-unused-vars
    init({ state, dispatch }) {
        dispatch('validate')
    },

    // eslint-disable-next-line no-unused-vars
    login({ commit, getters, dispatch }, {email, password} = {}) {
        if (getters.isLoggedIn) return dispatch('validate')
        
        return new Promise((resolve, reject) => {
            http.post("admin/login", {email, password})
                .then(response => {
                    console.log('data from API', response)
                    // commit('SET_CURRENT_USER', response.data.data);
                    // commit('SET_AUTH_TOKEN', response.data.data.token);
                    // commit('SET_USER_TYPE', 'admin');
                    // resolve(response.data)
                })
                .catch( error => {
                    console.log('error from API', error)
                    reject(error) 
                });
        })
    },

    logOut({ commit }) {
        return new Promise(() => {
            http.post("developer/logout")
                .then(() => {
                    commit('SET_CURRENT_USER', null)
                    initManualClass().emptyStorage()
                })
                commit('SET_CURRENT_USER', null)
                initManualClass().emptyStorage()
        })
    },

    // Get/validates the current user's token
    // eslint-disable-next-line no-unused-vars
    validate({ commit, state }) {
        if (!state.currentUser) return Promise.resolve(null)
        const user = initManualClass().getAuthenticatedUser();
        commit('SET_CURRENT_USER', user)
        commit('SET_AUTH_TOKEN', initManualClass().getAuthToken())
        commit('SET_USER_TYPE', initManualClass().getUserType())
        return user;
    },
}

export default {
    state,
    mutations,
    getters,
    actions
}