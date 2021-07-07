// state having some demo data
const state = {
    desde:null,
    hasta:null,
    typeVisita:null,

};
const mutations = {
    setDesde(state,payload){
      state.desde = payload
    },
    setHasta(state,payload){
      state.hasta = payload
    },
    setType(state,payload){
      state.typeVisita = payload
    },

};
const getters = {
    desde: (state) => state.desde,
    hasta: (state) => state.hasta,
    typeVisitaGet: (state) => state.typeVisita
};
const actions = {
    addDesde({commit},value){
        commit('setDesde',value)
    },
    addHasta({commit},value){
        commit('setHasta',value)
    },
    addTypeVisita({commit},value){
        commit('setType',value)
    }

};

export default{
    namespaced: true,

    state,
    getters,
    actions,
    mutations,
}