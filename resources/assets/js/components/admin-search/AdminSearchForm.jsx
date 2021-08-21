import React from 'react';
import {Modal} from 'react-bootstrap';
import {Button} from 'react-bootstrap';
import Select from 'react-select';

import URI from 'urijs';
import createHistory from 'history/createBrowserHistory';


export default class AdminSearchForm extends React.Component {
  constructor(props){
    super(props)

    // Extract state from url
    var url = new URI(window.location.href)
    var history = createHistory()
    let urlData = url.search(true)
    let params = {}
    let page = urlData.page || 1


    // Type
    if(urlData.type){
      params.type = urlData.type
    }

    // Keywords
    if(urlData.keywords){
      // Convert commas to spaces
      let keywords = urlData.keywords.replace(',', ' ')
      params.keywords = keywords
    }

    this.state = {
      keywords: params.keywords || "",
      type: params.type || "users"
    }
  }


  _onChange(e){
    let diff = {}
    diff[e.target.name] = e.target.value

    // Rate limit callback via timeouts
    this.setState(diff, (() => {
      if(window.searchTimer){
        clearTimeout(window.searchTimer)
      }
      window.searchTimer = setTimeout(() => {
        this._executeSearch()
      }, 500)
    }))
  }


  _sanitizeKeywordParams(keywords = this.state.keywords){
    if(keywords){
      let parsed_keywords = keywords.split(" ")
      return parsed_keywords
    } else{
      return null
    }
  }


  _executeSearch(){
    let params = {}
    _.assign(params,
      {type: this.state.type},
      {keywords: this._sanitizeKeywordParams()}
    )
    for(let prop in params){
      if(params[prop] === null || params[prop] === undefined){
        delete params[prop]
      }
    }

    // Update URL
    var url = new URI(window.location.href)
    var history = createHistory()

    url.search((data) =>{
      // Type
      if(params.type){
        data.type = params.type
      } else{
        delete data.type
      }

      // Keywords
      if(params.keywords){
        data.keywords = params.keywords.join()
      } else{
        delete data.keywords
      }

      // Set page back to 1
      data.page = 1
    })

    // Push state
    console.log('url becomes: '+ url.search())
    history.push({
      pathname: url.path(),
      search: url.search(),
      state: {
        event: "PARAMETERS_CHANGED",
        data: params
      }
    });

    this.props.executeSearch(params)
  }


  render() {
    return(
      <div className="col-xs-12" id="search-parameters" style={{opacity: this.props.loading ? '0.8' : '1'}}>
        <div className="col-md-7 col-xs-12">
          <label>Search</label>
          <input
            type="text"
            name="keywords"
            className="form-control"
            placeholder="Search by Name"
            value={this.state.keywords}
            onChange={this._onChange.bind(this)}
            disabled={this.props.loading}
          />
        </div>
        <div className="col-md-4 col-xs-12">
          <label>Type</label>
          <label htmlFor="type">
            <input
              name="type"
              type="radio"
              checked={this.state.type === 'users'}
              value="users"
              onChange={this._onChange.bind(this)}
            /> User
          </label>
          <label>
            <input
              name="type"
              type="radio"
              checked={this.state.type === 'businesses'}
              value="businesses"
              onChange={this._onChange.bind(this)}
            /> Business
          </label>
        </div>
      </div>
    );
  }
}
