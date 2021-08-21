import React from 'react'
import {Modal, Button} from 'react-bootstrap'
import URI from 'urijs'
import createHistory from 'history/createBrowserHistory'

import AdminSearchForm from './AdminSearchForm.jsx'
import AdminSearchResults from './AdminSearchResults.jsx'
import AdminSearchPages from './AdminSearchPages.jsx'


export default class AdminSearch extends React.Component {
  constructor(props){
    super(props);

    this.state = {
      results: [],
      pagination: {},
      loading: false,
      showModal: false,
      modalResult: {}
    }
  }


  componentDidMount(){
    // Load initial resource listings
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
    })
  }


  _getSearchData(){
    // Pull in URL info here
    let url = new URI(window.location.href)
    let urlData = url.search(true)
    let history = createHistory()
    let params = {}

    // Build search params from URL data
    let page = urlData.page || 1

    // Type
    if(urlData.type){
      params.type = urlData.type
    } else{
      params.type = "users"
    }

    // Keywords
    if(urlData.keywords){
      params.keywords = urlData.keywords.split(',')
    }

    return {params: params, page: page}
  }


  _executeSearch(params, page = null){
    var self = this

    var url = new URI(window.location.href)
    var history = createHistory()

    this.setState({
      loading: true
    })

    $(window).scrollTop(0)
    $.ajax({
      method: 'POST',
      url: `/admin/search/${params.type}${page ? '?page='+page : ''}`,
      data: JSON.stringify(params),
      dataType: 'json',
      contentType: 'application/json'
    })
    .done((resp) => {
      console.info(resp.data)
      self.setState({
        results: resp.data,
        pagination: {
          total_results: resp.total,
          per_page: resp.per_page,
          current_page: resp.current_page,
          last_page: resp.last_page
        },
        modalResult: {},
        loading: false
      })
    })
    .fail((resp)=>{
      console.log(resp)
    });
  }


  _pageChanged(page_selected){
    let {params} = this._getSearchData()
    this._executeSearch(params, page_selected)
  }


  _openModal(){
    this.setState({
      showModal: true
    })
  }


  _closeModal(result = {}){
    console.log(result)
    this.setState({
      showModal: false,
      modalResult: result
    })
  }

  render() {
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
      <div className="row">
        <div className="col-xs-12 notification" style={{display: this.state.modalResult.status ? 'block' : 'none'}}>
          <div className={`alert alert-${this.state.modalResult.status}`}>
            {this.state.modalResult.msg}
          </div>
        </div>
        <AdminSearchForm
          loading={this.state.loading}
          categoryList={this.props.categoryList}
          executeSearch={this._executeSearch.bind(this)}
        />
        <AdminSearchResults
          results={this.state.results}
          pagination={this.state.pagination}
          categoryList={this.props.categoryList}
          loading={this.state.loading}
        />
        <AdminSearchPages
          loading={this.state.loading}
          currentPage={this.state.pagination.current_page}
          totalResults={this.state.pagination.total_results}
          perPage={this.state.pagination.per_page}
          lastPage={this.state.pagination.last_page}
          pageChanged={this._pageChanged.bind(this)}
        />
        {loader}
      </div>
    );
  }
}
