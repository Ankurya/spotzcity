import React from 'react'
import {Button} from 'react-bootstrap'
import _ from 'lodash'
import Select from 'react-select'
// import 'react-select/dist/react-select.css'

export default class SearchCategoryForm extends React.Component {
  constructor(props){
    super(props);
    
    this.state = {
      categories: props.categoryParams
    }
  }


  _onChange(selected){
    let categories = selected.map(selection => {
      return selection.value
    })
    this.setState({categories})
    this.props.submit(categories)
  }


  render() {
    return(
      <form>
        <div className="form-group clearfix">
          <Select
            name="category"
            onChange={this._onChange.bind(this)}
            value={this.state.categories}
            placeholder="Entrepreneur Category"
            required
            multi
            options={this.props.categoryList.map((category) => {
              return {value: category.id, label: category.name}
            })}
          >
          </Select>
        </div>
      </form>
    )
  }
}
