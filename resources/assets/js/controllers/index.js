
module.exports = {
    template: require('../views/index.template.html'),

    ready : function () {
        this.$parent.pageTitlePostfix = 'Index';
    }
};