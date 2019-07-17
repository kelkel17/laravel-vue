import VueRouter from 'vue-router'

let routes = [
	{ path: '/dashboard', components: require('../components/Dashboard') },
	{ path: '/users', components: require('../components/Users') },
	{ path: '/courses', components: require('../components/Courses') },
	{ path: '/profile', components: require('../components/Profile') },
	{ path: '/register/company', components: require('../components/RegisterCompany') },
]

export default new VueRouter({
	mode: 'history',
	routes
})