
module.exports = {
    template: require('../views/search-result.template.html'),

    data: function () {
        return {
            query : ''
        };
    },

    route: {
        data: function () {
            this.query = this.$route.query.q;
        }
    }
};