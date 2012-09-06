var userList = new Class({
	
	initialize: function(container,toolbox) {
		
		if (typeOf(container)!='element') return;
		this.element = container.getElement('ul');
		this.all = this.element.getElements('li'); //берём все пользовательские штучки	
		if (typeOf(toolbox)=='element') this.toolbox = toolbox;
		this.toolbox.butAll = toolbox.getElement('a#l-all');
		this.toolbox.butAll.callbackObject = this;
		this.toolbox.butOnline = toolbox.getElement('a#l-online');
		this.toolbox.butOnline.callbackObject = this;
		if (this.element.getElements('li.online').length == 0) {this.toolbox.setStyle('display','none');this.noToolBox = true;} else this.noToolBox = false;
		
		this.toolbox.butAll.addEvent('click',function(e){
			this.callbackObject.setAll();
			//e.preventDefault();
			return false;
		});

		this.toolbox.butOnline.addEvent('click',function(e){
			this.callbackObject.setOnline();
			//e.preventDefault();
			return false;
		});
		
		//если всех больше, чем 20 - только онлайн
		if (this.all.length > 20 && !this.noToolBox) {
			this.setOnline();
		}
		
		this.busy = false;
	},
	
	unbusy: function() {
		this.busy = false;
	},
	
	setAll: function() {
		if (this.busy != true) this.busy = true; else return false;
		this.toolbox.butAll.morph({'color':'#cc226a','border-color':'#cc226a'});
		this.toolbox.butOnline.morph({'color':'#287ccc','border-color':'#287ccc'});
		this.all.each(function(e){
			e.setStyle('display','block');
		});		
		this.unbusy.delay(100,this);
	},

	setOnline: function() {
		if (this.busy != true) this.busy = true; else return false;
		this.toolbox.butAll.morph({'color':'#287ccc','border-color':'#287ccc'});
		this.toolbox.butOnline.morph({'color':'#cc226a','border-color':'#cc226a'});
		this.all.each(function(e){
			if (e.hasClass('offline')) e.setStyle('display','none');
		});
		this.unbusy.delay(100,this);			
	}
	
});

window.addEvent('domready', function() {
$$('.twitter-tweet-r   endered').each(function(el){
el.setStyle('clear','none');
});
	Shadowbox.init({
    handleOversize: "drag",
    modal: true
	});
	if ($('reg-form')||$('login-form')) {
		var reg_form = $('reg-form');
		var login_form = $('login-form');
		var reg_opener = $('reg-opener');
		var pass = $('pass');
		var rtpass = $('rtpass');
		var rt_pass_error = $('rt-pass-error');
		if(reg_form.getStyle('display')=='block'){
			reg_opener.dispose();
			var reg_header = new Element('div', {
			id: 'reg-header'
			});
			reg_header.appendText('Регистрация:').inject(reg_form,'top')
		}
		reg_opener.addEvent('click', function() {
			reg_form.setStyle('display','block');
			reg_opener.dispose();
			var reg_header = new Element('div', {
			id: 'reg-header'
			});
			reg_header.appendText('Регистрация:').inject(reg_form,'top');
		});
			reg_form.addEvent('submit',function(){
			return false;
			});
		rtpass.addEvent('blur', function() {
			if(pass.get('value')!=rtpass.get('value')){
			rt_pass_error.setStyle('display','block');
			}else{
				rt_pass_error.setStyle('display','none');
				reg_form.removeEvents('submit');
			}
		});
	};
	
	var uList = new userList($('users'),$$('p.l-filter').getLast());
	
});
