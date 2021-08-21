import React from 'react';

export default class FileDrop extends React.Component {

  constructor(){
    super();

    this.state = {
      hasFile: false
    };
  }

  render() {
    let multiple = this.props.dropType == "featured" ? true : false;
    let name = this.props.dropType == "featured" ? `${this.props.dropType}[]` : this.props.dropType;
    return(
      <input
        onChange={this.props.fileHandler.bind(this)}
        className={`file-drop ${this.props.dropType}`}
        name={name}
        type="file"
        accept={this.props.accepted}
        data-file={this.state.hasFile}
        multiple={multiple}
      />
    );
  }
}
