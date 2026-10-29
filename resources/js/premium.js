import * as d3 from 'd3';
const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const menu = document.querySelector('[data-menu]');
const nav = document.querySelector('[data-nav]');
const closeMenu = () => { nav?.classList.remove('open'); menu?.setAttribute('aria-expanded','false'); };
menu?.addEventListener('click',()=>{const open=nav.classList.toggle('open');menu.setAttribute('aria-expanded',String(open));});
nav?.querySelectorAll('a').forEach(a=>a.addEventListener('click',closeMenu));
document.addEventListener('keydown',e=>{if(e.key==='Escape')closeMenu();});
window.matchMedia('(min-width: 901px)').addEventListener('change',closeMenu);
if(!reduced && 'IntersectionObserver' in window){
 document.documentElement.classList.add('rvg-motion');
 const observer=new IntersectionObserver(entries=>entries.forEach(e=>{if(e.isIntersecting){e.target.classList.add('visible');observer.unobserve(e.target);}}),{threshold:.08});
 document.querySelectorAll('.rvg-reveal').forEach(el=>observer.observe(el));
}
document.querySelector('[data-backtop]')?.addEventListener('click',()=>window.scrollTo({top:0,behavior:reduced?'instant':'smooth'}));
document.querySelectorAll('[data-filter]').forEach(button=>button.addEventListener('click',()=>{
 document.querySelectorAll('[data-filter]').forEach(b=>b.setAttribute('aria-pressed',String(b===button)));
 document.querySelectorAll('[data-project-category]').forEach(card=>{card.hidden=button.dataset.filter!=='all'&&button.dataset.filter!==card.dataset.projectCategory;});
}));
document.querySelectorAll('[data-career]').forEach(button=>button.addEventListener('click',()=>{
 const id=document.querySelector('[name=career_id]'),position=document.querySelector('[name=position]');
 if(id)id.value=button.dataset.career;if(position)position.value=button.dataset.position;
}));
document.querySelectorAll('[data-ajax-form]').forEach(form=>{
 let busy=false;
 form.addEventListener('submit',async event=>{
  event.preventDefault();if(busy||!form.reportValidity())return;
  busy=true;const button=form.querySelector('button[type=submit]'),status=form.querySelector('[role=status]'),label=button.textContent;
  button.disabled=true;button.textContent='Sending…';status.hidden=false;status.className='rvg-status';status.textContent='Please wait…';
  try{
   const response=await fetch(form.action,{method:'POST',body:new FormData(form),headers:{Accept:'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]')?.content||''}});
   const data=await response.json().catch(()=>({}));
   if(!response.ok){throw new Error(response.status===422?Object.values(data.errors||{}).flat().join(' '):(response.status===419?'Your session expired. Refresh the page and try again.':'Unable to send your request. Please try again or call us.'));}
   if(!data.success&&!data.ok)throw new Error('We could not confirm your request. Please call us.');
   status.textContent=data.message||'Thank you! Your message has been sent. Our team will get in touch.';form.reset();
  }catch(error){status.classList.add('error');status.textContent=error.message||'Network error. Please try again.';}
  finally{busy=false;button.disabled=false;button.textContent=label;}
 });
});
function renderChart(container){
 const width=Math.max(container.clientWidth,240),height=230,margin={top:18,right:15,bottom:35,left:27};
 const values=[{month:'Discover',brand:16,baseline:16},{month:'Plan',brand:25,baseline:20},{month:'Create',brand:38,baseline:24},{month:'Launch',brand:51,baseline:27},{month:'Improve',brand:78,baseline:31},{month:'Grow',brand:94,baseline:35}];
 const svg=d3.select(container).selectAll('svg').data([null]).join('svg').attr('viewBox',`0 0 ${width} ${height}`).attr('role','img').attr('aria-label','Illustrative growth journey, not measured client results. Strategic brand visibility rises across discovery, planning, creation, launch, improvement and growth.');svg.selectAll('*').remove();
 const x=d3.scalePoint().domain(values.map(d=>d.month)).range([margin.left,width-margin.right]);
 const y=d3.scaleLinear().domain([0,100]).range([height-margin.bottom,margin.top]);
 svg.append('g').attr('transform',`translate(${margin.left},0)`).call(d3.axisLeft(y).ticks(4).tickSize(-(width-margin.left-margin.right)).tickFormat('')).call(g=>g.select('.domain').remove()).call(g=>g.selectAll('line').attr('stroke','#eceeea'));
 const defs=svg.append('defs'),gradient=defs.append('linearGradient').attr('id','rvg-chart-fill').attr('x1',0).attr('y1',0).attr('x2',0).attr('y2',1);
 gradient.append('stop').attr('offset','0%').attr('stop-color','#e43d35').attr('stop-opacity',.18);gradient.append('stop').attr('offset','100%').attr('stop-color','#e43d35').attr('stop-opacity',0);
 svg.append('path').datum(values).attr('fill','url(#rvg-chart-fill)').attr('d',d3.area().x(d=>x(d.month)).y0(y(0)).y1(d=>y(d.brand)).curve(d3.curveMonotoneX));
 ['baseline','brand'].forEach(key=>svg.append('path').datum(values).attr('fill','none').attr('stroke',key==='brand'?'#e43d35':'#b8bec6').attr('stroke-width',key==='brand'?3:1.5).attr('stroke-dasharray',key==='baseline'?'4 5':null).attr('d',d3.line().x(d=>x(d.month)).y(d=>y(d[key])).curve(d3.curveMonotoneX)));
 svg.append('g').attr('transform',`translate(0,${height-margin.bottom})`).call(d3.axisBottom(x).tickSize(0).tickPadding(17)).call(g=>g.select('.domain').remove()).call(g=>g.selectAll('text').attr('fill','#8a909a').attr('font-size',width<360?8:9));
 const tooltip=svg.append('g').style('display','none');tooltip.append('rect').attr('width',114).attr('height',28).attr('rx',5).attr('fill','#111827');const tipText=tooltip.append('text').attr('x',9).attr('y',18).attr('fill','white').attr('font-size',10);
 svg.selectAll('.point').data(values).join('circle').attr('cx',d=>x(d.month)).attr('cy',d=>y(d.brand)).attr('r',4).attr('fill','#e43d35').attr('stroke','white').attr('stroke-width',2).attr('tabindex',0).attr('role','img').attr('aria-label',d=>`${d.month}: illustrative visibility index ${d.brand}`).on('mouseenter focus',function(event,d){d3.select(this).attr('r',6);tooltip.style('display',null).attr('transform',`translate(${Math.min(width-120,Math.max(0,x(d.month)-50))},${Math.max(0,y(d.brand)-38)})`);tipText.text(`${d.month} · index ${d.brand}`);}).on('mouseleave blur',function(){d3.select(this).attr('r',4);tooltip.style('display','none');});
}
document.querySelectorAll('[data-growth-chart]').forEach(container=>{renderChart(container);let frame;new ResizeObserver(()=>{cancelAnimationFrame(frame);frame=requestAnimationFrame(()=>renderChart(container));}).observe(container);});
async function initSculpture(){
 const host=document.querySelector('[data-three]');if(!host)return;
 try{
 const THREE=await import('three');
 const renderer=new THREE.WebGLRenderer({alpha:true,antialias:window.devicePixelRatio<2,powerPreference:'low-power'});
 renderer.setPixelRatio(Math.min(window.devicePixelRatio,1.7));renderer.setClearColor(0,0);renderer.outputColorSpace=THREE.SRGBColorSpace;renderer.toneMapping=THREE.ACESFilmicToneMapping;renderer.toneMappingExposure=1.5;
 host.append(renderer.domElement);renderer.domElement.setAttribute('aria-hidden','true');host.parentElement.classList.add('has-webgl');
 const scene=new THREE.Scene(),camera=new THREE.PerspectiveCamera(33,1,.1,50);camera.position.set(0,0,8.5);
 scene.add(new THREE.HemisphereLight(0xffffff,0xb6b3a9,3));
 const key=new THREE.DirectionalLight(0xffffff,5);key.position.set(-3,5,5);scene.add(key);
 const fill=new THREE.DirectionalLight(0xd6e1f1,4);fill.position.set(4,0,2);scene.add(fill);
 const group=new THREE.Group();scene.add(group);
 const geometry=new THREE.TorusKnotGeometry(1.02,.33,220,36,2,3);
 const sculpture=new THREE.Mesh(geometry,new THREE.MeshPhysicalMaterial({color:0xe84336,metalness:.58,roughness:.22,clearcoat:1,clearcoatRoughness:.2}));group.add(sculpture);group.rotation.set(.6,-.35,-.35);
 const orbGeo=new THREE.SphereGeometry(.17,24,24),orbMat=new THREE.MeshStandardMaterial({color:0xe2c7ab,metalness:.8,roughness:.25});
 [[1.8,1.3,-.5],[-1.6,-.9,.1],[1.55,-1.35,-.2]].forEach(p=>{const orb=new THREE.Mesh(orbGeo,orbMat);orb.position.set(...p);group.add(orb);});
 const shadowCanvas=document.createElement('canvas');shadowCanvas.width=128;shadowCanvas.height=128;const ctx=shadowCanvas.getContext('2d');const g=ctx.createRadialGradient(64,64,0,64,64,64);g.addColorStop(0,'rgba(24,30,37,.24)');g.addColorStop(1,'rgba(24,30,37,0)');ctx.fillStyle=g;ctx.fillRect(0,0,128,128);
 const shadow=new THREE.Mesh(new THREE.PlaneGeometry(4,1.1),new THREE.MeshBasicMaterial({map:new THREE.CanvasTexture(shadowCanvas),transparent:true,depthWrite:false}));shadow.position.set(0,-1.95,-1);scene.add(shadow);
 const resize=()=>{const w=host.clientWidth,h=host.clientHeight;renderer.setSize(w,h);camera.aspect=w/h;camera.updateProjectionMatrix();renderer.render(scene,camera);};new ResizeObserver(resize).observe(host);resize();
 let px=0,py=0,visible=true,raf;
 host.addEventListener('pointermove',e=>{const box=host.getBoundingClientRect();px=((e.clientX-box.left)/box.width-.5)*.35;py=((e.clientY-box.top)/box.height-.5)*.25;});host.addEventListener('pointerleave',()=>{px=py=0;});
 const draw=time=>{raf=null;if(!visible||document.hidden||reduced)return;group.rotation.y+=(px+.002-group.rotation.y)*.013;group.rotation.x+=(.6+py-group.rotation.x)*.025;sculpture.rotation.z=time*.00009;group.position.y=Math.sin(time*.0008)*.08;renderer.render(scene,camera);raf=requestAnimationFrame(draw);};
 const resume=()=>{if(visible&&!document.hidden&&!reduced&&!raf)raf=requestAnimationFrame(draw);};
 new IntersectionObserver(entries=>{visible=entries[0].isIntersecting;if(!visible&&raf){cancelAnimationFrame(raf);raf=null;}resume();}).observe(host);
 document.addEventListener('visibilitychange',()=>{if(document.hidden&&raf){cancelAnimationFrame(raf);raf=null;}resume();});
 renderer.domElement.addEventListener('webglcontextlost',event=>{event.preventDefault();if(raf)cancelAnimationFrame(raf);host.parentElement.classList.remove('has-webgl');host.replaceChildren();});resume();
 }catch{host.parentElement.classList.remove('has-webgl');}
}
initSculpture();
