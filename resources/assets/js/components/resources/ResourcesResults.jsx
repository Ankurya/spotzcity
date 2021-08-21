import React from 'react';
import {Modal} from 'react-bootstrap';
import {Button} from 'react-bootstrap';
import {Table} from 'react-bootstrap';


export default class ResourcesResults extends React.Component {
  constructor(props){
    super(props)

    this.state = {
      results: props.results || [],
      pagination: props.pagination || {},
      loading: false
    }
  }


  componentWillReceiveProps(props){
    this.setState({
      results: props.results,
      pagination: props.pagination
    })
  }


  render() {
    return(
      <div className="col-xs-12 form-row no-pad resource-results table-responsive" style={{opacity: this.props.loading ? '0.8' : '1'}}>
        <h4 className="text-center" style={{display: this.props.show ? 'none' : 'block'}}>Use this tool to identify and locate resources for your small business!</h4>
        <table className="table table-striped" style={{display: this.props.show ? 'table' : 'none'}}>
          <thead>
            <tr>
              <th>Company Name</th>
              <th>Category</th>
              <th>Type</th>
              <th>City</th>
              <th>State</th>
              <th>Phone</th>
            </tr>
          </thead>
          <tbody>
            {this.state.results.map((resource) => {
              // Detect is protocol is present on website field, prepend if needed
              if(resource.website.indexOf('http') === -1){
                resource.website = `http://${resource.website}`
              }
              return (
                <tr key={resource.id}>
                  <td>
                    {resource.website ?
                      <a href={resource.website} target="_blank">{resource.name}</a>
                      :
                      resource.name
                    }
                  </td>
                  <td>
                    {
                      _.find(this.props.categoryList, (category) => {
                        return category.id == resource.categories[0].resource_category_id
                      }).name
                    }
                  </td>
                  <td>{resource.type || 'N/A'}</td>
                  <td>{resource.city || 'N/A'}</td>
                  <td>{resource.state || 'N/A'}</td>
                  <td>{resource.phone || 'N/A'}</td>
                </tr>
              )
            })}
          </tbody>
        </table>
      </div>
    );
  }
}
