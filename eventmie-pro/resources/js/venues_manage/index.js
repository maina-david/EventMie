
/**
 * This is a page specific seperate vue instance initializer
 */

// include vue common libraries, plugins and components
require('../vue_common');

/**
 * Local Third-party Lib Imports
*/

/* Components */
import CKEditor from 'ckeditor4-vue';
window.ckeditor = CKEditor.component;
Vue.component('ckeditor', window.ckeditor).default;


/**
 * Local Components 
 */
import Venues from './components/Venues';

/**
 * Local Vue Routes 
 */
const routes = new VueRouter({
    mode: 'history',
    base: '/',
    linkExactActiveClass: 'there',
    routes: [
        {
            path: path ? '/'+path+'/myvenues' : '/myvenues',
            // Inject  props based on route.query values for pagination
            props: (route) => ({
                page: route.query.page,
                
            }),
            name: 'Venues',
            component: Venues,

        },
    ],
});

/**
 * This is where we finally create a page specific
 * vue instance with required configs
 * element=app will remain common for all vue instances
 * 
 */
window.app = new Vue({
    el: '#eventmie_app',
    router: routes,
});