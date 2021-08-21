import React from 'react';
import {Pagination} from 'react-bootstrap';
import URI from 'urijs';
import createHistory from 'history/createBrowserHistory';

export default class AdminSearchPages extends React.Component {
  constructor(props){
    super(props)
    console.log(props)
    this.state = {
      current_page: props.currentPage
    };
  }

  componentWillReceiveProps(nextProps){
    this.setState({
      current_page: nextProps.currentPage,
      total_results: nextProps.totalResults,
      per_page: nextProps.perPage,
      last_page: nextProps.lastPage
    });
  }

  _pageSelected(eventKey){

    // Update URL
    var url = new URI(window.location.href);
    var history = createHistory();

    url.search((data) =>{
      data.page = eventKey;
    });

    // Push state
    history.push({
      pathname: url.path(),
      search: url.search(),
      state: {
        event: "PAGE_CHANGED"
      }
    })

    this.props.pageChanged(eventKey)
  }

  render() {
    return(
      <div style={{opacity: this.props.loading ? '0.8' : '1'}}>
        <Pagination
          activePage={this.state.current_page}
          items={this.state.last_page}
          next={this.state.total_results > this.state.per_page}
          prev={this.state.current_page > 1}
          boundaryLinks={true}
          maxButtons={10}
          onSelect={this._pageSelected.bind(this)}
        />
      </div>
    );
  }
}
