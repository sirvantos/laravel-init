module.exports = {
    template: require('./search.template.html'),

    props: ['when-found'],

    data: function() {
        return {
            query : '',
            movies : [],
            selectedMovie : {}
        };
    },

    events: {
      'router:after-switch' : function (transition) {

          if (transition.to.path !== '/movies/search') {
            this.query = null;
          }

          return true;
      }
    },

    created: function () {},

    ready: function () {
        var self = this;

        var moviesSource = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: '/api/movies/auto/complete?q=%QUERY',
                wildcard: '%QUERY',
                transform: function (response) {
                    var transformed = [];

                    $.each(response.records, function (key, value) {
                        transformed.push({
                            id : value._id,
                            title : value._source.title
                        });
                    });

                    return transformed;
                }
            }
        });

        $('#search-bar .typeahead').typeahead(
            {
                hint: false,
                highlight: true,
                minLength: 3
            },
            {
                limit: 10,
                name: 'Movies',
                display: 'title',
                source: moviesSource
            }
        ).on('typeahead:select', function (e, suggestion) {
                if ( ! suggestion.id)
                {
                    return false;
                }

                self.selectedMovie = suggestion;

                self.$route.router.go({
                    name: 'movie',
                    params: {
                        id: suggestion.id
                    }
                });
            });
    },

    watch: {},

    methods: {
        showResult : function ()
        {
            this.$route.router.go({
                name: 'search-result',
                query: { q : this.query }
            });
        }
    }
};