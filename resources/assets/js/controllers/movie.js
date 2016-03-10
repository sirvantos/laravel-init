module.exports = {

    template: require('../views/movie.template.html'),

    data : function () {
        return {
            movie : {}
        }
    },

    watch : {
        movie: function() {
            this.$parent.pageTitlePostfix = this.movie.title;
        }
    },

    route: {
        data: function () {
            var resource = this.$resource('movies/:id');

            resource.get(
                {
                    id : this.$route.params.id
                },
                function (movie) {
                    this.$set('movie', movie);
                }
            );
        }
    }
};