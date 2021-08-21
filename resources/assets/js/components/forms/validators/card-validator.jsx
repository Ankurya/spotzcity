export default function CardValidator(e){
  e.preventDefault();

  let form = e.target;

  let card_validator = new Validatinator({
    'card': {
      'card_number': 'required|number',
      'card_name': 'required',
      'zip': 'required|digitsLength:5',
      'exp_month': 'required',
      'exp_year': 'required',
      'cvv': 'required|number'
    }
  });


  if(card_validator.passes('card')){
    console.info('Form passes.');
    // NEED TO TOKENIZE THE CARD DATA AND PASS THAT INSTEAD OF ACTUAL DATA
    let data = new FormData(form);
    let stripeData = {
      number: data.get('card_number'),
      cvc: data.get('cvv'),
      name: data.get('card_name'),
      address_zip: data.get('zip'),
      exp_month: data.get('exp_month'),
      exp_year: data.get('exp_year')
    };

    console.log(stripeData);

    Stripe.card.createToken(stripeData, (status, response) => {
      console.log(status, response);

      if(response.error){
        // Return error to user
        alert(response.error.message);
        return;
      } else{
        // Get rid of card values
        form.querySelector('[name="card_number"]').value = '';
        form.querySelector('[name="cvv"]').value = '';
        form.querySelector('[name="card_name"]').value = '';
        form.querySelector('[name="zip"]').value = '';
        form.querySelector('[name="exp_month"]').value = '';
        form.querySelector('[name="exp_year"]').value = '';

        // Insert token value to form
        form.querySelector('[name="card_token"]').value = response.id;

        // Submit
        form.submit();
      }
    });
  }


  if(card_validator.fails('card')){
    console.error('Form fails.');

    let errors = card_validator.errors['card'];
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

