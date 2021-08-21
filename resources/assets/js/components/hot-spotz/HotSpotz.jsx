import React from 'react'
import {Button, ButtonGroup, Tab, Nav, NavItem, Col, Row} from 'react-bootstrap'
import _ from 'lodash'

import SearchResult from '../search/SearchResult.jsx';

export default class ActivityFeed extends React.Component {
  constructor(props){
    super(props)

    this.state = {
      results: [],
      selected_type: '',
      categories: _.sampleSize(props.categoryList, 5)
    }
  }


  componentDidMount(){
    this._fetchBusinesses()
  }


  _fetchBusinesses(categories = this.state.categories){
    let ids = categories.map((category) => {
      return category.id
    });
    $.ajax({
      method: 'GET',
      url: `/hot-spotz/${ids.join()}`,
    })
    .done((resp)=>{
      let results = {}
      this.state.categories.forEach((category) => {
        let result_count = 0
        results[category.name] = _.filter(resp, (result) => {
          let match = false
          result.e_categories.forEach((result_category) => {
            if(result_category.e_category_id == category.id) match = true;
          })

          // Limit 5 per category
          if(match) result_count++

          // If greater than 5 results already, return false
          if(result_count > 5) return false

          // Only return match if not 5 results
          return match
        });
      })
      this.setState({
        results
      })
    })
    .fail((resp)=>{
      console.log(resp)
      // alert('FAIL');
    });
  }


  render() {
    return (
      <div>
        <Tab.Container id="hot-spotz-tabs" defaultActiveKey={0}>
          <Row className="clearfix" style={{marginLeft: '0px'}}>
            <Col className="hot-tabs" sm={3}>
              <Nav stacked>
                {this.state.categories.map((category, i) => {
                  return (
                    <NavItem eventKey={i} key={category.id}>
                      {category.name}
                    </NavItem>
                  )
                })}
              </Nav>
            </Col>
            <Col className="no-pad-left" sm={9}>
              <Tab.Content className="sm-search-list clearfix" animation>
                {this.state.categories.map((category, i) => {
                  return (
                    <Tab.Pane eventKey={i} key={category.id}>
                      {this.state.results[category.name] ? this.state.results[category.name].map((business, index) => {
                          return <SearchResult key={index} index={index+1} business={business} />
                        })
                        :
                        <div className="loading-overlay">
                          <div className='uil-magnify-css' style={{transform: "scale(0.6)"}}>
                            <div className="group">
                              <div className="grip"></div>
                              <div className="inner-circle"></div>
                              <div className="outer-circle"></div>
                            </div>
                          </div>
                        </div>
                      }
                    </Tab.Pane>
                  )
                })}
              </Tab.Content>
            </Col>
          </Row>
        </Tab.Container>
      </div>
    );
  }
}
