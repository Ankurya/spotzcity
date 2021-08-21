import React from 'react';
import FileDrop from './FileDrop.jsx';

export default class AdDrop extends React.Component {
  constructor(props){
    super(props);
    console.log(props);
    this.state = {
      image: props.img,
      sidebar: props.sidebarEdit,
      banner: props.bannerEdit
    }
  }


  _handleFile(event){
    console.log(event.target.files);

    if(event.target.files[0]){
      let file = event.target.files[0];
      let url = window.URL.createObjectURL(file);
      this.setState({image: url});

      // Determine native height + width
      let img = new Image();
      img.src = url;

      if(img.complete){
        this._checkDimensions(img);
      } else{
        img.addEventListener('load', (e)=>{
          this._checkDimensions(img);
        });
        img.addEventListener('error', (e)=>{
          console.error('Error loading image');
        });
      }
    }
  }


  _checkDimensions(img){
    console.log(img.width,img.height);
    if(img.width === 1600 && img.height === 200){
      console.info('Banner Size');
      this.setState({
        banner: true,
        sidebar: false
      });
    } else if(img.width === 594 && img.height === 396){
      console.info('Sidebar Size');
      this.setState({
        sidebar: true,
        banner: false
      });
    } else{
      console.info('Incorrect Dimensions');
      this.setState({
        banner: false,
        sidebar: false
      });
    }
  }


  render() {
    let styles = {
      backgroundImage: `url(${this.state.image})`,
      backgroundPosition: 'center',
      backgroundRepeat: 'no-repeat',
      backgroundSize: 'contain'
    }

    const banner_indicator = this.state.banner ?
      <i id="banner-indicator" data-valid="true" className="icon-check indicator green"></i>
      :
      <i id="banner-indicator" data-valid="false" className="icon-close indicator red"></i>;

    const sidebar_indicator = this.state.sidebar ?
      <i id="sidebar-indicator" data-valid="true" className="icon-check indicator green"></i>
      :
      <i id="sidebar-indicator" data-valid="false" className="icon-close indicator red"></i>;

    return(
      <div className="ad-input-wrap" style={styles}>
        <div className="indicators">
          <p>
            <span className="banner-indicator">Banner (1600 x 200): {banner_indicator}</span>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <span className="sidebar-indicator">Sidebar (594 x 396): {sidebar_indicator}</span>
          </p>
        </div>
        <FileDrop dropType="ad" fileHandler={this._handleFile.bind(this)} accepted=".jpg,.jpeg,.png,.gif" />
        <button className="btn">Click Here or Drag Image In</button>
      </div>
    );
  }

}
