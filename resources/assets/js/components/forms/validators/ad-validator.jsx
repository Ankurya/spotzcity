export default function AdValidator(e){
  console.log(e);
  e.preventDefault();

  let form = e.target;

  let ad_validator = new Validatinator({
    'ad-info': {
      'ad_name': 'required|maxLength:50',
      'url': 'required|url',
      'ad': 'required',
      'type': 'required'
    }
  });

  console.log(ad_validator);


  if(ad_validator.passes('ad-info')){
    console.info('Form passes.');

    // Check ad dimensions, if correct, submit
    let type = form.querySelector('select').value.split('-')[1];
    let indicator = form.querySelector(`#${type}-indicator`);
    if(indicator.getAttribute('data-valid') !== "true"){
      alert('Image Dimensions are incorrect.');
      return;
    } else{
      e.target.submit();
    }
  }


  if(ad_validator.fails('ad-info')){
    console.error('Form fails.');

    let errors = ad_validator.errors['ad-info'];
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

