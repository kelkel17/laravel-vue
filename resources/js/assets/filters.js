import moment from 'moment'
window.moment = moment;

let capitalize = Vue.filter('capitalize', function (value) {
  if (!value) return ''
  value = value.toString()
  return value.charAt(0).toUpperCase() + value.slice(1)
})

let date = Vue.filter('moment', function (date) {
  return moment(date).format('MMMM Do YYYY');
})

let time = Vue.filter('time', function(time) {
    return moment(time).format('hh:mm:ss A');
})

let filters = {
	capitalize,
    date,
    time
}

export default filters
