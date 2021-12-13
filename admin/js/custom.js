function mergeArray ( a,b ){
    var result = new Array();
    for(i=0;i<a.length;i++){
    		for(j=0;j<b.length;j++){
    			if(a[i] == b[j]){
    				result.push(a[i]);
    				break;
    			}
    		}
    }
    return result;
}
var productmodule = [
		'#producttitle','#productkeywords','#productdepict','#productcat',
		'input[type=checkbox][name=connect_product]',
		'input[type=checkbox][name=connect_menu]',
		'input[type=checkbox][name=customcss]',
		'input[type=checkbox][name=barsid]',
		'input[name=sort]'
		];
var newsmodule = [
		'#producttitle','#productkeywords','#productdepict','#productcat',
		'input[type=checkbox][name=connect_menu]',
		'input[type=checkbox][name=connect_sec_menu]',
		'select[name=connect_sec_menu_pid]',
		'input[type=checkbox][name=customcss]',
		'input[type=checkbox][name=barsid]',
		'input[name=sort]'
		];
var leavemodule = [
		'#producttitle','#productkeywords','#productdepict','#productcat',
		'input[type=checkbox][name=connect_menu]',
		'input[type=checkbox][name=connect_sec_menu]',
		'select[name=connect_sec_menu_pid]',
		'input[type=checkbox][name=customcss]',
		'input[type=checkbox][name=barsid]',
		'input[name=sort]'
		];
var extarr = [
					"#exturl","#producttitle",
					"input[type=checkbox][name=connect_menu]",
					"input[type=checkbox][name=connect_sec_menu]",
					'select[name=connect_sec_menu_pid]',
					"input[name=sort]"
				  ];
var connect_menu_arr = [
				'#producttitle','#productkeywords','#productdepict','#productcat','#exturl',
				'input[type=checkbox][name=connect_product]',
				'input[type=checkbox][name=connect_menu]',
				'input[type=checkbox][name=customcss]',
				'input[type=checkbox][name=barsid]',
				'input[name=sort]'
				];
var connect_sec_menu_arr = [
				'#producttitle','#productkeywords','#productdepict','#productcat','#exturl',
				'input[type=checkbox][name=connect_sec_menu]',
				'select[name=connect_sec_menu_pid]',
				'input[type=checkbox][name=customcss]',
				'input[type=checkbox][name=barsid]',
				'input[name=sort]'
				];
var connect_news_arr = [
				'#producttitle','#productkeywords','#productdepict',
				'input[type=checkbox][name=connect_news]',
				'input[type=checkbox][name=customcss]',
				'select[name=connect_sec_news_cat]',
				'input[type=checkbox][name=barsid]',
				'input[name=sort]'
				];
function initdisabled(){
	$("#sampleform input[type=text],#sampleform input[type=checkbox],#sampleform select").attr("disabled", "disabled"); 
	if($("#productnickname").length>0){
		$("#productnickname").removeAttr("disabled");
	}
}
function initabled(){
	$("#sampleform input[type=text],#sampleform input[type=checkbox],#productcat").removeAttr("disabled");
}
function enabled(eidarr){
	$.each(eidarr,function(m,n){
		if(n == 'select[name=connect_sec_menu_pid]'){
			if($("input[type=checkbox][name=connect_sec_menu]").is(':checked')){
				$("select[name=connect_sec_menu_pid]").removeAttr("disabled");
			}
		}else if(n == 'select[name=connect_sec_news_cat]'){
			if($("input[type=checkbox][name=connect_news]").is(':checked')){
				$("select[name=connect_sec_news_cat]").removeAttr("disabled");
			}
		}else if(n == 'input[type=checkbox][name=connect_product]'){
			if($("#productcat").val()=='product_module.php'){
				$("input[type=checkbox][name=connect_product]").removeAttr("disabled");
			}
		}else{
			$(n).removeAttr("disabled");
		}
	})
}
var extfunc = function(){
	initdisabled();
	if($("#exturl").val().length>0){
		if($("input[type=checkbox][name=connect_menu]").is(':checked')){
			enabled(mergeArray(extarr,connect_menu_arr));
		}else if($("input[type=checkbox][name=connect_sec_menu]").is(':checked')){
			enabled(mergeArray(extarr,connect_sec_menu_arr));
		}else{
			enabled(extarr);
		}
	}else{
		if($("input[type=checkbox][name=connect_menu]").is(':checked')){
			enabled(connect_menu_arr);
		}else if($("input[type=checkbox][name=connect_sec_menu]").is(':checked')){
			enabled(connect_sec_menu_arr);
		}else{
			initabled();
		}
	}
}
var pcatfunc = function(){
	var pcatval = $("#productcat").val();
	initdisabled();
	if(pcatval=='product_module.php'){
		if($("input[type=checkbox][name=connect_menu]").is(':checked')){
			enabled(mergeArray(productmodule,connect_menu_arr));
		}else{
			enabled(productmodule);
		}
	}else if(pcatval=='news_module.php'){
		if($("input[type=checkbox][name=connect_menu]").is(':checked')){
			enabled(mergeArray(newsmodule,connect_menu_arr));
		}else if($("input[type=checkbox][name=connect_sec_menu]").is(':checked')){
			enabled(mergeArray(newsmodule,connect_sec_menu_arr));
		}else{
			enabled(newsmodule);
		}
	}else if(pcatval=='leave_module.php'){
		if($("input[type=checkbox][name=connect_menu]").is(':checked')){
			enabled(mergeArray(leavemodule,connect_menu_arr));
		}else if($("input[type=checkbox][name=connect_sec_menu]").is(':checked')){
			enabled(mergeArray(leavemodule,connect_sec_menu_arr));
		}else{
			enabled(leavemodule);
		}
	}else if($("#exturl").val().length>0){
		if($("input[type=checkbox][name=connect_menu]").is(':checked')){
			enabled(mergeArray(extarr,connect_menu_arr));
		}else if($("input[type=checkbox][name=connect_sec_menu]").is(':checked')){
			enabled(mergeArray(extarr,connect_sec_menu_arr));
		}else{
			enabled(extarr);
		}
	}else{
		if($("input[type=checkbox][name=connect_menu]").is(':checked')){
			enabled(connect_menu_arr);
		}else if($("input[type=checkbox][name=connect_sec_menu]").is(':checked')){
			enabled(connect_sec_menu_arr);
		}else if($("input[type=checkbox][name=connect_news]").is(':checked')){
			enabled(connect_news_arr);
		}else{
			initabled();
		}
	}
}
$(document).ready(function(){
	pcatfunc();
	$("#exturl").keyup(function(){
		extfunc();
	})
	$("#productcat").change(function(){
		pcatfunc();
	})
	$("input[type=checkbox][name=connect_menu]").change(function(){
		pcatfunc();
	})
	$("input[type=checkbox][name=connect_sec_menu]").change(function(){
		pcatfunc();
		if(!$(this).is(':checked')){
			$('select[name=connect_sec_menu_pid]').val(0);
		}
	})
	$("input[type=checkbox][name=connect_news]").change(function(){
		pcatfunc();
		if(!$(this).is(':checked')){
			$('select[name=connect_sec_news_cat]').val(0);
		}
	})
})