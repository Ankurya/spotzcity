export default function ConferenceValidator(e){
  e.preventDefault();

  let form = e.target;

  let conference_validator = new Validatinator({
    'conference': {
      'conference_name': 'required',
      'website': 'url',
      'starts': 'required',
      'ends': 'required',
      'venue': 'required',
      'location': 'required'
    }
  });


  if(conference_validator.passes('conference')){
    console.info('Form passes.');
    form.submit();
  }


  if(conference_validator.fails('conference')){
    console.error('Form fails.');

    let errors = conference_validator.errors['conference'];
    console.log(errors);

    Object.keys(errors).forEach((field) => {

      // Grab first error for every field
      let error = errors[field][Object.keys(errors[field])[0]];

      // Display errors
      let error_msg = document.createElement('span');
      error_msg.classList.add('pull-right', 'error-msg');
      error_msg.innerHTML = error;

      let el = form.querySelector(`[for=${field}]`);

      let previous_error = el.getElementsByTagName('span')[0];
      if(previous_error) previous_error.remove();

      el.appendChild(error_msg);
    });
  }
}

