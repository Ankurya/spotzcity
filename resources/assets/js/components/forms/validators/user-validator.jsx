export default function UserValidator(e){
  e.preventDefault();

  let form = e.target;

  let user_validator = new Validatinator({
    'user-info': {
      'first_name': 'required',
      'last_name': 'required',
      'email': 'required'
    }
  });


  if(user_validator.passes('user-info')){
    console.info('Form passes.');
    form.submit();
  }


  if(user_validator.fails('user-info')){
    console.error('Form fails.');

    let errors = user_validator.errors['user-info'];
    console.log(errors);

    Object.keys(errors).forEach((field) => {

      // Grab first error for every field
      let error = errors[field][Object.keys(errors[field])[0]];

      // Display errors
      let error_msg = document.createElement('span');
      error_msg.classList.add('pull-right', 'error-msg');
      error_msg.innerHTML = error;

      let el = document.querySelector(`[for=${field}]`);

      let previous_error = el.getElementsByTagName('span')[0];
      if(previous_error) previous_error.remove();

      el.appendChild(error_msg);
    });
  }
}

