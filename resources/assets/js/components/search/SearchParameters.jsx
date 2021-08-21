import React from 'react'
import {Modal} from 'react-bootstrap'
import {Button} from 'react-bootstrap'
import URI from 'urijs'
import createHistory from 'history/createBrowserHistory'

import SearchLocationForm from './SearchLocationForm.jsx'
import SearchCategoryForm from './SearchCategoryForm.jsx'
import SearchCommodityForm from './SearchCommodityForm.jsx'
import SearchSaleForm from './SearchSaleForm.jsx'

export default class SearchParameters extends React.Component {
  constructor(props){
    super(props)

    // Extract state from url
    var url = new URI(window.location.href)
    var history = createHistory()
    let urlData = url.search(true)
    let params = {}

    let page = urlData.page || 1

    // Sort
    params.sort = urlData.sort || "most_reviews"

    // Location
    if(urlData.location){
      params.location = urlData.location
    }

    // Categories
    if(urlData.categories){
      let category_ids = urlData.categories.split(',')

      // Map via the category list for display
      params.categories = []
      category_ids.forEach(id =>{
        params.categories.push(parseInt(id))
      })
    }

    // Commodities
    if(urlData.commodities){
      let commodity_ids = urlData.commodities.split(',')

      // Map via the commodity list for display
      params.commodities = []
      commodity_ids.forEach(id =>{
        params.commodities.push(parseInt(id))
      })
    }

    // Sale Only
    if(typeof urlData.for_sale != 'undefined'){
      params.sale = {}
      params.sale.sale_only = true

      if(urlData.min){
        params.sale.min = urlData.min
      }

      if(urlData.max){
        params.sale.max = urlData.max
      }
    } else{
      params.sale = {}
      params.sale.sale_only = false
    }

    this.state = {
      sort: params.sort,
      showLocationModal: false,
      locationParams: params.location || null,
      showCategoryModal: false,
      categoryParams: params.categories ||  [],
      showCommodityModal: false,
      commodityParams: params.commodities ||  [],
      showSaleModal: false,
      saleParams: params.sale || null
    }
  }


  _setSort(e){
    this.setState({sort: e.target.value}, this._executeSearch)
  }


  _submitCategories(categoryParams){
    this.setState({
      categoryParams
    }, this._executeSearch)
  }


  _sanitizeCategoryParams(params = []){
    if(!params.length) return null
    let new_arr = []
    params.forEach(value => {
      let category = _.find(this.props.categoryList, (n) => {
        return n.id === value
      })
      new_arr.push(category.id)
    })
    return new_arr
  }


  _submitCommodities(commodityParams){
    this.setState({
      commodityParams
    }, this._executeSearch)
  }


  _sanitizeCommodityParams(params = []){
    if(!params.length) return null
    let new_arr = []
    params.forEach(value => {
      let commodity = _.find(this.props.commodityList, (n) => {
        return n.id === value
      })
      new_arr.push(commodity.id)
    })
    return new_arr
  }


  _submitLocation(locationParams){
    this.setState({
      locationParams
    }, this._executeSearch)
  }


  _sanitizeLocationParams(params){
    if(!params) return null
    
    return params
  }


  _openSaleModal(){
    this.setState({showSaleModal: true})
  }


  _closeSaleModal(saleParams){
    if(!saleParams){
      this.setState({showSaleModal: false})
      return
    }
    if(saleParams.target){
      this.setState({showSaleModal: false})
      return
    }
    this.setState({
      showSaleModal: false,
      saleParams: saleParams
    }, this._executeSearch)
  }


  _setSaleOnly(e){
    let value = e.target.value === "true" ? true : false
    console.log(value, e.target.value)
    this.setState({saleParams: { sale_only: value }}, this._executeSearch)
  }


  _sanitizeSaleParams(params = {}){
    if(!params) return null
    if(!params.sale_only) return null
    return params
  }


  _executeSearch(){
    let params = {}
    _.assign(params,
      {sale: this._sanitizeSaleParams(this.state.saleParams)},
      {location: this._sanitizeLocationParams(this.state.locationParams)},
      {categories: this._sanitizeCategoryParams(this.state.categoryParams)},
      {commodities: this._sanitizeCommodityParams(this.state.commodityParams)},
      {sort: this.state.sort}
    )
    for(let prop in params){
      if(params[prop] === null || params[prop] === undefined){
        delete params[prop]
      }
    }
    console.info(params)

    // Update URL
    var url = new URI(window.location.href)
    var history = createHistory()

    url.search((data) =>{
      // Location
      if(params.location){
        data.location = params.location
      } else{
        delete data.location
      }

      // Sort
      if(params.sort){
        data.sort = params.sort
      }

      // Entrepreneur Categories
      if(params.categories){
        data.categories = params.categories.join()
      } else{
        delete data.categories
      }

      // Business Commodities
      if(params.commodities){
        data.commodities = params.commodities.join()
      } else{
        delete data.commodities
      }

      // Sale Info
      if(params.sale){
        data.for_sale = true
        data.min = params.sale.min
        data.max = params.sale.max
      } else{
        delete data.for_sale
        delete data.min
        delete data.max
      }

      // Set page back to 1
      data.page = 1
    })

    // Push state
    history.push({
      pathname: url.path(),
      search: url.search(),
      state: {
        event: "PARAMETERS_CHANGED",
        data: params
      }
    })

    this.props.executeSearch(params)
  }


  render() {

    let existing_commodity_params = _.cloneDeep(this.state.commodityParams)
    const commodity_form = (    
      <SearchCommodityForm commodityParams={existing_commodity_params} submit={this._submitCommodities.bind(this)} commodityList={this.props.commodityList} />
    )

    let existing_category_params = _.cloneDeep(this.state.categoryParams)
    const category_form = (
      <SearchCategoryForm categoryParams={existing_category_params} categoryList={this.props.categoryList} submit={this._submitCategories.bind(this)} />
    )

    let existing_location_params = _.clone(this.state.locationParams)
    const location_form = (
      <SearchLocationForm submit={this._submitLocation.bind(this)} locationParams={existing_location_params} />  
    )

    let existing_sale_params = _.cloneDeep(this.state.saleParams)
    const sale_modal = (
      <Modal show={this.state.showSaleModal} onHide={this._closeSaleModal.bind(this)}>
        <Modal.Header>
          <Modal.Title>Set Sale Information</Modal.Title>
        </Modal.Header>
        <Modal.Body id="sale-modal" className="clearfix">
          <SearchSaleForm saleParams={existing_sale_params} closeModal={this._closeSaleModal.bind(this)} />
        </Modal.Body>
      </Modal>
    )

    return(
      <div id="search-parameters" className="clearfix">

        <div className="container">
          <div className="row">
            <div className="col-md-5">
              {category_form}
            </div>
            <div className="col-md-5">
              {commodity_form}
            </div>
            <div className="col-md-2">
              {location_form}
            </div>
          </div>
          <div className="row">
            <div className="col-md-5 sort-by">
              <label>
                <input type="radio" name="sale_only" value="false" onChange={this._setSaleOnly.bind(this)} checked={!this.state.saleParams.sale_only} /> &nbsp;All Businesses
                <div className="check"></div>
              </label>
              <label>
                <input type="radio" name="sale_only" value="true" onChange={this._setSaleOnly.bind(this)} checked={this.state.saleParams.sale_only} /> &nbsp;Businesses for Sale
                <div className="check"></div>
              </label>
            </div>
            <div className="col-md-7 sort-by">
              <label>Sort By: </label>
              <label>
                <input type="radio" name="sort" value="most_reviews" onChange={this._setSort.bind(this)} checked={this.state.sort == "most_reviews"}/> &nbsp;Most Reviews
                <div className="check"></div>
              </label>
              <label>
                <input type="radio" name="sort" value="highest_rated" onChange={this._setSort.bind(this)} checked={this.state.sort == "highest_rated"}/> &nbsp;Highest Rated
                <div className="check"></div>
              </label>
              <label>
                <input type="radio" name="sort" value="best_match" onChange={this._setSort.bind(this)} checked={this.state.sort == "best_match"}/> &nbsp;Best Match
                <div className="check"></div>
              </label>
            </div>
          </div>
        </div>

        {/* <div className="col-md-5ths col-xs-6">
          <label>Location</label>
          <p>{this.state.locationParams ? this.state.locationParams.name : 'Any'}</p>
          <p>
            <a onClick={this._openLocationModal.bind(this)}>Change Location</a>
          </p>
        </div>

        <div className="col-md-5ths col-xs-6">
          <label>Entrepreneur Category</label>
          <p>{this.state.categoryParams.length ? this.state.categoryParams.join(", ") : "All"}</p>
          <p>
            <a onClick={this._openCategoryModal.bind(this)}>Change Categories</a>
          </p>
        </div>

        <div className="col-md-5ths col-xs-6">
          <label>Commodity of Business</label>
          <p>{this.state.commodityParams.length ? this.state.commodityParams.join(", ") : "All"}</p>
          <p>
            <a onClick={this._openCommodityModal.bind(this)}>Change Commodities</a>
          </p>
        </div>

        <div className="col-md-5ths col-xs-6">
          <label>Sale Information</label>
          <div>
            {this.state.saleParams ? Object.keys(this.state.saleParams).map((key, index) =>{
              if(key == 'sale_only'){
                if(this.state.saleParams[key]) return <p className="col-xs-6 no-pad" key={index}>Sale Only</p>
                else return '-'
              }
              return (
                <p className="col-xs-6 no-pad sale-row" key={index}>
                  {key.charAt(0).toUpperCase() + key.slice(1)}: {this.state.saleParams[key]}
                </p>
              )
            }) : <p>-</p>}
          </div>
          <p>
            <a onClick={this._openSaleModal.bind(this)}>Change</a>
          </p>
        </div>

        <div className="sort-by">
          <label>Sort By</label>
          <label>
            <input type="radio" name="sort" value="most_reviews" onChange={this._setSort.bind(this)} checked={this.state.sort == "most_reviews"}/> &nbspMost Reviews
          </label>
          <label>
            <input type="radio" name="sort" value="highest_rated" onChange={this._setSort.bind(this)} checked={this.state.sort == "highest_rated"}/> &nbspHighest Rated
          </label>
          <label>
            <input type="radio" name="sort" value="best_match" onChange={this._setSort.bind(this)} checked={this.state.sort == "best_match"}/> &nbspBest Match
          </label>
        </div> */}

        {sale_modal}
      </div>
    )
  }
}
