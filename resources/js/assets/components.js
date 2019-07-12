import { Form, HasError, AlertError } from 'vform'
window.Form = Form;

let checkError = Vue.component(HasError.name, HasError);
let alertError = Vue.component(AlertError.name, AlertError);

let components = {
	checkError,
	alertError
}

export default components