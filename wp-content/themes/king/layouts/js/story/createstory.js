html2element:(function(){var canvasInstances=[];const hdiv=document.getElementById('stblock');var canvaz={};var tid='canvas1';canvaz['canvas1']=new fabric.Canvas('canvas1',{width:424,height:713,preserveObjectStacking:true});changeView(tid);king_canvas(tid,canvaz['canvas1']);fabric.Object.prototype.borderColor='#fff';fabric.Object.prototype.cornerColor='#fff';fabric.Object.prototype.transparentCorners=false;fabric.Object.prototype.cornerStyle='circle';fabric.Object.prototype.cornerSize=8;window.changeView=changeView;window.deletecanvas=deletecanvas;window.textAlign=textAlign;window.textStyle=textStyle;window.textfamily=textfamily;function changeView(value,element){canvas=canvaz[value];king_canvas(value,canvas);if(element){add_class_story();var sbox=document.getElementById('story-'+value);element.classList.add('sactive');sbox.classList.add('boxactive');}}
function deletecanvas(current){canvas=canvaz[tid];king_canvas(tid,canvas);add_class_story();var dbox=document.getElementById('story-'+current);dbox.parentNode.removeChild(dbox);var sbox=document.getElementById('story-'+tid);sbox.classList.add('boxactive');var scon=document.getElementById('sc-'+current);scon.parentNode.removeChild(scon);var sconp=document.getElementById('sc-'+tid);sconp.classList.add('sactive');}
function add_class_story(){var elems=document.querySelectorAll('.controls-item');[].forEach.call(elems,function(el){el.classList.remove('sactive');});var elems2=document.querySelectorAll('.king-story-box');[].forEach.call(elems2,function(el){el.classList.remove('boxactive');});}
var counter=2;document.getElementById('addcanvas').addEventListener('click',()=>{if(counter<8){var idd='canvas1';var count=counter++;var idd='canvas'+count;var didd='canvas'+(count-1);var newDiv=document.createElement('div');newDiv.id='story-'+idd;add_class_story();newDiv.className='king-story-box boxactive';newDiv.animate([{transform:'translateY(40px)'},{transform:'translateY(0)'}],{duration:300,});newDiv.innerHTML='<div class="storydel" onclick="deletecanvas(\''+idd+'\');"><i class="far fa-trash-alt"></i></div><canvas id="'+idd+'"></canvas><textarea id="text-'+idd+'" name="storyjs[]" class="hide"></textarea>';hdiv.appendChild(newDiv);canvaz[idd]=new fabric.Canvas(idd,{width:424,height:713,preserveObjectStacking:true});canvas=canvaz[idd];canvasInstances.push(canvaz[idd]);const numbers=document.getElementById('controls');var newNumber=document.createElement('span');newNumber.setAttribute('onclick','changeView("'+idd+'", this)');newNumber.id='sc-'+idd;newNumber.className='controls-item sactive';newNumber.innerHTML='<i class="far fa-id-badge"></i>';numbers.appendChild(newNumber);king_canvas(idd,canvas);}});document.getElementById('clear').addEventListener('click',()=>{!deleteActiveObjects()&&canvas.clear();});document.addEventListener('keydown',(event)=>{event.keyCode===46&&deleteActiveObjects();});document.getElementById('sfonts').onchange=function(){canvas.getActiveObject().set('fontSize',this.value);canvas.renderAll();};function deleteActiveObjects(){const activeObjects=canvas.getActiveObjects();if(!activeObjects.length)return false;if(activeObjects.length){activeObjects.forEach(function(object){canvas.remove(object);});}else{canvas.remove(activeObjects);}
return true;}
const styleZone=document.getElementById('styleZone');const colors=['#ffffff','#000000','#88bf4b','#f9cbd1','#5ed5ff','#f8e24c','#f83d3d','#fb3ea0','#dcd3ef','#583b9a','#941fb1','#f4923a','#8e939c','#ced0d4','#f7724a','#f1c43a'];let defaultColor=colors[0];let activeElement=null;const isSelectedClass='isSelected';colors.forEach((color,i)=>{const span=document.createElement('span');if(i===0){span.className=isSelectedClass;activeElement=span;}
let icon=document.createElement('i');icon.className='fas fa-circle';icon.style.color=color;span.appendChild(icon);styleZone.appendChild(span);span.addEventListener('click',(event)=>{if(span.className!==isSelectedClass){span.classList.toggle(isSelectedClass);activeElement.classList.remove(isSelectedClass);activeElement=span;strokeColor=color;}
if(canvas.getActiveObject()){const activeObjects=canvas.getActiveObjects();if(!activeObjects.length)return;activeObjects.forEach(function(object){if(object.get('textBackgroundColor').length>4){object.set('textBackgroundColor',strokeColor);}else{object.set('fill',strokeColor);}});canvas.renderAll();}else{canvas.setBackgroundColor(color,canvas.renderAll.bind(canvas));}})});function textAlign(radio){canvas.getActiveObject().set('textAlign',radio);canvas.renderAll();}
function textStyle(style){if(style==='style1'){canvas.getActiveObject().set('textBackgroundColor','');canvas.renderAll();}
if(style==='style2'){canvas.getActiveObject().set('textBackgroundColor','#fff');canvas.getActiveObject().set('fill','#000000');canvas.renderAll();}
if(style==='style3'){canvas.getActiveObject().set('textBackgroundColor','#000000');canvas.getActiveObject().set('fill','#ffffff');canvas.renderAll();}}
function textfamily(radio){canvas.getActiveObject().set('fontFamily',radio);canvas.renderAll();}
let strokeWidth=2;let strokeColor=defaultColor;document.getElementById('storyh1').addEventListener('click',()=>{var textbox=new fabric.Textbox('Type Something Here!',{left:212,top:200,fontSize:38,originX:'center',originY:'center',fontFamily:'Ubuntu',fill:'#FFF',fontWeight:400,textAlign:'left'});canvas.add(textbox);canvas.enablePointerEvents=true});var storyi;document.getElementById('saddimg').addEventListener('click',()=>{var imgElement=document.getElementById('simg');var iurl=imgElement.getAttribute("src");storyi=new fabric.Image(imgElement,{left:212,top:355,selectable:true,originX:'center',originY:'center'});let obj=canvas.getObjects().find(obj=>obj.type==='image');canvas.remove(obj);canvas.add(storyi);canvas.sendToBack(storyi);storyi.setSrc(iurl);canvas.renderAll();});var saddurl=document.getElementById('saddurl');if(saddurl){saddurl.addEventListener('click',()=>{var rect=new fabric.Rect({left:150,top:650,fill:'#fff',width:140,height:40,rx:24,ry:24,hasBorders:true,hasControls:false,lockMovementY:true,lockMovementX:true,});let obj=canvas.getObjects().find(obj=>obj.type==='rect');canvas.remove(obj);const val=document.querySelector('#slinki').value;rect.set('fillRule',val);if(val){canvas.add(rect);}});}
document.getElementById('saddvid').addEventListener('click',()=>{var vurl=document.getElementById('svid').getAttribute("href");var videoE=document.createElement('video');videoE.muted=true;videoE.loop=true;var source=document.createElement('source');source.src=vurl;source.type='video/mp4';videoE.appendChild(source);videoE.addEventListener('loadedmetadata',function(){videoE.width=videoE.videoWidth;videoE.height=videoE.videoHeight;var video1=new fabric.Image(videoE,{left:212,top:355,width:videoE.videoWidth,height:videoE.videoHeight,objectCaching:false,originX:'center',originY:'center'});let obj=canvas.getObjects().find(obj=>obj.type==='image');canvas.remove(obj);canvas.add(video1);canvas.sendToBack(video1);video1.getElement().play();video1.set('video_src',vurl);});if(navigator.mediaDevices===undefined){navigator.mediaDevices={};}
if(navigator.mediaDevices.getUserMedia===undefined){navigator.mediaDevices.getUserMedia=function(constraints){var getUserMedia=navigator.webkitGetUserMedia||navigator.mozGetUserMedia||navigator.msGetUserMedia;if(!getUserMedia){return Promise.reject(new Error('getUserMedia is not implemented in this browser'));}
return new Promise(function(resolve,reject){getUserMedia.call(navigator,constraints,resolve,reject);});}}
fabric.util.requestAnimFrame(function render(){canvas.renderAll();fabric.util.requestAnimFrame(render);});fabric.Object.prototype.toObject=(function(toObject){return function(propertiesToInclude){propertiesToInclude=(propertiesToInclude||[]).concat(['video_src']);return toObject.apply(this,[propertiesToInclude]);};})(fabric.Object.prototype.toObject);});function king_canvas(tid,canvas){canvas.on('after:render',function(o){var textarea=document.getElementById('text-'+tid);canvas.includeDefaultValues=false;var json_data=JSON.stringify(canvas.toDatalessJSON());textarea.innerHTML=json_data;});}})(document);