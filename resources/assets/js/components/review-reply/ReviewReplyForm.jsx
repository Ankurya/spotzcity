import React from 'react';
import {Button, ButtonToolbar} from 'react-bootstrap';

export default class ReviewReplyForm extends React.Component {
  constructor(props){
    super(props);
    this.state = {
      body: ""
    }
  }

  _updateResponse(e){
    let response = e.target.value;
    this.setState({
      body: e.target.value
    });
  }

  _submitResponse(e){
    e.preventDefault();
    this.props.submitResponse(this.state);
  }

  render() {
    return (
      <div>
        <form onSubmit={this._submitResponse.bind(this)}>
          <textarea className="form-control" rows="3" onChange={this._updateResponse.bind(this)} value={this.state.body} />
          <ButtonToolbar>
            <Button bsStyle="primary" type="submit">Save</Button>
            <Button onClick={this.props.cancelResponse}>Cancel</Button>
          </ButtonToolbar>
        </form>
      </div>
    );
  }
}
