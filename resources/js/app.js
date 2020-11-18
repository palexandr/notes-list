require('./bootstrap');

window.Vue = require('vue');

Vue.component('note-component', require('./components/NoteComponent.vue').default);

import App from './App.vue';
import { BModal, VBModal } from 'bootstrap-vue'
import FormPlugin from 'bootstrap-vue'
import VueAxios from 'vue-axios';
import axios from 'axios';

Vue.use(FormPlugin);
Vue.use(VueAxios, axios);
Vue.component('BModal', BModal);
Vue.directive('b-modal', VBModal);

const app = new Vue({
    el: '#app',
    components: {
      App
    },
    render: h => h(App)
  });
