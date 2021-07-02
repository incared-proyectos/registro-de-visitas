import Vue from 'vue';
import Vuex from 'vuex';
import fechavisitas from './modules/fechavisitas';

Vue.use(Vuex);

export default new Vuex.Store({

    modules: {
        fechavisitas,
    }
});