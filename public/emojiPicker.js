"use strict"
const generateElements=(emojiInput)=>{const clickLink=(event)=>{emojiInput.value=emojiInput.value+event.target.innerHTML
emojiPicker.style.display='none'
if(typeof angular!=="undefined"){angular.element(emojiInput).triggerHandler('change')}}
emojiInput.style=`width: 100%`
const emojiContainer=document.createElement('div')//document.getElementById("myElement");
emojiContainer.style=`position: relative;`
emojiContainer.classList.add("emojis");
const parent=emojiInput.parentNode
parent.replaceChild(emojiContainer,emojiInput)
emojiContainer.appendChild(emojiInput)
const emojiPicker=document.createElement('div')
emojiPicker.classList.add("emoji-section");
emojiPicker.style=`position: absolute;
    left: 2px;
    top: 20px;
    z-index: 999;
    display: none;
    width: 175px;
    padding: 5px 2px 5px 5px;
    margin-top: 5px;
    overflow: hidden;
    background: #fff;
    border: 1px #dfdfdf solid;
    border-radius: 3px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);`
const emojiTrigger=document.createElement('a')
emojiTrigger.classList.add("emoji-section");
emojiTrigger.style=`position: absolute;
    top: 22px;
    left: 15px;
    text-decoration: none;`
emojiTrigger.setAttribute('href',"javascript:void(0)")
//emojiTrigger.innerHTML="<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"25\" height=\"25\" viewBox=\"0 0 12 14\"><path d=\"M8.9 8.4q-0.3 0.9-1.1 1.5t-1.8 0.6-1.8-0.6-1.1-1.5q-0.1-0.2 0-0.4t0.3-0.2q0.2-0.1 0.4 0t0.2 0.3q0.2 0.6 0.7 1t1.2 0.4 1.2-0.4 0.7-1q0.1-0.2 0.3-0.3t0.4 0 0.3 0.2 0 0.4zM5 5q0 0.4-0.3 0.7t-0.7 0.3-0.7-0.3-0.3-0.7 0.3-0.7 0.7-0.3 0.7 0.3 0.3 0.7zM9 5q0 0.4-0.3 0.7t-0.7 0.3-0.7-0.3-0.3-0.7 0.3-0.7 0.7-0.3 0.7 0.3 0.3 0.7zM11 7q0-1-0.4-1.9t-1.1-1.6-1.6-1.1-1.9-0.4-1.9 0.4-1.6 1.1-1.1 1.6-0.4 1.9 0.4 1.9 1.1 1.6 1.6 1.1 1.9 0.4 1.9-0.4 1.6-1.1 1.1-1.6 0.4-1.9zM12 7q0 1.6-0.8 3t-2.2 2.2-3 0.8-3-0.8-2.2-2.2-0.8-3 0.8-3 2.2-2.2 3-0.8 3 0.8 2.2 2.2 0.8 3z\"/></svg>"
emojiTrigger.innerHTML="<svg viewBox=\"0 0 200 200\" width=\"27\"  height=\"27\"><circle cx=\"100\" cy=\"100\" fill=\"#f9bf44\" r=\"78\" stroke=\"black\" stroke-width=\"3\" /><g><circle cx=\"65\" cy=\"82\" r=\"12\" /><circle cx=\"130\" cy=\"82\" r=\"12\" /></g><path d=\"M65 115 a1,0.8 0 0,0 65,0\" fill=\"none\" stroke=\"black\" stroke-width=\"3\" /></svg>"
emojiTrigger.onclick=()=>{emojiPicker.style.display=emojiPicker.style.display==='block'?'none':'block';}
emojiContainer.appendChild(emojiTrigger)
const emojiList=document.createElement('ul')
emojiList.style=`padding: 0;
    margin: 0;
    list-style: none;`
const emojis=[0x1F601,0x1F602,0x1F603,0x1F60D,0x1F60A,0x1F614,0x1F613,0x1F633,0x1F631,0x1F621,0x1F621,0x1F648,0x1F62D,0x1F44D,0x1F389];emojis.map((item)=>{const emojiLi=document.createElement('li')
emojiLi.style=`display: inline-block;
        margin: 5px;`
const emojiLink=document.createElement('a')
emojiLink.style=`text-decoration: none;
        margin: 5px;
        position: initial;
        font-size: 24px;`
emojiLink.setAttribute('href',"javascript:void(0)")
emojiLink.innerHTML=String.fromCodePoint(item)
emojiLink.onclick=clickLink
emojiList.appendChild(emojiLink)})
var node = document.createElement("span");
node.classList.add("close");
var textnode = document.createTextNode("x");
var att = document.createAttribute("onclick");      
att.value = 'close_btn();';                          
node.setAttributeNode(att);

node.appendChild(textnode);     
emojiPicker.appendChild(node)
emojiPicker.appendChild(emojiList)
emojiContainer.appendChild(emojiPicker)}
window.EmojiPicker={init:()=>{const emojiInputs=document.querySelectorAll('[data-emoji="true"]');emojiInputs.forEach((element)=>{generateElements(element)})}}

function close_btn(){
    $("div.emoji-section").hide();
}
