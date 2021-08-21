import React from 'react'
import {Button, ButtonToolbar} from 'react-bootstrap'
import _ from 'lodash'
import Select from 'react-select'

export default class SearchCommodityForm extends React.Component {
  constructor(props){
    super(props)

    this.state = {
      commodities: props.commodityParams
    }
  }


  _onChange(selected){
    let commodities = selected.map(selection => {
      return selection.value
    })
    this.setState({commodities})
    this.props.submit(commodities)
  }


  render() {
    return(
      <form>
        <div className="form-group clearfix">
          <Select
            name="commodities"
            onChange={this._onChange.bind(this)}
            value={this.state.commodities}
            placeholder="Business Type"
            required
            multi
            options={this.props.commodityList.map((commodity) => {
              return {value: commodity.id, label: commodity.name}
            })}
          >
          </Select>
        </div>
      </form>
    )
  }
}
