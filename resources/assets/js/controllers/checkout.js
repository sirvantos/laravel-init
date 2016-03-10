
module.exports = {
    template: require('../views/checkout.template.html'),

    data: function() {
        return {
            cost: 50,
            discount: 0
        };
    },

    components: {
        coupon: require('../components/coupon')
    },

    filters: {
        coupon: function(cost) {
            return cost - (this.discount / 100 * cost);
        }
    },

    methods: {
        applyDiscount: function(discount) {
            this.discount = discount;
        }
    }
};