require('./bootstrap');

/////////////////////////////////////////////////////////////////////////////
// Vue Stuff
/////////////////////////////////////////////////////////////////////////////
//window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/*
Vue.component('example-component', require('./components/ExampleComponent.vue').default);

window.vm = new Vue({
    el: '#app'
});
*/

/////////////////////////////////////////////////////////////////////////////
// OUR CUSTOM LIBRARY IMPORTS
/////////////////////////////////////////////////////////////////////////////
require('./libs/listner');

/////////////////////////////////////////////////////////////////////////////
// 3RD PARTY LIBRARY IMPORTS
/////////////////////////////////////////////////////////////////////////////
import buttondisabler from 'buttondisabler';

// disable submit button after clicked once to avoid duplicatation
new buttondisabler({
    timeout: 5000,
    text: 'Wait...'
});

window.swal = require('sweetalert2');
window.Noty = require('noty');
window.mojs = require('mo-js');
window.pulsate = require('my-jquery-pulsate');

// DataTables
require('datatables.net');
require('datatables.net-bs4');
require('datatables.net-responsive');
require('datatables.net-responsive-bs4');

require('datatables.net-buttons');
require('datatables.net-buttons-bs4');
require('datatables.net-buttons/js/buttons.print.js');
require('datatables.net-buttons/js/buttons.colVis.js');
require('datatables.net-buttons/js/buttons.html5.js');
require('datatables.net-buttons/js/buttons.flash.js');

require('select2');
//require('summernote');
//require('bootstrap-validator');

