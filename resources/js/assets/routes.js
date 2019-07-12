import VueRouter from 'vue-router'

let routes = [
	{ path: '/dashboard', components: require('../components/Dashboard') },
	{ path: '/users', components: require('../components/Users') },
	{ path: '/profile', components: require('../components/Profile') },
]

export default new VueRouter({
	mode: 'history',
	routes
})