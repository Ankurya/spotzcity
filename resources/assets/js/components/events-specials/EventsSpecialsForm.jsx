import React from 'react';
import {Button, ButtonToolbar} from 'react-bootstrap';
import Datetime from 'react-datetime';

export default class EventsSpecialsForm extends React.Component {
  constructor(props){
    super();
  }

  componentWillMount(){
    if(this.props.item){
      this.state = _.assign({}, this.props.item, {
        start: moment(this.props.item.start).local(),
        end: moment(this.props.item.end).local()
      });
    } else {
      this.state = {
        name: "",
        description: "",
        start: moment().local().add(1, "hour").minute(0),
        end: moment().local().add(2, "hour").minute(0),
        type: "event"
      }
    }
    console.log(this.state);
  }

  _onChange(e){
    let name = e.target.name;
    let value = e.target.value;
    let obj = {}
    obj[name] = value;
    this.setState(obj);
  }

  _startChange(val){
    this.setState({
      start: val
    });
  }

  _endChange(val){
    this.setState({
      end: val
    });
  }

  _onSubmit(e){
    e.preventDefault();
    if(this.props.item){
      this.props.editExisting(this.state);
    } else{
      this.props.createNew(this.state);
    }
  }

  render() {
    return(
      <form id="events-specials-form" onSubmit={this._onSubmit.bind(this)}>
        <div className="col-xs-12 no-pad">
          <div className="form-group">
            <label>Type</label>
            <br/>
            <label style={{marginRight: '15px'}}>
              <input type="radio" name="type" onChange={this._onChange.bind(this)} value="event" checked={this.state.type == 'event'}/> Event
            </label>
            <label>
              <input type="radio" name="type" onChange={this._onChange.bind(this)} value="special" checked={this.state.type == 'special'}/> Special
            </label>
          </div>
        </div>

        <div className="col-xs-6 no-pad-left">
          <div className="form-group">
            <label>Name</label>
            <input type="text" name="name" onChange={this._onChange.bind(this)} className="form-control" value={this.state.name} placeholder="Ex. Open House" required/>
          </div>
        </div>

        <div className="col-xs-6 no-pad-right">
          <div className="form-group">
            <label>Start</label>
            <Datetime inputProps={{name: "start", required: true}} timeConstraints={{minutes: { step: 15 }}} onChange={this._startChange.bind(this)} value={this.state.start}/>
          </div>
        </div>

        <div className="col-xs-6 no-pad-left">
          <div className="form-group">
            <label>Description</label>
            <textarea name="description" rows="4" onChange={this._onChange.bind(this)} className="form-control" value={this.state.description} placeholder="Description" required/>
          </div>
        </div>

        <div className="col-xs-6 no-pad-right">
          <div className="form-group">
            <label>End</label>
            <Datetime inputProps={{name: "end", required: true}} timeConstraints={{minutes: { step: 15 }}} onChange={this._endChange.bind(this)} value={this.state.end}/>
          </div>
        </div>

        <div className="col-xs-12 no-pad">
          <ButtonToolbar>
            <Button bsStyle="primary" type="submit">Save</Button>
            <Button onClick={this.props.closeModal}>Cancel</Button>
          </ButtonToolbar>
        </div>
      </form>
    )
  }
}
