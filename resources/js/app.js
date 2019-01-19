require('./bootstrap');

/////////////////////////////////////////////////////////////////////////////
// Vue Stuff
/////////////////////////////////////////////////////////////////////////////
/*
window.Vue = require('vue');

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

window.vm = new Vue({
    el: '#app',
    router
});
*/

/////////////////////////////////////////////////////////////////////////////
// OUR CUSTOM LIBRARY IMPORTS
/////////////////////////////////////////////////////////////////////////////
require('./libs/listner');

/////////////////////////////////////////////////////////////////////////////
// 3RD PARTY LIBRARY IMPORTS
/////////////////////////////////////////////////////////////////////////////

// prefatch links during idle time
import quicklink from "quicklink/dist/quicklink.mjs";

quicklink();

window.swal = require('sweetalert2');
window.isMobile = require('ismobilejs');
window.Noty = require('noty');
window.mojs = require('mo-js');
window.pulsate = require('my-jquery-pulsate');
//window.disabler = require('disabler'); // to be fixed

// DataTables
require('datatables.net');
require('datatables.net-bs4');
require('datatables.net-responsive');
require('datatables.net-responsive-bs4');

require('datatables.net-buttons');
require('datatables.net-buttons-bs4');
require('datatables.net-buttons/js/buttons.colVis.js');
require('datatables.net-buttons/js/buttons.html5.js');
require('datatables.net-buttons/js/buttons.flash.js');
require('datatables.net-buttons/js/buttons.print.js');

require('select2');
//require('summernote');
//require('bootstrap-validator');

