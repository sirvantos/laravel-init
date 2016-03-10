module.exports = {
    template: require('../views/movies.template.html'),

    data: function () {
        return {
            query : ''
        };
    },

    route: {
        data: function () {
            this.query = null;
        }
    }
};