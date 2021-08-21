import React from 'react'
import {Modal} from 'react-bootstrap'
import {Button} from 'react-bootstrap'
import URI from 'urijs'
import createHistory from 'history/createBrowserHistory'

import SearchParameters from './SearchParameters.jsx'
import SearchResultsContainer from './SearchResultsContainer.jsx'
import SearchPages from './SearchPages.jsx'

export default class SearchContainer extends React.Component {
  constructor(props){
    super(props)

    this.state = {
      results: [],
      pagination: {},
      loading: false
    };
  }


  componentDidMount(){
    let self = this
    let {params, page} = this._getSearchData()
    this._executeSearch(params, page)

    // Set listener for location change (specifically for forward/back usage)
    let history = createHistory()
    history.listen((location, action) => {
      console.log(location, action)
      if(location.state){
        let {params, page} = this._getSearchData()
        self._executeSearch(params, page)
      }
    });
  }


  _getSearchData(){
    // Pull in URL info here
    let url = new URI(window.location.href)
    let urlData = url.search(true)
    let history = createHistory()
    let params = {}

    // Build search params from URL data
    let page = urlData.page || 1

    // Sort
    params.sort = urlData.sort || "most_reviews"

    // Location
    if(urlData.location){
      params.location = urlData.location
    }

    // Categories
    if(urlData.categories){
      params.categories = urlData.categories.split(',')
    }

    // Commodities
    if(urlData.commodities){
      params.commodities = urlData.commodities.split(',')
    }

    // Sale Only
    if(typeof urlData.for_sale != 'undefined'){
      params.sale = {}
      params.sale.sale_only =  true

      if(urlData.min){
        params.sale.min = urlData.min
      }

      if(urlData.max){
        params.sale.max = urlData.max
      }
    }

    return {params: params, page: page}
  }


  _executeSearch(params, page = null){
    var self = this

    var url = new URI(window.location.href);
    var history = createHistory()

    this.setState({
      loading: true
    });

    $(window).scrollTop(0);
    $.ajax({
      method: 'POST',
      url: `/query${page ? '?page='+page : ''}`,
      data: JSON.stringify(params),
      dataType: 'json',
      contentType: 'application/json'
    })
    .done((resp) => {
      console.info(resp)
      self.setState({
        results: resp.data,
        pagination: {
          total_results: resp.total,
          per_page: resp.per_page,
          current_page: resp.current_page,
          last_page: resp.last_page
        },
        loading: false
      })
    })
    .fail((resp)=>{
      console.log(resp);
    })
  }


  _pageChanged(page_selected){
    let {params} = this._getSearchData()
    this._executeSearch(params, page_selected)
  }


  render() {
    const styles = {
      opacity: this.state.loading ? 0.25 : 1
    }

    const loader = this.state.loading ?
      <div className="loading-overlay">
        <div className='uil-magnify-css' style={{transform: "scale(0.6)"}}>
          <div className="group">
            <div className="grip"></div>
            <div className="inner-circle"></div>
            <div className="outer-circle"></div>
          </div>
        </div>
      </div>
      :
      null

    return(
      <div style={styles}>
        <div className="row">
          <SearchParameters
            categoryList={this.props.categoryList}
            commodityList={this.props.commodityList}
            executeSearch={this._executeSearch.bind(this)}
          />
        </div>
        <div className="row">
          <SearchResultsContainer results={this.state.results} page={this.state.pagination.current_page} />
        </div>
        <div className="row">
          <SearchPages
            currentPage={this.state.pagination.current_page}
            totalResults={this.state.pagination.total_results}
            perPage={this.state.pagination.per_page}
            lastPage={this.state.pagination.last_page}
            pageChanged={this._pageChanged.bind(this)}
          />
        </div>
        {loader}
      </div>
    )
  }
}
