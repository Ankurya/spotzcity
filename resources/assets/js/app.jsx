import React from 'react'
import ReactDOM from 'react-dom'
import LogoDrop from './components/forms/LogoDrop.jsx'
import AdDrop from './components/forms/AdDrop.jsx'
import AdFormInteraction from './components/forms/interaction/ad-interaction.jsx'
import AdValidator from './components/forms/validators/ad-validator.jsx'
import UserValidator from './components/forms/validators/user-validator.jsx'
import CardValidator from './components/forms/validators/card-validator.jsx'
import SaleValidator from './components/forms/validators/sale-validator.jsx'
import ConferenceValidator from './components/forms/validators/conference-validator.jsx'
import FeaturedDrop from './components/forms/FeaturedDrop.jsx'
import EventsSpecialsContainer from './components/events-specials/EventsSpecialsContainer.jsx'
import ReviewReplyContainer from './components/review-reply/ReviewReplyContainer.jsx'
import SearchContainer from './components/search/SearchContainer.jsx'
import Resources from './components/resources/Resources.jsx'
import ActivityFeed from './components/activity-feed/ActivityFeed.jsx'
import BusinessValidator from './components/forms/validators/business-validator.jsx'
import BusinessFormInteraction from './components/forms/interaction/business-interaction.jsx'
import RatingBar from './components/forms/interaction/rating-bar.jsx'
import HotSpotz from './components/hot-spotz/HotSpotz.jsx'
import AdminSearch from './components/admin-search/AdminSearch.jsx'


$(() => {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // Logo uploader element
  var logoDropElement = document.getElementById('logo-drop');
  if(logoDropElement){
    ReactDOM.render(
      <LogoDrop img={logoDropElement.getAttribute('logo-url')}/>,
      logoDropElement
    );
  }

  // Featured uploader element
  var featuredDropElement = document.getElementById('featured-drop');
  if(featuredDropElement){
    ReactDOM.render(
      <FeaturedDrop img={featuredDropElement.getAttribute('images')} businessid={featuredDropElement.getAttribute('businessid')}/>,
      featuredDropElement
    );
  }

  // Ad uploader element
  var adDropElement = document.getElementById('ad-drop');
  if(adDropElement){
    ReactDOM.render(
      <AdDrop
        img={adDropElement.getAttribute('image')}
        sidebarEdit={adDropElement.getAttribute('sidebar-edit')}
        bannerEdit={adDropElement.getAttribute('banner-edit')}
      />,
      adDropElement
    );
  }

  // User Form Validation
  var userForm = document.getElementById('user-info-form');
  if(userForm){
    userForm.addEventListener("submit", UserValidator, false);
  }

  // Ad Form Validation + Interactivity
  var adForm = document.getElementById('ad-info-form');
  if(adForm){
    adForm.addEventListener("submit", AdValidator, false);
    AdFormInteraction(adForm);
  }

  // Business Form Validation + Interactivity
  var businessForm = document.getElementById('business-info-form');
  if(businessForm){
    businessForm.addEventListener("submit", BusinessValidator, false);
    BusinessFormInteraction(businessForm);
  }

  // Sale Info Form Validation
  var saleForm = document.getElementById('sale-info-form');
  if(saleForm){
    saleForm.addEventListener("submit", SaleValidator, false);
  }

  // Card Form Validation
  var cardForm = document.getElementById('card-form');
  if(cardForm){
    cardForm.addEventListener("submit", CardValidator, false);
  }

  // Conference Form Validation + Datetime pickers
  var conferenceForm = document.getElementById('conference-form')
  if(conferenceForm){
    conferenceForm.addEventListener("submit", ConferenceValidator, false)

    // Activate Conference Start and End datetimepickers, show on input focus
    var start_picker_input = $('#start-picker input')
    var start_picker = $('#start-picker').datetimepicker({
      format: "MM/DD/YYYY",
      defaultDate: start_picker_input.value ? start_picker.value : false,
      icons: {
        time: "icon-clock",
        date: "icon-calendar",
        up: "icon-arrow-up",
        down: "icon-arrow-down",
        previous: "icon-arrow-left",
        next: "icon-arrow-right",
        today: "icon-target",
        clear: "icon-reload",
        close: "icon-close"
      }
    })
    $('#start-picker>input').focus(() => {
      start_picker.data('DateTimePicker').show()
    })

    var end_picker_input = $('#end-picker input')
    var end_picker = $('#end-picker').datetimepicker({
      format: "MM/DD/YYYY",
      defaultDate: end_picker_input.value ? end_picker.value : false,
      icons: {
        time: "icon-clock",
        date: "icon-calendar",
        up: "icon-chevron-up",
        down: "icon-chevron-down",
        previous: "icon-arrow-left",
        next: "icon-arrow-right",
        today: "icon-target",
        clear: "icon-reload",
        close: "icon-close"
      }
    })
    $('#end-picker>input').focus(() => {
      end_picker.data('DateTimePicker').show()
    })
  }

  // Search conferences date pickers
  var conferenceSearch = document.getElementById('conference-search')
  if(conferenceSearch){

    // Activate Conference Start and End datetimepickers, show on input focus
    var start_picker_input = $('#start-picker input')
    var start_picker = $('#start-picker').datetimepicker({
      format: "MM/DD/YYYY",
      defaultDate: start_picker_input.value ? start_picker.value : false,
      icons: {
        time: "icon-clock",
        date: "icon-calendar",
        up: "icon-arrow-up",
        down: "icon-arrow-down",
        previous: "icon-arrow-left",
        next: "icon-arrow-right",
        today: "icon-target",
        clear: "icon-reload",
        close: "icon-close"
      }
    })
    $('#start-picker>input').focus(() => {
      start_picker.data('DateTimePicker').show()
    })


    var end_picker_input = $('#end-picker input')
    var end_picker = $('#end-picker').datetimepicker({
      format: "MM/DD/YYYY",
      defaultDate: end_picker_input.value ? end_picker.value : false,
      icons: {
        time: "icon-clock",
        date: "icon-calendar",
        up: "icon-chevron-up",
        down: "icon-chevron-down",
        previous: "icon-arrow-left",
        next: "icon-arrow-right",
        today: "icon-target",
        clear: "icon-reload",
        close: "icon-close"
      }
    })
    $('#end-picker>input').focus(() => {
      end_picker.data('DateTimePicker').show()
    })
  }

  // Business Events and Specials Viewer/Form/Editor
  var eventsSpecialsContainer = document.getElementById('events-specials-container');
  if(eventsSpecialsContainer){
    ReactDOM.render(
      <EventsSpecialsContainer businessid={eventsSpecialsContainer.getAttribute('businessid')} />,
      eventsSpecialsContainer
    );
  }

  // Business Rating Bar
  var ratingBarElement = document.getElementById('rating-bar')
  if(ratingBarElement){
    let interactive_flag = $(ratingBarElement).data('interactive')
    RatingBar(ratingBarElement, interactive_flag)
  }

  // Business Reply to Review
  var reviewReplies = document.getElementsByClassName('review-reply');
  for(let i=0;i<reviewReplies.length; i++){
    let reviewReplyElement = reviewReplies[i];
    ReactDOM.render(
      <ReviewReplyContainer
        reviewId={reviewReplyElement.getAttribute('reviewId')}
        responseBody={reviewReplyElement.getAttribute('responseBody')}
        businessName={reviewReplyElement.getAttribute('businessName')}
        createdAt={reviewReplyElement.getAttribute('createdAt')}
        updatedAt={reviewReplyElement.getAttribute('updatedAt')}
       />,
      reviewReplyElement
    );
  }

  // Trigger event for analytics graph resize
  var analyticsTabs = document.getElementById('analytics-tabs');
  if(analyticsTabs){
    $('#analytics-tabs li').click((e) => {
      lava.redrawCharts();
    });
  }

  // Activity Feed component
  var feedElement = document.getElementById('activity-feed');
  if(feedElement){
    let loggedIn = feedElement.getAttribute('loggedIn') == 'true';
    ReactDOM.render(
      <ActivityFeed loggedIn={loggedIn} />,
      feedElement
    );
  }

  // Search component
  var searchElement = document.getElementById('search');
  if(searchElement){
    let category_list = JSON.parse(searchElement.getAttribute('data-categories'));
    let commodity_list = JSON.parse(searchElement.getAttribute('data-commodities'));
    ReactDOM.render(
      <SearchContainer categoryList={category_list} commodityList={commodity_list} />,
      searchElement
    );
  }

  // Resources component
  var resourcesElement = document.getElementById('resources')
  if(resourcesElement){
    let category_list = JSON.parse(resourcesElement.getAttribute('data-categories'))
    ReactDOM.render(
      <Resources categoryList={category_list} />,
      resourcesElement
    )
  }

  // Follow Business Action
  var followButton = document.getElementById('follow-button')
  if(followButton){
    followButton.addEventListener('click', (e) => {
      let id = followButton.getAttribute('business-id')
      let following = parseInt(followButton.getAttribute('following'))
      if(!following){
        $.get(`/business/${id}/follow`, (data) =>{
          if(data.success){
            followButton.innerHTML = '<i class="icon-check"></i> Following'
            followButton.setAttribute('following', 1)
          }
        })
      } else{
        $.ajax({
          url: `/business/${id}/follow`,
          type: 'DELETE',
          success: (data) => {
            followButton.innerHTML = '<i class="icon-heart"></i> Follow'
            followButton.setAttribute('following', 0)
          }
        })
      }
    })
  }


  // Hot Spotz
  var hotSpotzEl = document.getElementById('hot-spotz')
  if(hotSpotzEl){
    let category_list = JSON.parse(hotSpotzEl.getAttribute('data-categories'))
    ReactDOM.render(
      <HotSpotz categoryList={category_list} />,
      hotSpotzEl
    )
  }


  // Admin Search
  var adminSearchEl = document.getElementById('admin-search')
  if(adminSearchEl){
    ReactDOM.render(
      <AdminSearch/>,
      adminSearchEl
    )
  }

  // Delete page
  $('.delete-page').click( function(e) {
    let c = confirm('Are you sure?')
    if(!c) {
      e.preventDefault()
      return
    }
  })


  // Stripe form (subscribe)
  var stripeEl = document.getElementById('stripe-form')
  if( stripeEl ) {
    var elements = stripe.elements()
    var cardElement = elements.create('card')
    cardElement.mount( stripeEl )

    // Handle submit
    $('#card-submit').click( function( e ) {
      e.preventDefault()

      // Tokenize
      window.stripe.createToken( cardElement ).then( function(result) {
        if( result.error ) {
          alert( result.error.message )
        } else {
          $('#card-token').val( result.token.id )
          $('#card-form').submit()
        }
      })
    })
  }


  // Page Editor
  var pageEditorEl = document.getElementById('page-form')
  if(pageEditorEl){
    // Store HTML content from editor in hidden input
    var $content = $('#content-holder')

    // Translate title to slug
    var $title = $('#title')
    var $slug = $('#slug')
    $title.change( function() {
      $slug.val( transformSlug( $title.val() ) )
    })

    var options = [
      ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
      ['blockquote', 'code-block'],

      [{ 'header': 1 }, { 'header': 2 }],               // custom button values
      [{ 'list': 'ordered'}, { 'list': 'bullet' }],
      [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
      [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
      [{ 'direction': 'rtl' }],                         // text direction

      [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
      [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
      [ 'link', 'image', 'video' ],                     // add's image support
      [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
      [{ 'font': [] }],
      [{ 'align': [] }],

      ['clean']                                         // remove formatting button
    ];

    var quill = new Quill('#editor', {
      theme: 'snow',
      modules: {
        toolbar: options
      },
      placeholder: 'Enter page content here...',
    })

    quill.on('text-change', function(d, o, m){
      $content.val( quill.root.innerHTML )
    })
  }


  // Admin categories
  var catPage = document.getElementById('categories-admin-form')
  if( catPage ) {
    // Create
    $('.create-category').click( function() {
      let $this = $(this)
      let type = $this.data('type')
      let value = $(`input[name=${type}-new]`).val()
      console.log('create category:', type, value)

      $.post('/admin/categories/create', {
        type: type,
        name: value
      })
      .done( function(data) {
        console.log(data)
        alert('Category added!')
        window.location.reload()
      })
      .fail( function(data) {
        console.log(data)
        alert('An error has occurred. Please try again.')
      })
    })

    // Update
    $('.update-category').click( function() {
      let $this = $(this)
      let type = $this.data('type')
      let id = $this.data('id')
      let value = $(`input[name=${type}-${id}]`).val()
      console.log('update category:', type, id, value)

      $.post('/admin/categories/update', {
        id: id,
        type: type,
        name: value
      })
      .done( function(data) {
        console.log(data)
        alert('Category updated!')
      })
      .fail( function(data) {
        console.log(data)
        alert('An error has occurred. Please try again.')
      })
    })
  }
});

function transformSlug( title ) {
  return title.replace(/\W/g, '-').toLowerCase()
}
