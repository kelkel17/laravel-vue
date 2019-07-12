import './bootstrap';
import router from './assets/routes'
import filters from './assets/filters'
import plugins from './assets/usePlugins'
import components from './assets/components'
import toast from './assets/sweetalert'

const app = new Vue({
  el: '#app',
  router
});