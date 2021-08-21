export default function BusinessFormInteraction(form){

  let dayCheckBoxChange = function(e){
    let day = e.target.name;
    let checked = e.target.checked;

    console.log(day, checked);

    // Get associated time inputs based on day
    let inputs = [];
    inputs[0] = form.querySelector(`[name=${day}_opens]`);
    inputs[1] = form.querySelector(`[name=${day}_closes]`);

    console.log(inputs);
    if(checked){
      inputs.forEach(function(input, key){
        input.disabled = false;
      });
    } else{
      inputs.forEach(function(input, key){
        input.value = null;
        input.disabled = true;
      });
    }
  }

  // Enable business hour input timepickers
  let pickers = form.getElementsByClassName('time-picker');

  for(let picker of pickers){
    $(picker).timepicker({
      'timeFormat': 'h:i A'
    });
  }


  // Disable inputs when day is not checked, listen for changes
  let day_checkboxes = form.getElementsByClassName('day_checkbox');

  for(let checkbox of day_checkboxes){
    let day = checkbox.name;
    let inputs = [];
    inputs[0] = form.querySelector(`[name=${day}_opens]`);
    inputs[1] = form.querySelector(`[name=${day}_closes]`);

    if(checkbox.checked){
      inputs.forEach(function(input, key){
        input.disabled = false;
      });
    } else{
      inputs.forEach(function(input, key){
        input.value = null;
        input.disabled = true;
      });
    }

    checkbox.addEventListener('change', dayCheckBoxChange, false);
  }

}
