export default function RatingBar(el, interactive = false){
  var ratingInput = el.querySelector('#rating-input')
  var initialRating = ratingInput.value // Track rating bar should be set to
  let elements = el.getElementsByClassName('rating-icon')
  var starElements = Object.keys(elements).map((value) => {
    return elements[value]
  })
  var timeout = null


  var clickStar = function(e){
    let rating = e.target.getAttribute('data-rating-level')
    ratingInput.value = rating
    starElements.forEach((starElement) => {
      let compare = starElement.getAttribute('data-rating-level')
      //console.log(compare, rating)
      if(compare <= rating){
        starElement.classList.remove('inactive')
        starElement.classList.add('active')
      } else{
        starElement.classList.remove('active')
        starElement.classList.add('inactive')
      }
    })
  }


  var hoverStar = function(e){
    clearTimeout(timeout)
    let rating = e.target.getAttribute('data-rating-level')
    ratingInput.value = rating
    starElements.forEach((starElement) => {
      let compare = starElement.getAttribute('data-rating-level')
      if(compare <= rating){
        starElement.classList.add('hover')
      } else{
        starElement.classList.remove('hover')
      }
    })
  }


  var mouseOut = function(e){
    timeout = setTimeout(() => {
      for(let starElement of starElements){
        starElement.classList.remove('hover')
      }
    }, 100)
  }


  // Init
  starElements.forEach((starElement) => {
    if(starElement.getAttribute('data-rating-level') <= initialRating){
      starElement.classList.remove('inactive')
      starElement.classList.add('active')
    }
    if(interactive){
      starElement.addEventListener('click', clickStar)
      starElement.addEventListener('mouseover', hoverStar)
      starElement.addEventListener('mouseout', mouseOut)
    }
  })
}
