import React from 'react';
import FileDrop from './FileDrop.jsx';

export default class FeaturedDrop extends React.Component {
  constructor(props){
    super(props);

    let images = props.img ? JSON.parse(props.img) : [];
    window._files = _.clone(images);

    this.state = {
      images: images
    }
  }

  _imageDisplay(images = this.state.images){
    var output = []
    for(let i = 0; i<images.length; i++){
      let styles = {
        backgroundImage: `url(${images[i]})`
      }
      output.push(
        <div className="col-xs-4" key={`${i}`}>
          <span className="close-me pull-right" onClick={this._removePhoto.bind(this,i)}>
            <i className="icon-close"></i>
          </span>
          <div className="featured-thumb" style={styles}></div>
        </div>
      );
    }
    return output;
  }

  _removePhoto(index, event){
    let c = confirm("Are you sure you want to remove this photo?");
    if(c){
      let path = this.state.images[index].split('storage/')[1];

      if(!path){
        let clone = _.clone(this.state.images);
        window._files.splice(index,1);
        clone.splice(index,1);
        this.setState({images: clone});
        return;
      }
      $.ajax({
        method: 'DELETE',
        url: `/business/${this.props.businessid}/remove-featured-photo`,
        data: {
          path: path
        }
      })
      .done(()=>{
        let clone = _.clone(this.state.images);
        window._files.splice(index,1);
        clone.splice(index,1);
        this.setState({images: clone});
      })
      .fail((resp)=>{
        console.log(resp);
        // alert('FAIL');
      });
    }
  }

  _handleFiles(event){
    console.log(event.target.files);
    let images = _.clone(this.state.images);
    let exisingCount = images.length
    console.log(exisingCount)

    if(event.target.files[0]){
      var iterator = 0;

      for(let file of event.target.files){
        if(iterator > (2 - exisingCount)){
          console.log('max length reached, not processing other images')
          break;
        }
        console.log(file);
        if(images.length < 3){
          window._files.push(file);
          images.push(window.URL.createObjectURL(file));
        }
        iterator++;
      }
      this.setState({images: images});
    }
  }

  render() {
    return(
      <div>
        {this._imageDisplay()}
        <div className="logo-input-wrap">
          <FileDrop dropType="featured" fileHandler={this._handleFiles.bind(this)} disabled={this.state.images.length === 3} accepted=".jpg,.jpeg,.png,.gif" />
          <i className="icon-camera"></i>
          <button className="btn">{this.state.images.length === 3 ? 'Max photos reached' : 'Click Here or Drag Photos In' }</button>
        </div>
      </div>
    );
  }
}
