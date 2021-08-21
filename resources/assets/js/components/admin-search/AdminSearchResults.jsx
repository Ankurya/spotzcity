import React from 'react';
import {Modal} from 'react-bootstrap';
import {Button} from 'react-bootstrap';
import {Table} from 'react-bootstrap';


export default class AdminSearchResults extends React.Component {
  constructor(props){
    super(props)

    this.state = {
      results: props.results || [],
      pagination: props.pagination || {},
      loading: false,
    }
  }


  componentDidMount(){
    // Load initial resource listings
  }


  componentWillReceiveProps(props){
    this.setState({
      results: props.results,
      pagination: props.pagination
    })
  }


  _parseField(fieldname){
    return fieldname.replace('_', ' ')
  }


  _parseFieldData(data){
    if(data === "0"){
      return "No"
    } else if(data === "1"){
      return "Yes"
    } else{
      return data
    }
  }


  render() {
    return(
      <div className="col-xs-12 form-row no-pad resource-results table-responsive" style={{opacity: this.props.loading ? '0.8' : '1'}}>
        <table className="table table-striped">
          <thead>
            <tr style={{textTransform: 'capitalize'}}>
              {this.state.results[0] ?
                Object.keys(this.state.results[0]).map((fieldname) => {
                  return fieldname === '_id' ? null : <th key={fieldname}>{this._parseField(fieldname)}</th>
                })
                :
                null
              }
            </tr>
          </thead>
          <tbody>
            {this.state.results.map((item) => {
              return (
                <tr key={item.id}>
                  {Object.entries(item).map(([fieldname, field], index) => {
                    return fieldname === '_id' ?
                      null
                      :
                      <td key={fieldname+item._id}>
                        { fieldname === 'name' ? (
                            <a href={`/${item.city ? 'business' : 'user'}/${item._id}`}>{this._parseFieldData(field)}</a>
                          )
                          :
                          this._parseFieldData(field)
                        }
                      </td>
                  })}
                </tr>
              )
            })}
          </tbody>
        </table>
      </div>
    );
  }
}
