import React from 'react';
import {Modal} from 'react-bootstrap';
import {Button} from 'react-bootstrap';

import EventsSpecialsForm from './EventsSpecialsForm.jsx';
import EventsSpecialsItem from './EventsSpecialsItem.jsx';

export default class EventsSpecialsContainer extends React.Component {
  constructor(props){
    super();

    this.state = {
      events: null,
      showModal: false
    }
  }

  componentWillMount(){
    $.ajax({
      method: 'GET',
      url: `business/${this.props.businessid}/events-and-specials`,
    })
    .done((resp)=>{
      this.setState({events: resp});
    })
    .fail((resp)=>{
      console.log(resp);
      // alert('FAIL');
    });
  }

  _newModal(){
    this.setState({
      edit: null,
      showModal: true
    });
  }

  _editModal(event){
    console.log(event);
    this.setState({
      edit: event,
      showModal: true
    });
  }

  _closeModal(){
    this.setState({showModal: false});
  }

  _createEventSpecial(data){
    if(!data.name || !data.description || !data.start || !data.end){
      alert('Please fill out all fields.');
      return;
    }

    data.start = data.start.format('YYYY-MM-DD HH:mm:ss')
    data.end = data.end.format('YYYY-MM-DD HH:mm:ss')

    $.ajax({
      method: 'POST',
      url: `business/${this.props.businessid}/events-and-specials`,
      data: data
    })
    .done((resp)=>{
      console.log(resp);
      this.setState({events: resp});
      this._closeModal()
    })
    .fail((resp)=>{
      console.log(resp);
      // alert('FAIL');
    });
  }

  _editEventSpecial(data){
    if(!data.name || !data.description || !data.start || !data.end){
      alert('Please fill out all fields.');
      return;
    }

    data.start = data.start.format('YYYY-MM-DD HH:mm:ss')
    data.end = data.end.format('YYYY-MM-DD HH:mm:ss')

    this.setState({
      events: null
    });

    $.ajax({
      method: 'PATCH',
      url: `business/${this.props.businessid}/events-and-specials/${data.id}`,
      data: data
    })
    .done((resp)=>{
      console.log(resp);
      this.setState({
        edit: null,
        events: resp
      });
      this._closeModal();
    })
    .fail((resp)=>{
      console.log(resp);
      // alert('FAIL');
    });
  }

  _deleteEventSpecial(id){
    let c = confirm('Are you sure you want to delete this event/special?');
    if(c){
      $.ajax({
        method: 'DELETE',
        url: `business/${this.props.businessid}/events-and-specials/${id}`
      })
      .done((resp)=>{
        console.log(resp);
        this.setState({
          edit: null,
          events: resp
        });
        this._closeModal();
      })
      .fail((resp)=>{
        console.log(resp);
        // alert('FAIL');
      });
    }
  }

  render() {
    const modal = (
      <Modal show={this.state.showModal} onHide={this._closeModal.bind(this)}>
        <Modal.Header closeButton>
          <Modal.Title>Add Event or Special</Modal.Title>
        </Modal.Header>
        <Modal.Body className="clearfix">
          <EventsSpecialsForm createNew={this._createEventSpecial.bind(this)} editExisting={this._editEventSpecial.bind(this)} closeModal={this._closeModal.bind(this)} item={this.state.edit} />
        </Modal.Body>
      </Modal>
    )

    if(!this.state.events){
      return(
        <h4>
          Loading...
        </h4>
      );
    } else if(!this.state.events.length){
      return(
        <div>
          <h4>
            No events or specials created yet. <a onClick={this._newModal.bind(this)}>Create one!</a>
          </h4>
          {modal}
        </div>
      );
    } else{
      return(
        <div>
          {this.state.events.map(event => {
            return(
              <EventsSpecialsItem key={event.id} item={event} editAction={this._editModal.bind(this)} deleteAction={this._deleteEventSpecial.bind(this)} />
            );
          })}
          <h4>
            <a onClick={this._newModal.bind(this)}><i className="icon-plus"></i> Add New</a>
          </h4>
          {modal}
        </div>
      )
    }
  }
}
