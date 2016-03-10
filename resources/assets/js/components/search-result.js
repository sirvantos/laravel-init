module.exports = {
    template: require('./search-result.template.html'),

    props: ['query'],

    data: function() {
        return {
            dynatable : null
        };
    },

    watch: {
        'query' : function () {
            this.initDynatable();
        }
    },

    methods : {
        initDynatable: function() {
            var self = this;

            if (self.dynatable)
            {
                self.dynatable.queries.remove("q");

                if (self.query) {
                    self.dynatable.queries.add("q", this.query);
                }

                self.dynatable.process();
            }

            // Function that renders the list items from our records
            function ulWriter(rowIndex, record, columns, cellWriter) {
                var cssClass = "col-md-3", li, id = record._id;
                if (rowIndex % 3 === 0) { cssClass += ' first'; }

                record = record._source;

                li =
                    '<li class="' + cssClass + '">'
                    + '<div class="thumbnail">'
                    + '<div class="thumbnail-image"><img class="img-responsive" alt="' + record.title + '" src="' + record.poster + '"/></div>'
                    + '<div class="movie-meta">'
                    +   '<div><h5 class="caption">' + record.title + '</h5></div>'
                    +   '<div class="imdb-rating"><span>imdb rating: ' + (record.imdb_rating ? record.imdb_rating : 'none')  + '</span></div>'
                    +   '<div class="more"><span><a href="#!/movie/' + id + '">More</a></span></div>'
                    + '</div>'
                    + '</div>'
                    + '</li>';

                return li;
            }

            var queries = {};

            if (self.query)
            {
                queries.q = self.query;
            }

            self.dynatable = $(this.$els.dynatable).dynatable({
                table: {
                    bodyRowSelector: 'li'
                },
                features: {
                    pushState: false,
                    sort: false,
                    search: false
                },
                dataset: {
                    ajax: true,
                    ajaxUrl: '/api/movies',
                    ajaxOnLoad: true,
                    queries : queries,
                    perPageDefault: 4,
                    perPageOptions: [4, 8, 12, 16],
                    records: []
                },
                writers: {
                    _rowWriter: ulWriter
                }
            }).data('dynatable');
        }
    }
};