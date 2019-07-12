import VueRouter from 'vue-router'
import VueProgressBar from 'vue-progressbar'

window.vueProgressBar = VueProgressBar;

let vueRouter = Vue.use(VueRouter);
let vueProgress = Vue.use(VueProgressBar, {
	color: 'rgb(143, 255, 199)',
	failedColor: 'red',
	height: '3px'
})

let plugins = {
	vueRouter,
	vueProgress
}

export default plugins