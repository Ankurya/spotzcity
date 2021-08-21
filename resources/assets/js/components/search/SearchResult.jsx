import React from 'react';


export default class SearchResult extends React.Component {
  constructor(props){
    super(props);

    this.state = props.business
  }

  render() {
    return(
      <div id={this.state.id} className="col-xs-12 business-result no-pad-left no-pad-small">
        <div className="business-pic pull-left">
          <img src={this.state.logo ? `assets/storage/${this.state.logo}` : 'assets/images/placeholder.png'} className="img-responsive" />
        </div>
        <div className="business-info pull-left">
          <h4>
            {this.props.index}) <a href={"/business/"+this.state.slug}>{this.state.name}</a>
          </h4>
          <div id="rating-bar" data-interactive="0">
            <ul className="rating-icons sm">
              <li>
                <img src="assets/images/logo-symbol-only.png" className={this.state.rating >= 1 ? "rating-icon active" : "rating-icon inactive"} data-rating-level="1"/>
              </li>
              <li>
                <img src="assets/images/logo-symbol-only.png" className={this.state.rating >= 2 ? "rating-icon active" : "rating-icon inactive"} data-rating-level="2"/>
              </li>
              <li>
                <img src="assets/images/logo-symbol-only.png" className={this.state.rating >= 3 ? "rating-icon active" : "rating-icon inactive"} data-rating-level="3"/>
              </li>
              <li>
                <img src="assets/images/logo-symbol-only.png" className={this.state.rating >= 4 ? "rating-icon active" : "rating-icon inactive"} data-rating-level="4"/>
              </li>
              <li>
                <img src="assets/images/logo-symbol-only.png" className={this.state.rating >= 5 ? "rating-icon active" : "rating-icon inactive"} data-rating-level="5"/>
              </li>
              <li>
                <p>
                  <small>&nbsp;| {this.state.review_count} Reviews</small>
                </p>
              </li>
            </ul>
          </div>
            {parseInt(this.state.for_sale) ?
              <p>
                <font style={{color: "green"}}>
                  <i className="icon-tag"></i> For Sale
                </font>
              </p>
              :
              ''
            }
          <p>{this.state.categories_list.join(", ")}, {this.state.commodities_list.join(", ")}</p>
          <p>{(this.state.description || "").length > 150 ? this.state.description.substring(0,147)+"..." : (this.state.description || "No description available.")} <a href={"/business/"+this.state.slug}>Read More</a></p>
        </div>
      </div>
    );
  }
}
