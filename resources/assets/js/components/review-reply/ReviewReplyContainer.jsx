import React from 'react';
import {Button} from 'react-bootstrap';

import ReviewReplyForm from './ReviewReplyForm.jsx';

export default class ReviewReplyContainer extends React.Component {
  constructor(props){
    super(props);

    this.state = {
      review_id: props.reviewId,
      response_body: props.responseBody ? props.responseBody : null,
      created_at: moment(props.createdAt).local().fromNow(),
      updated_at: moment(props.updatedAt).local().fromNow(),
      updated: moment(props.updatedAt).isAfter(props.createdAt),
      compose: false
    }
  }

  _composeResponse(){
    this.setState({
      compose: true
    });
  }

  _cancelResponse(){
    this.setState({
      compose: false
    });
  }

  _createResponse(data, id = this.state.review_id){
    if(!data.body){
      alert('Please fill out response.');
      return;
    }

    $.ajax({
      method: 'POST',
      url: `/review-reply/${id}`,
      data: data
    })
    .done((resp)=>{
      console.log(resp);
      this.setState({
        response_body: resp.data.body,
        created_at: moment.utc(resp.data.created_at).local().fromNow(),
        updated_at: moment.utc(resp.data.updated_at).local().fromNow(),
        updated: moment(resp.data.updated_at).isAfter(resp.data.created_at),
        compose: false
      });
    })
    .fail((resp)=>{
      console.log(resp);
      alert('Response could not be saved.');
    });
  }

  _editResponse(data, id = this.state.review_id){
    if(!data.body){
      alert('Please fill out response.');
      return;
    }

    $.ajax({
      method: 'PATCH',
      url: `/review-reply/${id}`,
      data: data
    })
    .done((resp)=>{
      console.log(resp);
      this.setState({
        response_body: resp.data.body,
        created_at: moment.utc(resp.data.created_at).local().fromNow(),
        updated_at: moment.utc(resp.data.updated_at).local().fromNow(),
        updated: moment(resp.data.updated_at).isAfter(resp.data.created_at),
        compose: false
      });
    })
    .fail((resp)=>{
      console.log(resp);
      alert('Response could not be saved.');
    });
  }

  _deleteResponse(a, b, id = this.state.review_id){
    console.log(id);
    $.ajax({
      method: 'DELETE',
      url: `/review-reply/${id}`
    })
    .done((resp)=>{
      console.log(resp);
      this.setState({
        response_body: null,
        created_at: null,
        updated_at: null,
        updated: false,
        compose: false
      });
    });
  }

  render() {
    const review = this.state.response_body ?
      <p className="review-response">
        <strong>{this.props.businessName}'s response:</strong>
        <br/>
        {this.state.response_body}
        <br/>
        <br/>
        <small>{this.state.updated ? `Updated: ${this.state.updated_at}` : `Posted: ${this.state.created_at}`}</small>
      </p>
      :
      null;

    return (
      <div>
        {review}
        <a onClick={this._composeResponse.bind(this)}>{this.state.response_body ? 'Edit response' : 'Respond to review'}</a>
        {this.state.response_body ?
          <font>
            &nbsp;&nbsp;|&nbsp;&nbsp;
            <a onClick={this._deleteResponse.bind(this)}>Delete response</a>
          </font>
          :
          null
        }
        {this.state.compose ?
          <ReviewReplyForm
            submitResponse={this.state.response_body ? this._editResponse.bind(this) : this._createResponse.bind(this)}
            cancelResponse={this._cancelResponse.bind(this)}
          />
          :
          null
        }
      </div>
    );
  }
}
