import React from 'react';
import {Button, ButtonToolbar} from 'react-bootstrap';

export default class EventsSpecialsItem extends React.Component {
  constructor(props){
    super();
  }

  componentWillMount(){
    this.setState(this.props.item);
  }

  _openEdit(){
    this.props.editAction(this.state);
  }

  _deleteItem(){
    this.props.deleteAction(this.state.id);
  }

  render() {
    let formatted_start_time = moment(this.state.start).local().format('h:mm A');
    let formatted_start_date = moment(this.state.start).local().format('MM/DD/YY');

    let formatted_end_time = moment(this.state.end).local().format('h:mm A');
    let formatted_end_date = moment(this.state.end).local().format('MM/DD/YY');
    return(
      <div className="events-specials-item clearfix">
        <div className="icon"><i className={this.state.type == 'event' ? 'icon-calendar' : 'icon-fire'}></i></div>
        <div className="info-box">
          <h4>{this.state.name} <small>({this.state.type})</small></h4>
          <p>Starts: {formatted_start_time} on {formatted_start_date}</p>
          <p>Ends: {formatted_end_time} on {formatted_end_date}</p>
        </div>
        <div className="pull-right">
          <ButtonToolbar>
            <Button bsStyle="primary" bsSize="sm" onClick={this._openEdit.bind(this)}>Edit</Button>
            <Button bsStyle="danger" bsSize="sm" onClick={this._deleteItem.bind(this)}>Delete</Button>
          </ButtonToolbar>
        </div>
      </div>
    );
  }
}
