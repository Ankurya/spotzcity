import React from 'react';
import {Button, ButtonToolbar} from 'react-bootstrap';
import _ from 'lodash';

export default class SearchCommodityForm extends React.Component {
  constructor(props){
    super(props);
    console.log(props);

    this.state = {
      sale_info: props.saleParams ? props.saleParams : {
        sale_only: 0
      }
    }
  }


  _close(e){
    e.preventDefault();
    this.props.closeModal(this.state.sale_info);
  }


  _saleOnlyChanged(e){
    this.setState({
      sale_info: {
        sale_only: parseInt(e.target.value)
      }
    });
  }


  _minMaxChanged(e){
    // Add check for max > min
    let obj = {};
    obj[e.target.name] = e.target.value ? parseInt(e.target.value) : '';
    let sale_info = _.assign(this.state.sale_info, obj);
    this.setState({
      sale_info: sale_info
    });
  }


  render() {
    return(
      <form onSubmit={this._close.bind(this)}>
        <div className="form-group clearfix">
          <label>Limit search to only businesses for sale?</label>
          <label>
            <input
              type="radio"
              value="1"
              onChange={this._saleOnlyChanged.bind(this)}
              checked={parseInt(this.state.sale_info.sale_only) == 1}
            /> Yes
          </label>
          <label>
            <input
              type="radio"
              value="0"
              onChange={this._saleOnlyChanged.bind(this)}
              checked={parseInt(this.state.sale_info.sale_only) == 0}
            /> No
          </label>
        </div>
        <div className="form-group clearfix">
          <div className="col-xs-6 no-pad-left">
            <label>Min Price</label>
            <input
              type="number"
              className="form-control"
              disabled={!parseInt(this.state.sale_info.sale_only)}
              name="min"
              value={this.state.sale_info.min}
              onChange={this._minMaxChanged.bind(this)}
            />
          </div>
          <div className="col-xs-6 no-pad-right">
            <label>Max Price</label>
            <input
              type="number"
              className="form-control"
              disabled={!parseInt(this.state.sale_info.sale_only)}
              name="max"
              value={this.state.sale_info.max}
              onChange={this._minMaxChanged.bind(this)}
            />
          </div>
        </div>
        <ButtonToolbar>
          <Button bsStyle="primary" type="submit">Done</Button>
          <Button onClick={this.props.closeModal}>Cancel</Button>
        </ButtonToolbar>
      </form>
    );
  }
}
