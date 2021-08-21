import React from 'react'
import {Modal, Button, ButtonToolbar} from 'react-bootstrap'
import states from '../../misc/states_hash'
import ResourceValidator from '../forms/validators/resource-validator.jsx'


export default class ResourcesForm extends React.Component {
  constructor(props){
    super(props);

    this.state = {
      resource_name: "",
      category: 1,
      type: "N/A",
      city: "",
      state: "Alabama",
      website: "",
      phone: ""
    }
  }


  _onChange(e){
    const {name, value} = e.target
    this.setState({
      [name]: value
    })
  }


  _onSubmit(e){
    let passes = ResourceValidator(e)
    console.log(passes)
    if(passes){
      // Submit resource
      $.ajax({
        type: 'POST',
        url: '/resources',
        data: this.state,
        success: ((resp) => {
          this.props.closeModal({
            status: 'success',
            msg: 'Resource submitted. Admins will be reviewing it shortly.'
          })
        }),
        error: ((resp) => {
          console.log(resp)
          this.props.closeModal({
            status: 'error',
            msg: 'Error submitting resource.'
          })
        })
      })
    }
  }


  render() {
    return(
      <form name="resources-form" onSubmit={this._onSubmit.bind(this)}>
        <div className="row">
          <div className="form-group clearfix">
            <div className="col-md-6 col-xs-12">
              <label htmlFor="resource_name">Name*</label>
              <input
                className="form-control"
                name="resource_name"
                onChange={this._onChange.bind(this)}
                value={this.state.resource_name}
                required
              />
            </div>
            <div className="col-md-6 col-xs-12">
              <label htmlFor="category">Category*</label>
              <select
                className="form-control"
                name="category"
                onChange={this._onChange.bind(this)}
                value={this.state.category}
                required
              >
                {this.props.categoryList.map((category) => {
                  return <option key={category.id} value={category.id}>{category.name}</option>
                })}
              </select>
            </div>
            <div className="col-md-6 col-xs-12">
              <label htmlFor="type">Type (if applicable)</label>
              <input
                className="form-control"
                name="type"
                onChange={this._onChange.bind(this)}
                value={this.state.type}
              />
            </div>
          </div>
          <div className="form-group clearfix">
            <div className="col-md-6 col-xs-12">
              <label htmlFor="city">City*</label>
              <input
                className="form-control"
                name="city"
                onChange={this._onChange.bind(this)}
                value={this.state.city}
                required
              />
            </div>
            <div className="col-md-6 col-xs-12">
              <label htmlFor="state">State*</label>
              <select
                className="form-control"
                name="state"
                onChange={this._onChange.bind(this)}
                value={this.state.state}
                required
              >
                {states.map((state) => {
                  return <option key={state.abbreviation} value={state.name}>{state.name}</option>
                })}
              </select>
            </div>
            <div className="col-md-6 col-xs-12">
              <label htmlFor="phone">Phone</label>
              <input
                className="form-control"
                name="phone"
                onChange={this._onChange.bind(this)}
                value={this.state.phone}
              />
            </div>
            <div className="col-md-6 col-xs-12">
              <label htmlFor="website">Website</label>
              <input
                className="form-control"
                name="website"
                onChange={this._onChange.bind(this)}
                value={this.state.website}
              />
            </div>
          </div>
        </div>
        <hr/>
        <div className="row">
          <div className="col-xs-12">
            <ButtonToolbar>
              <Button bsStyle="primary" type="submit">Submit</Button>
              <Button onClick={this.props.closeModal}>Cancel</Button>
              <span style={{marginLeft: '10px'}}>* Admins will have to approve the submission</span>
            </ButtonToolbar>
          </div>
        </div>
      </form>
    );
  }
}
