define(function(require,exports,module){
	
	require('../lib/jquery/jquery-1.10.1.min.js');
	
	function Tab(container){
		this.container = $(container);
		this.btn = this.container.children('.tab').find('a');
	}
	
	module.exports = Tab;
	
	Tab.prototype.render = function(){
		this._tab();
	}
	
	Tab.prototype._tab = function(){
		var btn = this.btn;
		var container = this.container;
		
		$(btn).on('click',function(){
			$(this).addClass('on').siblings().removeClass('on');
			var index = $(this).index();
			
			$(container).find('.content>ul>li').hide();
			$(container).find('.content>ul>li').eq(index).show();
		});
		return this;
	}
})