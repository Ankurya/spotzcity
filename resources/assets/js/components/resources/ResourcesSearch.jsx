import React from 'react';
import {Modal} from 'react-bootstrap';
import {Button} from 'react-bootstrap';
import Select from 'react-select';

import URI from 'urijs';
import createHistory from 'history/createBrowserHistory';


export default class ResourcesSearch extends React.Component {
  constructor(props){
    super(props)
    // Available resource categories
    let category_list = []
    props.categoryList.forEach((category) => {
      category_list.push({
        label: category.name,
        value: category.id
      })
    })

    // Extract state from url
    var url = new URI(window.location.href)
    var history = createHistory()
    let urlData = url.search(true)
    let params = {}
    let page = urlData.page || 1

    // Categories
    if(urlData.categories){
      let category_ids = urlData.categories.split(',')

      // Map category params for display via the category list
      params.categories = []
      category_ids.forEach((id) =>{
        params.categories.push( ((result = _.find(props.categoryList, (category) => { return id == category.id } ) ) =>
          {
            return {
              value: result.id,
              label: result.name
            }
          }
        )() )
      })
    }

    // Keywords
    if(urlData.keywords){
      // Convert commas to spaces
      let keywords = urlData.keywords.replace(',', ' ')
      params.keywords = keywords
    }

    this.state = {
      keywords: params.keywords || "",
      categories: params.categories,
      category_list: category_list
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


  _selectChange(value){
    this.setState({
      categories: value
    }, this._executeSearch)
  }


  _sanitizeCategoryParams(categories = this.state.categories){
    if(categories){
      return categories.map((category) => {
        return `${category.value}`
      })
    } else{
      return null
    }
  }


  _sanitizeKeywordParams(keywords = this.state.keywords){
    if(keywords){
      let parsed_keywords = keywords.split(" ")
      console.log(parsed_keywords)
      return parsed_keywords
    } else{
      return null
    }
  }


  _executeSearch(){
    let params = {}
    _.assign(params,
      {categories: this._sanitizeCategoryParams()},
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
      // Categories
      if(params.categories){
        if(!params.categories.length){
          delete params.categories
          delete data.categories
        } else{
          data.categories = params.categories.join()
        }
      } else{
        delete data.categories
      }

      // Keywords
      if(params.keywords){
        console.log(params.keywords)
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
          <label>Categories</label>
          <Select
            name="categories"
            placeholder="Select Categories"
            value={this.state.categories}
            options={this.state.category_list}
            onChange={this._selectChange.bind(this)}
            multi
            joinValues
            disabled={this.props.loading}
          />
        </div>
        <div className="col-md-5 col-xs-12">
          <label>Keyword Search</label>
          <input
            type="text"
            name="keywords"
            className="form-control"
            placeholder="Ex. Meat Packing Chicago"
            value={this.state.keywords}
            onChange={this._onChange.bind(this)}
            disabled={this.props.loading}
          />
        </div>
      </div>
    );
  }
}
