
module.exports = {
    template: require('../views/about.template.html'),

    ready: function () {
        this.$parent.pageTitlePostfix = 'about';
    }
};