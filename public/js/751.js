"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[751],{9468:(e,t,n)=>{n.d(t,{Z:()=>a});var r=n(3645),o=n.n(r)()((function(e){return e[1]}));o.push([e.id,".enter-from,.leave-to{opacity:0}.enter-active,.leave-active{transition-duration:.5s;transition-timing-function:ease-in-out}.enter-to,.leave-from{opacity:1}",""]);const a=o},3645:e=>{e.exports=function(e){var t=[];return t.toString=function(){return this.map((function(t){var n=e(t);return t[2]?"@media ".concat(t[2]," {").concat(n,"}"):n})).join("")},t.i=function(e,n,r){"string"==typeof e&&(e=[[null,e,""]]);var o={};if(r)for(var a=0;a<this.length;a++){var l=this[a][0];null!=l&&(o[l]=!0)}for(var i=0;i<e.length;i++){var c=[].concat(e[i]);r&&o[c[0]]||(n&&(c[2]?c[2]="".concat(n," and ").concat(c[2]):c[2]=n),t.push(c))}},t}},3379:(e,t,n)=>{var r,o=function(){return void 0===r&&(r=Boolean(window&&document&&document.all&&!window.atob)),r},a=function(){var e={};return function(t){if(void 0===e[t]){var n=document.querySelector(t);if(window.HTMLIFrameElement&&n instanceof window.HTMLIFrameElement)try{n=n.contentDocument.head}catch(e){n=null}e[t]=n}return e[t]}}(),l=[];function i(e){for(var t=-1,n=0;n<l.length;n++)if(l[n].identifier===e){t=n;break}return t}function c(e,t){for(var n={},r=[],o=0;o<e.length;o++){var a=e[o],c=t.base?a[0]+t.base:a[0],s=n[c]||0,u="".concat(c," ").concat(s);n[c]=s+1;var d=i(u),m={css:a[1],media:a[2],sourceMap:a[3]};-1!==d?(l[d].references++,l[d].updater(m)):l.push({identifier:u,updater:h(m,t),references:1}),r.push(u)}return r}function s(e){var t=document.createElement("style"),r=e.attributes||{};if(void 0===r.nonce){var o=n.nc;o&&(r.nonce=o)}if(Object.keys(r).forEach((function(e){t.setAttribute(e,r[e])})),"function"==typeof e.insert)e.insert(t);else{var l=a(e.insert||"head");if(!l)throw new Error("Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid.");l.appendChild(t)}return t}var u,d=(u=[],function(e,t){return u[e]=t,u.filter(Boolean).join("\n")});function m(e,t,n,r){var o=n?"":r.media?"@media ".concat(r.media," {").concat(r.css,"}"):r.css;if(e.styleSheet)e.styleSheet.cssText=d(t,o);else{var a=document.createTextNode(o),l=e.childNodes;l[t]&&e.removeChild(l[t]),l.length?e.insertBefore(a,l[t]):e.appendChild(a)}}function p(e,t,n){var r=n.css,o=n.media,a=n.sourceMap;if(o?e.setAttribute("media",o):e.removeAttribute("media"),a&&"undefined"!=typeof btoa&&(r+="\n/*# sourceMappingURL=data:application/json;base64,".concat(btoa(unescape(encodeURIComponent(JSON.stringify(a))))," */")),e.styleSheet)e.styleSheet.cssText=r;else{for(;e.firstChild;)e.removeChild(e.firstChild);e.appendChild(document.createTextNode(r))}}var f=null,b=0;function h(e,t){var n,r,o;if(t.singleton){var a=b++;n=f||(f=s(t)),r=m.bind(null,n,a,!1),o=m.bind(null,n,a,!0)}else n=s(t),r=p.bind(null,n,t),o=function(){!function(e){if(null===e.parentNode)return!1;e.parentNode.removeChild(e)}(n)};return r(e),function(t){if(t){if(t.css===e.css&&t.media===e.media&&t.sourceMap===e.sourceMap)return;r(e=t)}else o()}}e.exports=function(e,t){(t=t||{}).singleton||"boolean"==typeof t.singleton||(t.singleton=o());var n=c(e=e||[],t);return function(e){if(e=e||[],"[object Array]"===Object.prototype.toString.call(e)){for(var r=0;r<n.length;r++){var o=i(n[r]);l[o].references--}for(var a=c(e,t),s=0;s<n.length;s++){var u=i(n[s]);0===l[u].references&&(l[u].updater(),l.splice(u,1))}n=a}}}},3744:(e,t)=>{t.Z=(e,t)=>{const n=e.__vccOpts||e;for(const[e,r]of t)n[e]=r;return n}},9157:(e,t,n)=>{n.d(t,{Z:()=>a});var r=n(821);const o={props:{isCheck:{type:Boolean,default:!1},isRadio:{type:Boolean,default:!1},inline:{type:Boolean,default:!1}},computed:{inputContainerStyle:function(){return"".concat(this.isCheck||this.isRadio?"form-check"+(this.inline?" form-check-inline":""):"input-group"," has-validation")}}};const a=(0,n(3744).Z)(o,[["render",function(e,t,n,o,a,l){return(0,r.openBlock)(),(0,r.createElementBlock)("div",{class:(0,r.normalizeClass)(l.inputContainerStyle)},[(0,r.renderSlot)(e.$slots,"default")],2)}]])},4531:(e,t,n)=>{n.d(t,{Z:()=>s});var r=n(821),o=["type","id","name","readonly","disabled","value","checked","autocomplete"];var a=n(9157),l=n(3267),i=n(6451);const c={components:{GroupForm:a.Z,LabelForm:l.Z,InvalidFeedbackForm:i.Z},props:{label:{type:String,default:null},type:{type:String,default:"text"},name:{type:String,default:null},errorMessage:{type:String,default:null},modelValue:{type:[String,Number,Boolean],default:null},borderless:{type:Boolean,default:!1},readonly:{type:Boolean,default:!1},disabled:{type:Boolean,default:!1},inline:{type:Boolean,default:!1}},data:function(){return{checked:!1}},watch:{modelValue:{immediate:!0,handler:function(e){this.checked=!!e}}},computed:{inputStyle:function(){return"".concat(this.isCheckOrRadioType?"form-check-input":"form-control"," ").concat(this.borderless?"border-0":""," ").concat(this.errorMessage?"is-invalid":"")},isCheckOrRadioType:function(){return"checkbox"==this.type||"radio"==this.type}},methods:{updateValue:function(e){"file"==this.type?this.$emit("update:modelValue",e):this.isCheckOrRadioType?this.$emit("update:modelValue",e.target.checked):this.$emit("update:modelValue",e.target.value)}}};const s=(0,n(3744).Z)(c,[["render",function(e,t,n,a,l,i){var c=(0,r.resolveComponent)("LabelForm"),s=(0,r.resolveComponent)("InvalidFeedbackForm"),u=(0,r.resolveComponent)("GroupForm");return(0,r.openBlock)(),(0,r.createElementBlock)(r.Fragment,null,[n.label&&!i.isCheckOrRadioType?((0,r.openBlock)(),(0,r.createBlock)(c,{key:0,label:n.label,name:n.name},null,8,["label","name"])):(0,r.createCommentVNode)("",!0),(0,r.createVNode)(u,{"is-check":i.isCheckOrRadioType,"is-radio":i.isCheckOrRadioType,inline:n.inline},{default:(0,r.withCtx)((function(){return[(0,r.createElementVNode)("input",{onInput:t[0]||(t[0]=function(){return i.updateValue&&i.updateValue.apply(i,arguments)}),class:(0,r.normalizeClass)(i.inputStyle),type:n.type,id:n.name,name:n.name,readonly:n.readonly,disabled:n.disabled,value:n.modelValue,checked:l.checked,autocomplete:"password"==n.type?"new-password":""},null,42,o),n.label&&i.isCheckOrRadioType?((0,r.openBlock)(),(0,r.createBlock)(c,{key:0,class:"form-check-label",label:n.label,name:n.name},null,8,["label","name"])):(0,r.createCommentVNode)("",!0),n.errorMessage?((0,r.openBlock)(),(0,r.createBlock)(s,{key:1,"error-message":n.errorMessage},null,8,["error-message"])):(0,r.createCommentVNode)("",!0)]})),_:1},8,["is-check","is-radio","inline"])],64)}]])},6451:(e,t,n)=>{n.d(t,{Z:()=>l});var r=n(821),o={class:"invalid-feedback"};const a={props:{errorMessage:{type:String,default:null}}};const l=(0,n(3744).Z)(a,[["render",function(e,t,n,a,l,i){return(0,r.openBlock)(),(0,r.createElementBlock)("small",o,(0,r.toDisplayString)(n.errorMessage),1)}]])},3267:(e,t,n)=>{n.d(t,{Z:()=>l});var r=n(821),o=["for"];const a={props:{label:{type:String,default:null},name:{type:String,default:null}}};const l=(0,n(3744).Z)(a,[["render",function(e,t,n,a,l,i){return n.label?((0,r.openBlock)(),(0,r.createElementBlock)("label",{key:0,for:n.name,class:"mb-1"},(0,r.toDisplayString)(n.label),9,o)):(0,r.createCommentVNode)("",!0)}]])},5827:(e,t,n)=>{n.d(t,{Z:()=>m});var r=n(821),o=["name","id","readonly","disabled","value"],a=["value"];var l=n(9157),i=n(3267),c=n(6451);function s(e){return function(e){if(Array.isArray(e))return u(e)}(e)||function(e){if("undefined"!=typeof Symbol&&null!=e[Symbol.iterator]||null!=e["@@iterator"])return Array.from(e)}(e)||function(e,t){if(!e)return;if("string"==typeof e)return u(e,t);var n=Object.prototype.toString.call(e).slice(8,-1);"Object"===n&&e.constructor&&(n=e.constructor.name);if("Map"===n||"Set"===n)return Array.from(e);if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return u(e,t)}(e)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function u(e,t){(null==t||t>e.length)&&(t=e.length);for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n];return r}const d={components:{GroupForm:l.Z,LabelForm:i.Z,InvalidFeedbackForm:c.Z},props:{label:{type:String,default:null},name:{type:String,default:null},errorMessage:{type:String,default:null},modelValue:{type:[String,Number],default:"none"},options:{type:Array,default:[]},text:{type:String,default:null},readonly:{type:Boolean,default:!1},disabled:{type:Boolean,default:!1}},computed:{selectStyle:function(){return"form-select ".concat(this.errorMessage?"is-invalid":"")},theOptions:function(){var e;return[{text:null!==(e=this.text)&&void 0!==e?e:"Selecione um",value:"none"}].concat(s(this.options))}},methods:{updateValue:function(e){this.$emit("update:modelValue",e.target.value)}}};const m=(0,n(3744).Z)(d,[["render",function(e,t,n,l,i,c){var s=(0,r.resolveComponent)("LabelForm"),u=(0,r.resolveComponent)("InvalidFeedbackForm"),d=(0,r.resolveComponent)("GroupForm");return(0,r.openBlock)(),(0,r.createElementBlock)(r.Fragment,null,[n.label?((0,r.openBlock)(),(0,r.createBlock)(s,{key:0,label:n.label,name:n.name},null,8,["label","name"])):(0,r.createCommentVNode)("",!0),(0,r.createVNode)(d,null,{default:(0,r.withCtx)((function(){return[(0,r.createElementVNode)("select",{onInput:t[0]||(t[0]=function(){return c.updateValue&&c.updateValue.apply(c,arguments)}),class:(0,r.normalizeClass)(c.selectStyle),name:n.name,id:n.name,readonly:n.readonly,disabled:n.disabled,value:n.modelValue},[((0,r.openBlock)(!0),(0,r.createElementBlock)(r.Fragment,null,(0,r.renderList)(c.theOptions,(function(e){return(0,r.openBlock)(),(0,r.createElementBlock)("option",{key:e.value,value:e.value},(0,r.toDisplayString)(e.text),9,a)})),128))],42,o),n.errorMessage?((0,r.openBlock)(),(0,r.createBlock)(u,{key:0,"error-message":n.errorMessage},null,8,["error-message"])):(0,r.createCommentVNode)("",!0)]})),_:1})],64)}]])},2526:(e,t,n)=>{n.d(t,{Z:()=>g});var r=n(821),o={class:"alert-inner d-flex align-items-center py-2 px-3"},a={class:"d-flex align-items-center me-auto"},l=["innerHTML"];var i=n(3589),c=n(6888);const s={methods:{}};var u=n(3379),d=n.n(u),m=n(9468),p={insert:"head",singleton:!1};d()(m.Z,p);m.Z.locals;var f=n(3744);const b=(0,f.Z)(s,[["render",function(e,t,n,o,a,l){return(0,r.openBlock)(),(0,r.createBlock)(r.Transition,{"enter-from-class":"enter-from","enter-active-class":"enter-active","enter-to-class":"enter-to","leave-from-class":"leave-from","leave-active-class":"leave-active","leave-to-class":"leave-to"},{default:(0,r.withCtx)((function(){return[(0,r.renderSlot)(e.$slots,"default")]})),_:3})}]]),h={components:{ButtonUi:i.Z,IconUi:c.Z,FadeTransition:b},data:function(){return{theMessage:null,theVariant:null,time:null,timeStatus:0,timerHandler:null,intervalHandler:null}},props:{variant:{type:String,default:"default"},message:{type:String,default:null},fixed:{type:Boolean,default:!1},noAutoClose:{type:Boolean,default:!1},position:{type:String,default:"top"}},watch:{message:{immediate:!0,handler:function(e){this.theMessage=e}},variant:{immediate:!0,handler:function(e){this.theVariant=e}}},computed:{alertStyle:function(){var e="top"==this.position?"alert-float-top":"alert-float-bottom";return"alert alert-".concat(this.theVariant," ").concat(this.fixed?"":"alert-float "+e," py-0 px-0")},alertIcon:function(){return"".concat({default:"infoCircleFill",success:"checkCircleFill",info:"infoCircleFill",warning:"exclamationCircleFill",danger:"exclamationCircleFill"}[this.theVariant])}},methods:{add:function(e,t){this.theMessage=e,this.theVariant=t,this.timerHandler&&this.timerReset(),this.noAutoClose||(this.time=10,this.timer())},clear:function(){this.theMessage=null,this.theVariant=null,!this.noAutoClose&&this.timerHandler&&this.timerReset()},timer:function(){var e=this;this.timerHandler=setTimeout((function(){e.clear()}),1e3*this.time),this.intervalHandler=setInterval((function(){e.timeStatus++}),100)},timerReset:function(){clearTimeout(this.timerHandler),clearInterval(this.intervalHandler),this.timeStatus=0}}},g=(0,f.Z)(h,[["render",function(e,t,n,i,c,s){var u=(0,r.resolveComponent)("IconUi"),d=(0,r.resolveComponent)("ButtonUi"),m=(0,r.resolveComponent)("FadeTransition");return(0,r.openBlock)(),(0,r.createBlock)(m,null,{default:(0,r.withCtx)((function(){return[c.theMessage?((0,r.openBlock)(),(0,r.createElementBlock)("div",{key:0,class:(0,r.normalizeClass)(s.alertStyle),role:"alert"},[(0,r.createElementVNode)("div",o,[(0,r.createElementVNode)("div",a,[(0,r.createVNode)(u,{icon:s.alertIcon,class:"alert-icon"},null,8,["icon"]),(0,r.createElementVNode)("p",{class:"mb-0 ms-3",innerHTML:c.theMessage},null,8,l)]),(0,r.createVNode)(d,{onClick:s.clear,type:"button",icon:"xLg",size:"sm"},null,8,["onClick"])]),c.time?((0,r.openBlock)(),(0,r.createElementBlock)("div",{key:0,class:"alert-timer",style:(0,r.normalizeStyle)(["width:".concat(c.timeStatus,"%;")])},null,4)):(0,r.createCommentVNode)("",!0)],2)):(0,r.createCommentVNode)("",!0)]})),_:1})}]])},3589:(e,t,n)=>{n.d(t,{Z:()=>c});var r=n(821),o=["innerHTML"];var a=n(6888),l=n(9038);const i={components:{IconUi:a.Z,Link:l.rU},props:{text:{type:String,default:null},variant:{type:String,default:null},icon:{type:String,default:null},size:{type:String,default:null},type:{type:String,default:"button"},disabled:{type:Boolean,default:!1},outlined:{type:Boolean,default:!1},customClass:{type:String,default:null},isActive:{type:Boolean,default:!1},href:{type:String,default:null},to:{type:String,default:null},title:{type:String,default:null},target:{type:String,default:"_self"}},computed:{getType:function(){return this.to||this.href?null:this.type},getTag:function(){return this.to?"Link":this.href?"a":"button"},style:function(){if(this.customClass)return this.customClass;var e=this.variant?(this.outlined?"btn-outline-":"btn-")+this.variant:"bg-transparent";return"btn ".concat(this.size?"btn-"+this.size:""," ").concat(e," ").concat(!!this.isActive&&"active")},getHref:function(){var e,t;return null!==(e=this.href)&&void 0!==e?e:null!==(t=this.to)&&void 0!==t?t:null},getTarget:function(){return this.getHref?this.target:null}}};const c=(0,n(3744).Z)(i,[["render",function(e,t,n,a,l,i){var c=(0,r.resolveComponent)("IconUi");return(0,r.openBlock)(),(0,r.createBlock)((0,r.resolveDynamicComponent)(i.getTag),{type:i.getType,class:(0,r.normalizeClass)(i.style),disabled:n.disabled,href:i.getHref,title:n.title,target:i.getTarget},{default:(0,r.withCtx)((function(){return[e.$slots.buttonContent?(0,r.renderSlot)(e.$slots,"buttonContent",{key:0}):((0,r.openBlock)(),(0,r.createElementBlock)(r.Fragment,{key:1},[n.icon?((0,r.openBlock)(),(0,r.createBlock)(c,{key:0,icon:n.icon},null,8,["icon"])):(0,r.createCommentVNode)("",!0),(0,r.createElementVNode)("span",{class:(0,r.normalizeClass)({"ms-2":n.icon&&n.text}),innerHTML:n.text},null,10,o)],64))]})),_:3},8,["type","class","disabled","href","title","target"])}]])},6888:(e,t,n)=>{n.d(t,{Z:()=>s});var r,o=n(821);function a(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}var l=(a(r={app:"bi bi-app",appIndicator:"bi bi-app-indicator",arrowLeft:"bi bi-arrow-left",arrowRight:"bi bi-arrow-right",arrowUp:"bi bi-arrow-up",arrowDown:"bi bi-arrow-down",calendarCheck:"bi bi-calendar2-check",calendarDate:"bi bi-calendar2-date",check:"bi bi-check",checkLg:"bi bi-check-lg",checkCircleFill:"bi bi-check-circle-fill",collection:"bi bi-collection",collectionPlay:"bi bi-collection-play",cog:"bi bi-gear",cogFill:"bi bi-gear-fill",exclamationCircleFill:"bi bi-exclamation-circle-fill",eye:"bi bi-eye",fileEarmark:"bi bi-file-earmark",fileEarmarkText:"bi bi-file-earmark-text",fileEarmarkPlus:"bt bi-file-earmark-plus",infoCircleFill:"bi bi-info-circle-fill",images:"bi bi-images",image:"bi bi-image",layoutWtf:"bi bi-layout-wtf",listRight:"bi bi-filter-right",listLeft:"bi bi-filter-left",login:"bi bi-box-arrow-right",logout:"bi bi-box-arrow-left",load:"bi bi-arrow-clockwise",loading:"bi bi-arrow-clockwise animation-rotate-z",home:"bi bi-house",pencilSquare:"bi bi-pencil-square",pieChart:"bi bi-pie-chart",plus:"bi bi-plus",plusLg:"bi bi-plus-lg",search:"bi bi-search",sliders:"bi bi-sliders",sliders2:"bi bi-sliders2",sliders2Vertical:"bi bi-sliders2-vertical",trash:"bi bi-trash",textLeft:"bi bi-text-left",textRight:"bi bi-text-right",textCenter:"bi bi-text-center",video:"bi bi-play-btn",user:"bi bi-person",users:"bi bi-people",userX:"bi bi-person-x",userCheck:"bi bi-person-check",userPlus:"bi bi-person-plus",userCircle:"bi bi-person-circle"},"userPlus","bi bi-person-plus"),a(r,"userMinus","bi bi-person-dash"),a(r,"x","bi bi-x"),a(r,"xLg","bi bi-x-lg"),r);const i=function(e){var t;return null!==(t=l[e])&&void 0!==t?t:""},c={props:{icon:{type:String,default:"app"}},computed:{theIcon:function(){return"icon ".concat(i(this.icon))}}};const s=(0,n(3744).Z)(c,[["render",function(e,t,n,r,a,l){return(0,o.openBlock)(),(0,o.createElementBlock)("span",{class:(0,o.normalizeClass)(l.theIcon)},null,2)}]])},3514:(e,t,n)=>{n.d(t,{Z:()=>E});var r=n(821),o={class:"container"},a={class:"row"},l=(0,r.createElementVNode)("div",{class:"col-12 col-lg-5 col-xl-5"},null,-1),i={class:"col-12 col-lg-7 col-xl-7"},c={key:0,class:"fs-4 fw-semibold text-center pt-1 pb-2"},s={class:"card card-body border-0 app-inner"},u={class:"text-center pt-3 pb-2"},d={key:0,class:"mb-0"},m=(0,r.createTextVNode)(" Caso possua uma conta, "),p=(0,r.createTextVNode)("clique aqui para fazer login"),f=(0,r.createTextVNode)(". "),b={key:1,class:"mb-0"},h=(0,r.createTextVNode)("Criar uma conta"),g=(0,r.createTextVNode)(" ou "),v=(0,r.createTextVNode)("recuperar senha"),y=(0,r.createTextVNode)(". "),k={key:2,class:"mb-0"},V=(0,r.createTextVNode)("Fazer login"),C=(0,r.createTextVNode)(" ou "),N=(0,r.createTextVNode)("criar conta"),B=(0,r.createTextVNode)(". ");var w=n(9038),x=n(2526);const S={components:{Head:w.Fb,Link:w.rU,AlertUi:x.Z},props:{auth:{},appName:{type:String,default:null},pageTitle:{type:String,default:null}},data:function(){return{}},mounted:function(){this.showFlashMessage()},updated:function(){this.showFlashMessage()},methods:{showFlashMessage:function(){var e=this.$page.props.flash;e?this.$refs.alert.add(e.message,e.variant):this.$refs.alert.clear()}}};const E=(0,n(3744).Z)(S,[["render",function(e,t,n,w,x,S){var E=(0,r.resolveComponent)("Head"),F=(0,r.resolveComponent)("AlertUi"),T=(0,r.resolveComponent)("Link");return(0,r.openBlock)(),(0,r.createElementBlock)(r.Fragment,null,[(0,r.createVNode)(E,{title:"".concat(n.appName," - ").concat(n.pageTitle)},null,8,["title"]),(0,r.createElementVNode)("div",o,[(0,r.createElementVNode)("div",a,[l,(0,r.createElementVNode)("div",i,[(0,r.createVNode)(F,{ref:"alert"},null,512),e.$page.props.pageTitle?((0,r.openBlock)(),(0,r.createElementBlock)("h1",c,(0,r.toDisplayString)(e.$page.props.pageTitle),1)):(0,r.createCommentVNode)("",!0),(0,r.createElementVNode)("div",s,[(0,r.renderSlot)(e.$slots,"default")]),(0,r.createElementVNode)("div",u,[["Auth/Register"].includes(e.$page.component)?((0,r.openBlock)(),(0,r.createElementBlock)("p",d,[m,(0,r.createVNode)(T,{href:e.$route("auth.login")},{default:(0,r.withCtx)((function(){return[p]})),_:1},8,["href"]),f])):(0,r.createCommentVNode)("",!0),["Auth/Login"].includes(e.$page.component)?((0,r.openBlock)(),(0,r.createElementBlock)("p",b,[(0,r.createVNode)(T,{href:e.$route("auth.register")},{default:(0,r.withCtx)((function(){return[h]})),_:1},8,["href"]),g,(0,r.createVNode)(T,{href:e.$route("auth.forget")},{default:(0,r.withCtx)((function(){return[v]})),_:1},8,["href"]),y])):(0,r.createCommentVNode)("",!0),["Auth/Password/Forget"].includes(e.$page.component)?((0,r.openBlock)(),(0,r.createElementBlock)("p",k,[(0,r.createVNode)(T,{href:e.$route("auth.login")},{default:(0,r.withCtx)((function(){return[V]})),_:1},8,["href"]),C,(0,r.createVNode)(T,{href:e.$route("auth.register")},{default:(0,r.withCtx)((function(){return[N]})),_:1},8,["href"]),B])):(0,r.createCommentVNode)("",!0)])])])])],64)}]])},6751:(e,t,n)=>{n.r(t),n.d(t,{default:()=>V});var r=n(821),o={class:"row"},a={class:"col-12 col-md-6 mb-4"},l={class:"col-12 col-md-6 mb-4"},i={class:"col-12 col-sm-7 col-md-6 mb-4"},c={class:"col-12 col-sm-5 col-md-6 mb-4"},s={class:"col-12 mb-4"},u={class:"col-12 col-md-6 mb-4"},d={class:"col-12 col-md-6 mb-4"},m={class:"col-12 text-center"};var p,f=n(3514),b=n(9038),h=n(3589),g=n(4531),v=n(5827);function y(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}const k=(y(p={components:{Head:b.Fb,ButtonUi:h.Z,InputForm:g.Z,SelectForm:v.Z},layout:function(e,t){return e(f.Z,(function(){return child}))}},"layout",f.Z),y(p,"setup",(function(){var e=(0,b.cI)({first_name:null,last_name:null,username:null,gender:"none",email:null,password:null,password_confirmation:null});return{form:e,submit:function(){e.post("/auth/register")}}})),y(p,"props",{user:Object}),p);const V=(0,n(3744).Z)(k,[["render",function(e,t,n,p,f,b){var h=(0,r.resolveComponent)("InputForm"),g=(0,r.resolveComponent)("SelectForm"),v=(0,r.resolveComponent)("ButtonUi");return(0,r.openBlock)(),(0,r.createElementBlock)("form",{onSubmit:t[7]||(t[7]=(0,r.withModifiers)((function(){return p.submit&&p.submit.apply(p,arguments)}),["prevent"]))},[(0,r.createElementVNode)("div",o,[(0,r.createElementVNode)("div",a,[(0,r.createVNode)(h,{label:"Nome",name:"first_name",modelValue:p.form.first_name,"onUpdate:modelValue":t[0]||(t[0]=function(e){return p.form.first_name=e}),"error-message":p.form.errors.first_name},null,8,["modelValue","error-message"])]),(0,r.createElementVNode)("div",l,[(0,r.createVNode)(h,{label:"Sobrenome",name:"last_name",modelValue:p.form.last_name,"onUpdate:modelValue":t[1]||(t[1]=function(e){return p.form.last_name=e}),"error-message":p.form.errors.last_name},null,8,["modelValue","error-message"])]),(0,r.createElementVNode)("div",i,[(0,r.createVNode)(h,{label:"Usuário",name:"username",modelValue:p.form.username,"onUpdate:modelValue":t[2]||(t[2]=function(e){return p.form.username=e}),"error-message":p.form.errors.username},null,8,["modelValue","error-message"])]),(0,r.createElementVNode)("div",c,[(0,r.createVNode)(g,{label:"Gênero",name:"gender",options:[{text:"Não definir",value:0},{text:"Masculino",value:1},{text:"Feminino",value:2}],modelValue:p.form.gender,"onUpdate:modelValue":t[3]||(t[3]=function(e){return p.form.gender=e}),"error-message":p.form.errors.gender},null,8,["modelValue","error-message"])]),(0,r.createElementVNode)("div",s,[(0,r.createVNode)(h,{label:"Email",type:"email",name:"email",modelValue:p.form.email,"onUpdate:modelValue":t[4]||(t[4]=function(e){return p.form.email=e}),"error-message":p.form.errors.email},null,8,["modelValue","error-message"])]),(0,r.createElementVNode)("div",u,[(0,r.createVNode)(h,{label:"Senha",type:"password",name:"password",modelValue:p.form.password,"onUpdate:modelValue":t[5]||(t[5]=function(e){return p.form.password=e}),"error-message":p.form.errors.password},null,8,["modelValue","error-message"])]),(0,r.createElementVNode)("div",d,[(0,r.createVNode)(h,{label:"Confirmar senha",type:"password",name:"password_confirmation",modelValue:p.form.password_confirmation,"onUpdate:modelValue":t[6]||(t[6]=function(e){return p.form.password_confirmation=e}),"error-message":p.form.errors.password_confirmation},null,8,["modelValue","error-message"])]),(0,r.createElementVNode)("div",m,[(0,r.createVNode)(v,{text:"Cadastrar",type:"submit",variant:"primary",icon:"checkLg",disabled:p.form.processing},null,8,["disabled"])])])],32)}]])}}]);