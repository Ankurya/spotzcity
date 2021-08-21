import React from 'react'
import {Button, ButtonToolbar} from 'react-bootstrap'
import Autocomplete from 'react-google-autocomplete'
import _ from 'lodash'

export default class SearchLocationForm extends React.Component {
  constructor(props){
    super(props)

    this.state = {
      location: props.locationParams ? props.locationParams : ''
    }
  }


  _onPlaceSelected(place){
    let new_location = _.assign(this.state.location, {
      name: place.formatted_address,
      geo: place.geometry.location
    })
    this.setState({
      location: new_location
    })
  }


  _getCurrentLocation(){
    let geocoder = new google.maps.Geocoder
    navigator.geolocation.getCurrentPosition( (pos) => {
      let latLng = new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude)
      geocoder.geocode({location: latLng}, (results, status) =>{
        if(status === 'OK'){
          if(results[1]){
            this.setState({
              location: {
                name: results[1].formatted_address,
                geo: results[1].geometry.location
              }
            })
          }
        }
      })
    })
  }


  _submit(e){
    e.preventDefault()
    this.props.submit(this.state.location)
  }


  _onChange(e){
    this.setState({
      location: e.target.value
    })
  }


  _onKey(e){
    if(e.key == 'Enter'){
      e.preventDefault()
    }
  }

  render() {
    return(
      <form onSubmit={this._submit.bind(this)}>
        <div className="form-group clearfix">
          <input
            className="form-control"
            placeholder="ZIP Code"
            value={this.state.location}
            onChange={this._onChange.bind(this)}
          />
        </div>
      </form>
    )
  }
}
