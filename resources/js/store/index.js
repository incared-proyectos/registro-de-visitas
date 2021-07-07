import Vue from 'vue';
import Vuex from 'vuex';
import fechavisitas from './modules/fechavisitas';
import userinit from './modules/UserInit';

Vue.use(Vuex);

export default new Vuex.Store({

    modules: {
        fechavisitas,
        userinit
    }
});