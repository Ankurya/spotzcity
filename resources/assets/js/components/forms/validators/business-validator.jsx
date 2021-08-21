import zenscroll from 'zenscroll';

export default function BusinessValidator(e){
  let form = event.target;

  let business_validator = new Validatinator({
    'business-info': {
      'business_name': 'required|maxLength:50',
      'address': 'required',
      'city': 'required',
      'state': 'required',
      'zip': 'required|digitsLength:5',
      'b_description': 'maxLength:2000',
      'e_categories_buffer[]': 'required',
      'commodities_buffer[]': 'required'
    }
  });


  if(business_validator.passes('business-info')){
    console.info('Form passes.');
    e.preventDefault();

    let checkboxes = form.getElementsByClassName('day_checkbox');

    for(let checkbox of checkboxes){
      if(!checkbox.checked) continue;

      let opens = form.querySelector(`[name=${checkbox.name}_opens]`);
      let closes = form.querySelector(`[name=${checkbox.name}_closes]`);

      opens.value = `${opens.value} ${moment().format('Z')}`;
      closes.value = `${closes.value} ${moment().format('Z')}`;
      console.info(opens.value, closes.value);
    }

    // Check global files array (used to prevent users from clearing previously selected files on FeaturedDrop component)
    // TO DO: FIX THIS TO WORK RIGHT
    //
    // if(window._files[0]){
    //   var files = [];
    //   let input = form.querySelector('.file-drop.featured');

    //   for(let file of window._files){
    //     if(file instanceof File) files.push(file);
    //   }

    //   $.each(files, (key, file)=>{
    //     input.files[key] = file;
    //   });
    //   console.log(input.files);
    // }

    e.target.submit();
  }


  if(business_validator.fails('business-info')){
    console.error('Form fails.');
    e.preventDefault();

    let errors = business_validator.errors['business-info'];

    Object.keys(errors).forEach((field) => {

      // Grab first error for every field
      let error = errors[field][Object.keys(errors[field])[0]];

      // Display errors
      let error_msg = document.createElement('span');
      error_msg.classList.add('pull-right', 'error-msg');
      error_msg.innerHTML = error;

      let el = document.querySelector(`[for=${field}]`);

      let scrollWindow = document.querySelector('body');
      let scroller = zenscroll.createScroller(scrollWindow, 500, 0);
      scroller.toY(0);

      let previous_error = el.getElementsByTagName('span')[0];
      if(previous_error) previous_error.remove();

      el.appendChild(error_msg);
    });
  }
}

