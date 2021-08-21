import React from 'react';
import FileDrop from './FileDrop.jsx';

export default class LogoDrop extends React.Component {
  constructor(props){
    super(props);

    this.state = {
      logoUrl: props.img,
    }
  }

  render() {
    let styles = {
      backgroundImage: `url(${this.state.logoUrl})`
    }
    return(
      <div className="logo-input-wrap" style={styles}>
        <FileDrop dropType="logo" fileHandler={this._handleFile.bind(this)} accepted=".jpg,.jpeg,.png,.gif" />
        <button className="btn">Click Here or Drag File In</button>
      </div>
    );
  }

  _handleFile(event){
    console.log(event.target.files);

    if(event.target.files[0]){
      let file = event.target.files[0];
      let url = window.URL.createObjectURL(file);

      this.setState({logoUrl: url});
    }
  }
}
