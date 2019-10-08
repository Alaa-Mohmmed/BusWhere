/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import Vue from 'vue'
import VueRouter from 'vue-router'
	import { Bar } from 'vue-chartjs'

Vue.use(VueRouter)

// VForm    
import { Form, HasError, AlertError } from 'vform'
window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

let routes = [
    { path: '/Student', component: require('./components/StudentComponent.vue').default },
    { path: '/Driver', component: require('./components/DriverComponent.vue').default },
    { path: '/Supervisor', component: require('./components/SupervisorComponent.vue').default },
    { path: '/Bus', component: require('./components/BusComponent.vue').default },
    { path: '/Bus/:stationID', component: require('./components/StationComponent.vue').default,props:true },
      { path: '/Dashboard', component: require('./components/dashboard/dash.vue').default },

]


const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
})

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});
