import React from 'react';
import {withGoogleMap, GoogleMap, Marker} from "react-google-maps";


export default class SearchMap extends React.Component {
  constructor(props){
    super(props);

    this.state = {
      markers: props.results.map((business, index) =>{
        return {
          position: new google.maps.LatLng({lat: parseFloat(business.lat), lng: parseFloat(business.lng)}),
          title: business.name,
          label: (index + 1).toString(),
          id: business.id
        }
      })
    }
  }


  componentWillReceiveProps(nextProps){
    this.setState({
      markers: nextProps.results.map((business, index) =>{
        return {
          position: new google.maps.LatLng({lat: parseFloat(business.lat), lng: parseFloat(business.lng)}),
          title: business.name,
          label: (( index + 1 ) + (( nextProps.page - 1 ) * 10 )).toString(),
          id: business.id
        }
      })
    });
  }


  _fitBounds(map){
    if(map){
      let bounds = new google.maps.LatLngBounds();
      this.state.markers.forEach((marker) => {
        bounds.extend(marker.position);
      });
      map.fitBounds(bounds);
    }
  }


  _markerClick(marker){
    console.log(marker);
    this.props.markerClicked(marker.id);
  }


  render() {
    const GettingStartedGoogleMap = withGoogleMap(props => (
      <GoogleMap
        ref={props.onMapLoad}
        defaultZoom={3}
        defaultCenter={{ lat: -25.363882, lng: 131.044922 }}
      >
        {props.markers.map((marker, index) => (
          <Marker
            {...marker}
            key={index}
            id={marker.id}
            onClick={() => this._markerClick(marker)}
          />
        ))}
      </GoogleMap>
    ));

    return(
      <GettingStartedGoogleMap
        containerElement={
          <div style={{ height: `300px` }} />
        }
        mapElement={
          <div style={{ height: `300px` }} />
        }
        onMapLoad={this._fitBounds.bind(this)}
        markers={this.state.markers}
      />
    );
  }
}
