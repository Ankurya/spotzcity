export default function SaleValidator(e){
  e.preventDefault();

  let form = e.target;

  let sale_validator = new Validatinator({
    'sale-info': {
      'ein': 'required',
      'sale_price': 'required',
      'established': 'required|digitsLength:4',
      'gross_income': 'required',
      'reason': 'required'
    }
  });


  if(sale_validator.passes('sale-info')){
    console.info('Form passes.');
    form.submit();
  }


  if(sale_validator.fails('sale-info')){
    console.error('Form fails.');

    let errors = sale_validator.errors['sale-info'];
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

