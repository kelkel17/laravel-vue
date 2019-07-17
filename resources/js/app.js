import './bootstrap';
import router from './assets/routes'
import filters from './assets/filters'
import plugins from './assets/usePlugins'
import components from './assets/components'
import toast from './assets/sweetalert'


Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

const app = new Vue({
  el: '#app',
  router
});