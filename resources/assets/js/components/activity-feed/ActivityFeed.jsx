import React from 'react';
import {Modal} from 'react-bootstrap';
import {Button, ButtonGroup} from 'react-bootstrap';


export default class ActivityFeed extends React.Component {
  constructor(props){
    super();

    this.state = {
      events: [],
      activity_type: 'near-me',
      page: 1,
      last_page: false
    }
  }

  componentDidMount(){
    this._fetchActivity();
  }

  _getMoreActivity(){
    this._fetchActivity();
  }

  _fetchActivity(type = this.state.activity_type){
    $.ajax({
      method: 'GET',
      url: `/activity/${type}/${this.state.page}`,
    })
    .done((resp)=>{
      console.log(resp);
      let page = this.state.page + 1;
      let events = this.state.events.concat(resp.data);
      this.setState({
        events: events,
        page: page,
        last_page: !resp.data.length
      });
    })
    .fail((resp)=>{
      console.log(resp);
      // alert('FAIL');
    });
  }

  _toggleType(e){
    this.setState({
      activity_type: e.target.id,
      events: [],
      page: 1
    }, this._fetchActivity);
  }

  render() {
    const buttons = this.props.loggedIn ?
      <ButtonGroup>
        <Button id="near-me" bsSize="small" onClick={this._toggleType.bind(this)} className={this.state.activity_type == 'near-me' ? 'active' : ''}>Near me</Button>
        <Button id="following" bsSize="small" onClick={this._toggleType.bind(this)} className={this.state.activity_type == 'following' ? 'active' : ''}>Following</Button>
      </ButtonGroup>
      :
      null;

    return (
      <div>
        {buttons}
        {this.state.events.map((val, key) => {
            switch(val.type){
              case 'business.created':
                return (
                  <div className="activity clearfix" key={key}>
                    <div className="activity-description col-xs-8 no-pad-left">
                      <div className="business-pic col-xs-2 pull-left no-pad" style={{maxWidth: '58px', minHeight: '50px'}}>
                        <img className="img-responsive" src={val.business.logo ? `/storage/${val.business.logo}` : 'assets/images/placeholder.png'} />
                      </div>
                      <div className="activity-desc col-xs-10 no-pad-right">
                        <p>
                          <a href={`/business/${val.business.slug}`}>{val.business.name}</a> is now on Spotzcity!
                        </p>
                      </div>
                    </div>
                    <div className="activity-time col-xs-4 no-pad-right text-right">
                      <p>
                        {moment(val.created_at).local().fromNow()}
                      </p>
                    </div>
                  </div>
                );

              case 'event.created':
                return (
                  <div className="activity clearfix" key={key}>
                    <div className="activity-description col-xs-8 no-pad-left">
                      <div className="business-pic col-xs-2 pull-left no-pad" style={{maxWidth: '58px', minHeight: '50px'}}>
                        <img className="img-responsive" src={val.business.logo ? `/storage/${val.business.logo}` : 'assets/images/placeholder.png'} />
                      </div>
                      <div className="activity-desc col-xs-10 no-pad-right">
                        <p>
                          <a href={`/business/${val.business.slug}`}>{val.business.name}</a> created the event  {val.business_event.name}.
                        </p>
                      </div>
                    </div>
                    <div className="activity-time col-xs-4 no-pad-right text-right">
                      <p>
                        {moment(val.created_at).local().fromNow()}
                      </p>
                    </div>
                  </div>
                );

              case 'review.created':
                return (
                  <div className="activity clearfix" key={key}>
                    <div className="activity-description col-xs-8 no-pad-left">
                      <div className="business-pic col-xs-2 pull-left no-pad" style={{maxWidth: '58px', minHeight: '50px'}}>
                        <img className="img-responsive" src={val.user.picture ? `/storage/${val.user.picture}` : '/assets/images/placeholder.png'} />
                      </div>
                      <div className="activity-desc col-xs-10 no-pad-right">
                        <p>
                          <a href={`/user/${val.user.id}`}>{`${val.user.first_name} ${val.user.last_name}`}</a> reviewed <a href={`/business/${val.business.slug}`}>{val.business.name}</a>
                           &nbsp;and rated them {val.review.rating} Spotz.
                        </p>
                      </div>
                    </div>
                    <div className="activity-time col-xs-4 no-pad-right text-right">
                      <p>
                        {moment(val.created_at).local().fromNow()}
                      </p>
                    </div>
                  </div>
                );

              case 'review_response.created':
                return (
                  <div className="activity clearfix" key={key}>
                    <div className="activity-description col-xs-8 no-pad-left">
                      <div className="business-pic col-xs-2 pull-left no-pad" style={{maxWidth: '58px', minHeight: '50px'}}>
                        <img className="img-responsive" src={val.business.logo ? `/storage/${val.business.logo}` : 'assets/images/placeholder.png'} />
                      </div>
                      <div className="activity-desc col-xs-10 no-pad-right">
                        <p>
                          <a href={`/business/${val.business.slug}`}>{val.business.name}</a> responded to <a href={`/user/${val.user.id}`}>{`${val.user.first_name} ${val.user.last_name}'s`}</a> review.
                        </p>
                      </div>
                    </div>
                    <div className="activity-time col-xs-4 no-pad-right text-right">
                      <p>
                        {moment(val.created_at).local().fromNow()}
                      </p>
                    </div>
                  </div>
                );
                break;
            }
          })
        }
        <p className="text-center" style={{marginTop: '20px'}}>
          {this.state.last_page ? 'End of Feed' : <a onClick={this._getMoreActivity.bind(this)}>Load More</a>}
        </p>
      </div>
    );
  }
}
