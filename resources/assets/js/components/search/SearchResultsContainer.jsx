import React from 'react';
import {Modal} from 'react-bootstrap';
import {Button} from 'react-bootstrap';

import SearchResult from './SearchResult.jsx';
import SearchMap from './SearchMap.jsx';

export default class SearchResultsContainer extends React.Component {
  constructor(props){
    super();

    this.state = {
      results: [],
      ad: null
    }
  }


  componentWillReceiveProps(nextProps){
    let self = this;

    this.setState({
      results: nextProps.results
    });

    // Retrieve new ad everytime search is updated
    $.ajax({
      method: 'GET',
      url: '/search-ad',
    })
    .done((resp) => {
      console.info(resp);
      self.setState({
        ad: resp
      });
    })
    .fail((resp)=>{
      console.log(resp);
    });
  }


  componentDidMount(){
    // Sticky scroll map
    var $div = $('.side-map');
    var $anc = $('.anchor');
    var $col = $('.map-column');
    $(window).scroll((e)=>{
      let window_top = $(window).scrollTop();
      let div_top = $anc.offset().top;
      let div_side = $col.offset().left;
      if(window_top > div_top){
        $div.addClass('stick');
        $div.css({
          'width': $anc.width()+'px'
        })
      } else{
        $div.removeClass('stick');
      }
    });
  }


  _markerClicked(marker){
    let $business = $(`#${marker}.business-result`);
    let top = $business.offset().top;
    $business.addClass('active');
    $(window).scrollTop(top - 50);
    setTimeout(() =>{
      $business.removeClass('active');
    }, 2500);
  }


  render() {
    return(
      <div className="search-results">
        <div className="col-md-8 col-xs-12 no-pad-left no-pad-small">
          {this.state.results.map((business, index) =>{
            return(
              <SearchResult
                key={business.id}
                index={(index+1) + ((this.props.page - 1) * 10)}
                business={business}
              />
            );
          })}
          {this.state.results.length ? '' : <p className="no-results text-center">No results</p>}
        </div>
        <div className="col-md-4 hidden-xs map-column no-pad-right">
          <div className="anchor"></div>
          <div className="side-map">
            <SearchMap
              markerClicked={this._markerClicked.bind(this)}
              page={this.props.page}
              results={this.state.results}
            />
            <hr/>
            {this.state.ad ?
              <a className="search-ad" href={`/ad-redirect/${this.state.ad.id}?ref=search`} target="_blank">
                <img className="img-responsive" src={`assets/storage/${this.state.ad.image}`} />
              </a>
              :
              ''
            }
          </div>
        </div>
      </div>
    );
  }
}
