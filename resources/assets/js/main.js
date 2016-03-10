var Vue = require('vue');
var VueRouter = require('vue-router');

Vue.use(VueRouter);

Vue.use(require('vue-resource'));

/**
 * Created by sirvantos on 16/10/15.
*/

Vue.component('search', require('./components/search.js'));
Vue.component('search-result', require('./components/search-result.js'));

// The router needs a root component to render.
// For demo purposes, we will just use an empty one
// because we are using the HTML as the app template.
var App = Vue.extend({
    'el' : function () {
        return '#app'
    },

    data : function () {
        return {
            basePageTitle : 'My Imdb',
            pageTitlePostfix : ''
        };
    },

    computed: {
        pageTitle: function () {
            return this.basePageTitle + ' | ' + this.pageTitlePostfix;
        }
    },

    created : function () {
        Vue.http.options.root = '/api';
    },

    ready : function () {}
});

// Create a router instance.
// You can pass in additional options here, but let's
// keep it simple for now.
var router = new VueRouter();

// Define some routes.
// Each route should map to a component. The "component" can
// either be an actual component constructor created via
// Vue.extend(), or just a component options object.
// We'll talk about nested routes later.
router.map({
    '/': {
        component: require('./controllers/index')
    },
    '/movies': {
        component: require('./controllers/movies')
    },
    '/movie/:id': {
        name : 'movie',
        component: require('./controllers/movie')
    },
    '/movies/search': {
        name : 'search-result',
        component: require('./controllers/search-result')
    },
    '/about': {
        component: require('./controllers/about')
    }
});

router.beforeEach(function (transition) {
    router.app.$broadcast('router:before-switch', transition);

    transition.next();
});

router.afterEach(function (transition) {
    router.app.$broadcast('router:after-switch', transition);
});

// Now we can start the app!
// The router will create an instance of App and mount to
// the element matching the selector #app.
router.start(App, '#app');