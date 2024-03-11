import axios from 'axios';

const comparisonCheckActions = {
    addProductToComparison({ commit }, productId) {
        commit('ADD_TO_COMPARISON', productId);
    },
    removeProductFromComparison({ commit }, productId) {
        commit('REMOVE_FROM_COMPARISON', productId);
    },
    clearComparisonList({ commit }) {
        commit('CLEAR_COMPARISON_LIST');
    },
};

const comparisonCheckGetters = {
    comparisonList: state => state.comparisonList,
};

export { comparisonCheckActions, comparisonCheckGetters };
