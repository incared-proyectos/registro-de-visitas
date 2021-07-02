// state having some demo data
const state = {
    desde:null,
    hasta:null,

};
const mutations = {
    setDesde(state,payload){
      state.desde = payload
    },
    setHasta(state,payload){
      state.hasta = payload
    },

};
const getters = {
    desde: (state) => state.desde,
    hasta: (state) => state.hasta
};
const actions = {
    addDesde({commit},value){
        commit('setDesde',value)
    },
    addHasta({commit},value){
        commit('setHasta',value)
    }
};

export default{
    namespaced: true,

    state,
    getters,
    actions,
    mutations,
}