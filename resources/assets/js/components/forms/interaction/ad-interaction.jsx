export default function AdFormInteraction(form){
  let type_selector = form.querySelector('select');

  let showHideIndicators = function(e, a, type = type_selector.value.split('-')[1]){
    let $banner_indicator = $('.banner-indicator');
    let $sidebar_indicator = $('.sidebar-indicator');

    switch(type){
      case 'banner':
        $banner_indicator.show();
        $banner_indicator.find('#indicator').addClass('active');

        $sidebar_indicator.find('#indicator').removeClass('active');
        $sidebar_indicator.hide();
        break;

      case 'sidebar':
        $sidebar_indicator.show();
        $sidebar_indicator.find('#indicator').addClass('active');

        $banner_indicator.find('#indicator').removeClass('active');
        $banner_indicator.hide();
        break;
    }
  }

  // Detect currently selected and hide indicator (banner or sidebar)
  showHideIndicators();

  // Set event listener to detect change of type
  type_selector.addEventListener('change', showHideIndicators, false);
}
