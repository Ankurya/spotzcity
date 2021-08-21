export default function ResourceValidator(e){
  console.log(e);
  e.preventDefault();

  let form = e.target;

  let resource_validator = new Validatinator({
    'resources-form': {
      'resource_name': 'required|maxLength:50',
      'category': 'required',
      'city': 'required',
      'state': 'required'
    }
  })


  if(resource_validator.passes('resources-form')){
    console.info('Form passes.')
    return true
  }


  if(resource_validator.fails('resources-form')){
    console.error('Form fails.')

    let errors = resource_validator.errors['resources-form'];
    console.log(errors)

    Object.keys(errors).forEach((field) => {

      // Grab first error for every field
      let error = errors[field][Object.keys(errors[field])[0]]

      // Display errors
      let error_msg = document.createElement('span')
      error_msg.classList.add('pull-right', 'error-msg')
      error_msg.innerHTML = error

      let el = document.querySelector(`[for=${field}]`)

      let previous_error = el.getElementsByTagName('span')[0]
      if(previous_error) previous_error.remove()

      el.appendChild(error_msg)
      return false
    })
  }
}

