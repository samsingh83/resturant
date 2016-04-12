/*******************************************
@author : bastikikang 
@author email: basti@codemywebapps.com
@author website : http://codemywebapps.com
*******************************************/

var otable;
var epp_table;

jQuery(document).ready(function() {
	$ = jQuery.noConflict();	
	
	if( $('#table_list').is(':visible') ) {    	
    	table();    	
    }            
    
    if( $('#table_list2').is(':visible') ) {    	
    	table2();    	
    }            
        
	$("#table_list").on({	
	   mouseenter: function(){    	    
	    $(this).find(".options").show();
	  },
	   mouseleave: function () {	   
	    $(this).find(".options").hide();
	}},'tbody tr');
	    	
		
	$( document ).on( "click", ".row_del", function() {
        var ans=confirm(js_lang.deleteWarning);        
        if (ans){        	
        	row_delete( $(this).attr("rev"),$("#tbl").val(), $(this));        	
        	//alert("Sorry but delete functions is disbabled on the demo.");
        }
     });
	     
    $( "#chk_all" ).click(function() {    	    
    	if ( $(this).prop('checked') ){
    	 	$(".chk_child").prop("checked",true);
    	 } else {
    	 	$(".chk_child").prop("checked",false);
    	 }
	});
	
	$( ".btn_delete_table" ).click(function() {    	    	
		if ($(".chk_child:checked").length>=1){    
			var ans=confirm(js_lang.deleteWarning);
	        if (ans){	        		        
				old_action=$("#action").val(); 			
				$("#action").val("rowDeleteBulk"); 
				form_submit();
				$("#action").val(old_action); 
				//alert("Sorry but delete functions is disbabled on the demo.");
	        }
		} else {
			alert(js_lang.checkRowDelete);
		}	
	});
	
	
	var store_hours_format_value=$("#store_hours_format_value").val();	
	if ( store_hours_format_value==2){
		jQuery('.timepick').timepicker({        
        });
	} else {
	    jQuery('.timepick').timepicker({
	        showPeriod: true,
	        showLeadingZero: true
	    });
	}
    
    
    if( jQuery('#photo').is(':visible') ) {    	
       createUploader('photo','photo');
    } 
    
    if( jQuery('#storelogo').is(':visible') ) {    	
       createUploader('storelogo','storelogo');
    } 
    
    if( jQuery('#add_image').is(':visible') ) {    	
       createUploader('add_image','add_image');
    } 
         
    $( ".sortable" ).sortable({
       	update: function( event, ui ) {
       		//console.debug(ui);
       		sort_list( $(this) );
       	},
       	 change: function( event, ui ) {
       	 	//console.debug('d2');
       	 }
    }); 
                  
    var $gallery = $( ".dragable" );
    var $trash = $( ".featured_list" );
    
	$( "li", $gallery ).draggable({
		cancel: "a.ui-icon", // clicking an icon won't initiate dragging
		revert: "invalid", // when not dropped, the item will revert back to its initial position
		containment: "document",
		helper: "clone",
		cursor: "move"
	});
	
	$( "li", $trash ).draggable({
		cancel: "a.ui-icon", // clicking an icon won't initiate dragging
		revert: "invalid", // when not dropped, the item will revert back to its initial position
		containment: "document",
		helper: "clone",
		cursor: "move"
	});
	
	$trash.droppable({
		accept: ".dragable > li",
		activeClass: "ui-state-highlight",
		drop: function( event, ui ) {		    				   		   
		   deleteImage( ui.draggable );
		}
	});
		
	
	var recycle_icon = '';
	function deleteImage( $item ) {
		$item.fadeOut(function() {
			var $list = $( "ul", $trash ).length ?
			$( "ul", $trash ) :
			$( "<ul class='featured-item'/>" ).appendTo( $trash );
			$item.find( "a.ui-icon-trash" ).remove();
			$item.append( recycle_icon ).appendTo( $list ).fadeIn(function() {
				$item
				.animate({ width: "100px",width:"100px" })
				.find( "img" )
				.animate({ height: "80px",width:"100px" });
				save_featured();
			});
		});
	}
	
	 $gallery.droppable({
		accept: ".featured-item li",
		activeClass: "custom-state-active",
		drop: function( event, ui ) {		   
		   recycleImage( ui.draggable );
		}
	});
	
	var trash_icon='';
	function recycleImage($item)
	{	
	    $item.fadeOut(function() {
			$item
			.find( "a.ui-icon-refresh" )
			.remove()
			.end()
			.css( "width", "100px")
			.append( trash_icon )
			.find( "img" )
			.css( "height", "80px" )
			.end()
			.appendTo( $gallery )
			.fadeIn();
			save_featured();
		});
	}
		
	$( "#is_featured" ).click(function(){
		form_submit();
	});
           
		
	jQuery(".j_date").datepicker( { dateFormat: 'yy-mm-dd' , changeMonth: true, changeYear: true ,
	   yearRange: "-50:+0"
	});	  
	  

	//console.debug( $(window).height()  );
    $(".menu_left").css('height', $(document).height()-40);
    
    
    $( ".export_btn" ).click(function(){
    	 var params="action=export&rpt="+$(this).attr("rel")+"&tbl=export";
    	 window.open(ajax_url+"?"+params);
	});
    
});
/*END DOCU*/

function busy(e)
{
    if (e) {
        $('body').css('cursor', 'wait');	
    } else $('body').css('cursor', 'auto');
    
    if (e){
    	$.fancybox.showLoading();
    } else $.fancybox.hideLoading();
}

function scroll(id){
   if( $('#'+id).is(':visible') ) {	
      $('html,body').animate({scrollTop: $("#"+id).offset().top-100},'slow');
   }
}

function toogle(id , bool , caption)
{
    $('#'+id).attr("disabled", bool );
    $("#"+id).val(caption);
}

function rm_notices()
{
	$(".success").remove();		
    $(".error").remove();    
}

function clear_elements(ele) {	
    $("#"+ele).find(':input').each(function() {						    	
        switch(this.type) {
            case 'password':
            case 'select-multiple':
            case 'select-one':
            case 'text':
            case 'textarea':
                $(this).val('');
                break;
            case 'checkbox':
            case 'radio':
                this.checked = false;            
            
        }
   });
   
   $(".preview").remove();
}


$.validate({ 	
    //form : '#frm_category',
    //modules : 'security',
    onError : function() {      
    },
    onSuccess : function() {     
      form_submit();
      return false;
    }  
});

$.validate({ 	
    form : '#frm_order_status',    
    onError : function() {      
    },
    onSuccess : function() {     
      form_submit('frm_order_status');
      return false;
    }  
});

$.validate({ 	
    form : '#frm_email_test',    
    onError : function() {      
    },
    onSuccess : function() {     
      form_submit("frm_email_test");
      return false;
    }  
});

$.validate({ 	
    form : '#frm_sms_test',    
    onError : function() {      
    },
    onSuccess : function() {     
      form_submit("frm_sms_test");
      return false;
    }  
});

$.validate({ 	
    form : '#frm_add_text',    
    onError : function() {      
    },
    onSuccess : function() {     
      add_text();
      return false;
    }  
});


function table()
{		
	var params=$("#frm_table_list").serialize();
    epp_table = $('#table_list').dataTable({
	       "bProcessing": true, 
	       "bServerSide": false,
	       "sAjaxSource": ajax_url+"?"+params,	       
	       "aaSorting": [[ 0, "desc" ]],
	        "oLanguage": {
	       	  "sEmptyTable":    js_lang.tablet_1,
			    "sInfo":           js_lang.tablet_2,
			    "sInfoEmpty":      js_lang.tablet_3,
			    "sInfoFiltered":   js_lang.tablet_4,
			    "sInfoPostFix":    "",
			    "sInfoThousands":  ",",
			    "sLengthMenu":     js_lang.tablet_5,
			    "sLoadingRecords": js_lang.tablet_6,
			    "sProcessing":     js_lang.tablet_7,
			    "sSearch":         js_lang.tablet_8,
			    "sZeroRecords":    js_lang.tablet_9,
			    "oPaginate": {
			        "sFirst":    js_lang.tablet_10,
			        "sLast":     js_lang.tablet_11,
			        "sNext":     js_lang.tablet_12,
			        "sPrevious": js_lang.tablet_13
			    },
			    "oAria": {
			        "sSortAscending":  js_lang.tablet_14,
			        "sSortDescending": js_lang.tablet_15
			    }
	       }
    });		        
}

function table_reload()
{
	epp_table.fnReloadAjax(); 
}
   
function form_submit(formid)
{	
	rm_notices();
	if ( formid ){		
		var form_id=formid;
	} else {		
		var form_id=$("form").attr("id");
	}	
	var btn=$('#'+form_id+' input[type="submit"]');    
    var btn_cap=btn.val();
    btn.attr("disabled", true );
    btn.val("processing.");
    busy(true);
    
	var params=$("#"+form_id).serialize();	
	 $.ajax({    
        type: "POST",
        url: ajax_url,
        data: params,
        dataType: 'json',       
        success: function(data){ 
        	busy(false);  
        	btn.attr("disabled", false );
        	btn.val(btn_cap);
        	if (data.code==1){       
        		$("#"+form_id).before("<div class=\"success\">"+data.msg+"</div>"); 
        		        		
        		if (typeof $("#page_name").val() === "undefined") {        			    		
        		} else {        			
        			window.location.href=admin_url+"/"+$('#page_name').val()+"?id="+data.details+
        			"&msg="+data.msg;  
        		}
        		
        		if ( $("#clear").val()=="true"){
        			clear_elements(form_id);
        		}
        		if ($("#clear_tbl").val()=="clear_tbl"){
        			//clear_deleted_row();
        			table_reload();
        		}
        		if (form_id=="frm_login"){
        			$("#frm_login").hide();
        			window.location.href=admin_url+"/home";
        		}
        		if (form_id=="frm_install"){        			
        			window.location.href=admin_url;
        		}
        		
        		if (form_id=="frm_order_status"){        			
        			$('.change_status_pop').modal('hide');
        			table2_reload();
        		}
        		
        	} else {      
        		$("#"+form_id).before("<div class=\"error\">"+data.msg+"</div>");
        	}        	
        	scroll(form_id);
        }, 
        error: function(){	        	
        	btn.attr("disabled", false );
        	btn.val(btn_cap);
        	busy(false);
        	$("#"+form_id).before("<div class=\"error\">ERROR:</div>");
        }		
    });
}

function row_delete(id,tbl,object)
{		
	var form_id=$("form").attr("id");
	rm_notices();	
	busy(true);
	var params="action=rowDelete&tbl="+tbl+"&row_id="+id+"&whereid="+$("#whereid").val();	
	 $.ajax({    
        type: "POST",
        url: ajax_url,
        data: params,
        dataType: 'json',       
        success: function(data){
        	busy(false);
        	if (data.code==1){       
        		$("#"+form_id).before("<div class=\"success\">"+data.msg+"</div>");         		
        		tr=object.closest("tr");
                tr.fadeOut("slow");
        	} else {      
        		$("#"+form_id).before("<div class=\"error\">"+data.msg+"</div>");
        	}        	        	
        }, 
        error: function(){	        	        	
        	busy(false);
        	$("#"+form_id).before("<div class=\"error\">ERROR:</div>");
        }		
    });
}

function clear_deleted_row()
{		
	var tr='';
	$('.chk_child').each(function () {			
		if ( $(this).prop('checked') ){
			tr=$(this).closest("tr");
			tr.fadeOut("slow");
		}
	});
}

function photo(data)
{
	var img='';
	console.debug(data);
	$(".preview").show();
	img+="<img src=\""+upload_url+"/"+data.details.file+"\" alt=\"\" title=\"\">";
	img+="<input type=\"hidden\" name=\"photo\" value=\""+data.details.file+"\" >";
	img+="<p><a href=\"javascript:rm_preview();\">"+js_lang.removeFeatureImage+"</a></p>";
	$(".image_preview").html(img);
}

function storelogo(data)
{
	var img='';
	console.debug(data);
	$(".preview").show();
	img+="<img src=\""+upload_url+"/"+data.details.file+"\" alt=\"\" title=\"\">";
	img+="<input type=\"hidden\" name=\"photo\" value=\""+data.details.file+"\" >";
	img+="<p><a href=\"javascript:rm_preview();\">remove Logo</a></p>";
	$(".image_preview").html(img);
}

function rm_preview()
{
	$(".image_preview").html('');
}

function sort_list(obj)
{
	busy(true);
	//console.debug(obj.attr("data"));
	var list_data='';
	var list=obj.find("li");
	list.each(function(){		
		list_data+=$(this).attr("class")+",";
	});
	var data_key=obj.attr("data-key");
		
	var params="action=sortList&data="+obj.attr("data")+"&list_data="+list_data+"&data_key="+data_key;
	 $.ajax({    
        type: "POST",
        url: ajax_url,
        data: params,
        dataType: 'json',       
        success: function(data){
        	busy(false);
        }, 
        error: function(){	        	        	        	        
        	busy(false);
        }		
    });
	
}

function save_featured()
{
	busy(true);	
	var list_data='';
	var list=$(".featured_list").find("li");
	list.each(function(){		
		list_data+=$(this).attr("rel")+",";
	});	
	var params="action=saveFeatured&list_data="+list_data;
	 $.ajax({    
        type: "POST",
        url: ajax_url,
        data: params,
        dataType: 'json',       
        success: function(data){
        	busy(false);
        	if (data.code==2){
        		alert(data.msg);
        	}
        }, 
        error: function(){	        	        	        	        
        	busy(false);
        }		
    });
}

function sales_summary_reload()
{
	var params=$("#frm_table_list").serialize();
    /*epp_table = $('#table_list').dataTable({
	       "bProcessing": true, 
	       "bServerSide": false,
	       "sAjaxSource": ajax_url+"?"+params,	       
	       "aaSorting": [[ 0, "desc" ]]	       
    });		*/
	epp_table.fnReloadAjax(ajax_url+"?"+params); 
}

/********************************************
   START JQPLOT 
********************************************/

$(document).ready(function() {
	if( $('.chart').is(':visible') ) {	
	   load_totalsales_chart();	
	   load_total_sales_chart_by_item();
	}
	
	jQuery('.numeric_only').keyup(function () {     
      this.value = this.value.replace(/[^0-9\.]/g,'');
    });	
}); /*END DOCU*/

function load_totalsales_chart()
{
	$.jqplot.config.enablePlugins = true;
	var ajaxDataRenderer = function(url, plot, options) {
    var ret = null;
    $.ajax({    
      async: false,
      url: url,
      dataType:"json",
      success: function(data) {
        ret = data;
      }
    });
    return ret;
    };
    
    var jsonurl = ajax_url+"/?action=chartTotalSales&tbl=chart";    
          
    var plot1 = $.jqplot('total_sales_chart', jsonurl,{
     animate: true,
     title: js_lang.lastTotalSales ,
     seriesDefaults:{
            renderer:$.jqplot.BarRenderer,
            pointLabels: { show: true },
            rendererOptions:{  varyBarColor: true }
     },     
       axesDefaults: {
        tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
        tickOptions: {
          angle: -30,
          fontSize: '10pt',
        }
    },
     grid:{
    		drawGridLines: false,
    		gridLineColor: '#cccccc',
    		backgroundColor: "#eee",
    		drawBorder: false,
    		borderColor: '#999999',   
    		borderWidth: 1.0,
    		shadow: false
     },
     axes: {
            xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                //ticks: ticks
            }
     },
     dataRenderer: ajaxDataRenderer,
     dataRendererOptions: {
        unusedOptionalUrl: jsonurl,
     }
   });
}

function load_total_sales_chart_by_item()
{
	$.jqplot.config.enablePlugins = true;
	var ajaxDataRenderer = function(url, plot, options) {
    var ret = null;
    $.ajax({    
      async: false,
      url: url,
      dataType:"json",
      success: function(data) {
        ret = data;
      }
    });
    return ret;
    };
    
    var jsonurl = ajax_url+"/?action=chartByItem&tbl=chart";    
          
    var plot2 = $.jqplot('total_sales_chart_by_item', jsonurl,{
     animate: true,
     title: js_lang.lastItemSales,
     seriesDefaults:{
            renderer:$.jqplot.BarRenderer,
            pointLabels: { show: true },
            rendererOptions:{  varyBarColor: true }
     },
       axesDefaults: {
        tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
        tickOptions: {
          angle: -30,
          fontSize: '10pt',
        }
    },
     grid:{
    		drawGridLines: false,
    		gridLineColor: '#cccccc',
    		backgroundColor: "#eee",
    		drawBorder: false,
    		borderColor: '#999999',   
    		borderWidth: 1.0,
    		shadow: false
     },
     axes: {
            xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                //ticks: ticks
            }
     },
     dataRenderer: ajaxDataRenderer,
     dataRendererOptions: {
        unusedOptionalUrl: jsonurl,
     }
   });
}
/********************************************
   END JQPLOT 
********************************************/

/********************************************
   START UPDATES 6.12.14
********************************************/

function load_url(url)
{	
	busy(false);
	$(".post_full_wrapper .header").html("");
	$(".post_full_wrapper .loader").html('<div class="loader-wrapper"><i class="fa fa-spinner fa-spin"></i></div>');
	$(".post_full_wrapper a").css({ 'pointer-events' : 'none' });
	
	$('body').css('overflow','hidden'); 
	
	$.get( url, function( data ) {				
		$(".body-wrapper").hide();		
		
		var response = $('<div />').html(data);		 		 
		response.find(".buttons").remove();
        var content=response.find("#postContent").html();                
        var title=response.find(".full_post_header").html();   
                
                
        var window_height=$( document ).height();
        $(".post_full_content").css({"height":window_height+"px"});
        $(".post_full_content").html('<section id="post_page_wrap">'+content+'</section>').fadeIn("slow");
        $(".post_full_wrapper").css( {"height":"auto","position":"absolute"} ); 
        //$(".post_full_wrapper").css( {"height":window_height+"px","position":"absolute"} ); 
        $(".post_full_wrapper a").css({ 'pointer-events' : 'auto' });
        $(".post_full_wrapper .full_post_header").html(title);
        
        $(".post_full_wrapper .loader").html("");        
        busy(false);        
        $(".uk-button").hide();        
        $("#post_page_wrap .full_post_header").hide();        
        $("#post_page_wrap .required_text").hide();       
        $("#post_page_wrap p.bold").hide();  
        $(".submit_button").hide();
        
        scroll_to_class("post_full_content");        
        
        if ( $("#delivery_address_map").length >=1){			
        	$(".view_map").text("View Map");
			$(".view_map").show();
		} else {			
			$(".view_map").hide();
		}
		
		if ( $("#voucher_export_text").length >=1){			
			$(".export_to_excel").attr("rel","voucher_details");
			$(".export_to_excel").show();
		}	
        
    });
}

function scroll_to_class(id){
   if( $('.'+id).is(':visible') ) {	   	
      $('html,body').animate({scrollTop: $("."+id).offset().top-50},'slow');
   }
}

function animate_link(link)
{
	$( ".post_full_wrapper" ).show();
    	 $( ".post_full_wrapper" ).animate({		
		   width: "100%",		
		   }, 500, function() {				   			   			   	  		   			   	 		   
		 load_url(link);
	});       	
}

var new_order_notify;

$(document).ready(function() {
	
	//$(".view_receipt").on('click', function(e) {		
	$( document ).delegate( ".view_receipt", "click", function() {		
		var link=sites_url+"/admin/view-order/order_id/"+$(this).attr("data-id");		
		animate_link(link);
	});
	
				
	$(".full_nav_wrap a.back").on('click', function(e) {
		table2_reload();
		$('body').css('overflow','auto'); 
    	$(".body-wrapper").show();
    	$(".post_full_content").fadeOut("slow");
    	$(".post_full_wrapper").css( {"height":"100%","position":"fixed"} );     	
    	$( ".post_full_wrapper" ).animate({		
		   width: "0%",		
		   }, 1000, function() {
		   	 $(".post_full_content").html("");
		   	 $( ".post_full_wrapper" ).hide();		     
	     });    	 
    	e.preventDefault();   
	});    	
			
	$( document ).delegate( ".edit_status_order", "click", function() {
		var stats_id=$(this).attr("rel");
		var order_id=$(this).attr("data-id");			
		$(".success").remove();
		
		$("#order_status").val(stats_id);			
		$("#order_id").val(order_id);
		$('.change_status_pop').modal('show');
	});
			
	if( $('#frm_sms').is(':visible') ) { 
		reCount();		
		var sms_gateway_id = $("#sms_gateway_id:checked").val();
		console.debug(sms_gateway_id);
		if (typeof sms_gateway_id === "undefined") {			
			$('input[name=sms_gateway_id][value=twilio]').attr('checked', true); 			
			var sms_gateway_id = $("#sms_gateway_id:checked").val();
		}		
		get_sms_forms(sms_gateway_id);
	}	
	
	$(".sms_gateway_id").on('click', function(e) {
		get_sms_forms( $("#sms_gateway_id:checked").val() );
	});
		
	
	$(".email_test").on('click', function(e) {
		$("#email_test").val("");
		$(".error").remove();
		$(".success").remove();
		$('.send_email_test_pop').modal('show');
	});
	
	$( ".sortable_ads" ).sortable({
       	update: function( event, ui ) {       		
       		//sort_list( $(this) );
       	},
       	 change: function( event, ui ) {
       	 	//console.debug('d2');
       	 }
    }); 
    
    $("#add_text").on('click', function(e) {
    	$("#promo_id").val('');
    	$("#text_value").val('');
    	$("#text_font").val('');
    	$("#font_size").val('');
    	$("#font_padding").val('');
    	$("#font_color").val('');
    	$('.add_text_pop').modal('show');
    });
    
    
    if( $('.color_picker').is(':visible') ) {  
	    $('.color_picker').colpick({
		    layout:'hex',
			submit:0,
			colorScheme:'light',		
			onChange:function(hsb,hex,rgb,el,bySetColor) {
				$(el).css('border-color','#'+hex);					
				if(!bySetColor) $(el).val('#'+hex);			
			}
		}).keyup(function(){
			$(this).colpickSetColor(this.value);
	    });
    }
        
    $( document ).delegate( ".rm_text", "click", function() {    	
    	var parent=$(this).parent();
    	parent.remove();
    });
    
    if( $('.icheck').is(':visible') ) { 
	     $('.icheck').iCheck({
	       checkboxClass: 'icheckbox_minimal',
	       radioClass: 'iradio_flat'
	     });
    }
    
     
    if( $('.chosen').is(':visible') ) {     
     $(".chosen").chosen(); 
     $(".chosen").chosen({allow_single_deselect:true}); 
    } 
     
     
     $( document ).delegate( ".ads_list .fa-th-list", "click", function() {    	     	
     	var parent=$(this).parent();     	
     	var promo_id=parent.attr("id");
     	$("#promo_id").val(promo_id);
     	var val=parent.find("input").val();     	
     	var n = val.indexOf(",");      	     	
     	if ( n >=1){
     		var t=val.split(",");     		
     		$("#text_value").val(t[0]);
     		$("#text_font").val(t[1]);
     		$("#font_size").val(t[2]);
     		$("#font_padding").val(t[3]);
     		$("#font_color").val(t[4]);
     		$(".add_text_pop").modal("show");
     	}
     });	
     
     //get_new_order();	 
	 if ( $("#alert_notification").val()==1 ){	 	
	 	new_order_notify = setInterval(function(){get_new_order()}, 7000);
	 }
     
	 
	 $(".send_sms_test").on('click', function(e) {		
	 	var selected=$(".sms_gateway_id:checked").val();	 	
	 	if (typeof selected === "undefined") {  
	 		alert("Please select SMS gateway");
	 		return;
	 	}		 	
		$('.sms_test_pop').modal('show');
	});
	 
});/* END DOCU*/


/********************************************
   END UPDATES 6.12.14
********************************************/

function get_new_order()
{
	var params="action=getNewOrder";
	 $.ajax({    
        type: "POST",
        url: ajax_url,
        data: params,
        dataType: 'json',       
        success: function(data){      
        	if (data.code==1){        		        	
        		if( $('.uk-notify').is(':visible') ) {           			
        		} else {      
        			if ( $("#alert_sounds").val()=="1" ) {
        			    $("#jquery_jplayer_1").jPlayer("play");  			
        			}
        			$.UIkit.notify({
		       	   	   message : data.msg+" "+js_lang.NewOrderStatsMsg,
		       	   	   //status:"success"
		       	   	   //timeout :1500	       	   	
		       	    }); 	       	        
        		}
        	}
        }, 
        error: function(){        	
        }		
    });
}

function table2()
{		
	var params="action=recentOrder&tbl=order";
    otable = $('#table_list2').dataTable({
	       "bProcessing": true, 
	       "bServerSide": false,
	       "sAjaxSource": ajax_url+"?"+params,	       
	       "aaSorting": [[ 0, "desc" ]],
	       "oLanguage": {
	       	  "sEmptyTable":    js_lang.tablet_1,
			    "sInfo":           js_lang.tablet_2,
			    "sInfoEmpty":      js_lang.tablet_3,
			    "sInfoFiltered":   js_lang.tablet_4,
			    "sInfoPostFix":    "",
			    "sInfoThousands":  ",",
			    "sLengthMenu":     js_lang.tablet_5,
			    "sLoadingRecords": js_lang.tablet_6,
			    "sProcessing":     js_lang.tablet_7,
			    "sSearch":         js_lang.tablet_8,
			    "sZeroRecords":    js_lang.tablet_9,
			    "oPaginate": {
			        "sFirst":    js_lang.tablet_10,
			        "sLast":     js_lang.tablet_11,
			        "sNext":     js_lang.tablet_12,
			        "sPrevious": js_lang.tablet_13
			    },
			    "oAria": {
			        "sSortAscending":  js_lang.tablet_14,
			        "sSortDescending": js_lang.tablet_15
			    }
	       }
    });	    
}

function table2_reload()
{
	if (otable){
	    otable.fnReloadAjax(); 
	}
}

function get_sms_forms(gateway_id)
{
	
    var params="action=getSmsForms&gateway_id="+gateway_id;
    $(".form_sms_results").html('<i class="fa fa-spinner fa-spin"></i>');
	 $.ajax({    
        type: "POST",
        url: ajax_url,
        data: params,
        dataType: 'json',       
        success: function(data){      
        	$(".form_sms_results").html(data.msg);
        }, 
        error: function(){               	
        	$(".form_sms_results").html("");
        }		
    });	
}


function getChar(e){	
    var maxStr = 160;
    var textObj = document.getElementById("sms_notification_msg");
    var curStr = parseInt(maxStr-String(textObj.value).length);
    var KeyID = (window.event) ? event.keyCode : e.keyCode;	
	$(".sms_rem").html( maxStr-textObj.value.length + "/160");
}
function getCharDown(e){
	var textObj = document.getElementById("sms_notification_msg");	
	var KeyID = (window.event) ? event.keyCode : e.keyCode;
	if(textObj.value.length>=160 && KeyID!=8) return false;
	else return true;
}

function reCount()
{
	var maxStr = 160;
    var textObj = document.getElementById("sms_notification_msg");
    var curStr = parseInt(maxStr-String(textObj.value).length);
	$(".sms_rem").html( maxStr-textObj.value.length + "/160");
}

function add_text()
{
	var text;
	var options=$("#text_value").val()+",";
	options+=$("#text_font").val()+",";
	options+=$("#font_size").val()+",";
	options+=$("#font_padding").val()+",";
	options+=$("#font_color").val();
	
	if ( $("#promo_id").val()=="" ){
		
	} else {
		$("#"+$("#promo_id").val()).remove();
	}
	
	text="<li id=\""+$("#promo_id").val()+"\"><input name=\"add_text[]\" type=\"hidden\" value=\""+options+"\"><i class=\"fa fa-th-list\"></i>  "+ $("#text_value").val() +"<a href=\"javascript:;\" class=\"rm_text\" ><i class=\"fa fa-times-circle\"></i></a></li>";
	$(".sortable_ads").append(text);
	$(".add_text_pop").modal("hide");
}

function add_image(data)
{	
	var options=data.details.file;
	text="<li><input name=\"add_text[]\" type=\"hidden\" value=\""+options+"\"><i class=\"fa fa-th-list\"></i>  "+ options +"<a href=\"javascript:;\" class=\"rm_text\" ><i class=\"fa fa-times-circle\"></i></a></li>";
	$(".sortable_ads").append(text);
}

$(document).ready(function(){  	  	
	
	if ( $("#alert_sounds").val()=="1" ) {		
	    $("#jquery_jplayer_1").jPlayer({
		    ready: function () {
		       $(this).jPlayer("setMedia", {
		          mp3: sites_url+"/assets/sound/notify.mp3"	          	         
		       });
		    },
		    swfPath: sites_url+"/assets/vendor/jQuery.jPlayer.2.6.0/",
		    supplied: "m4a,mp3"
	    });        
	}
			
    $( document ).delegate( ".print_element", "click", function() {    	     		  
      //$('.receipt_main_wrapper').printElement();
      window.print();
    });	
        
    var selected_menu=$("#layout_menu:checked").val();
    pre_collapsed_menu_selection(selected_menu);
               
    $("input[name=layout_menu]").on('ifChecked', function(event){     
       pre_collapsed_menu_selection($(this).val());
    });
    
    /*********************************
       PAGES MENU 
    **********************************/
    $( ".sortable_pages" ).sortable({
       	update: function( event, ui ) {       		
       		sort_list( $(this) );
       	},
       	 change: function( event, ui ) {
       	 	//console.debug('d2');
       	 }
    }); 
    
    
    $( document ).on( "click", ".select_all", function() {
    	$(".user_access").attr("checked",true);
    });
    	
}); /*END DOCU*/

function pre_collapsed_menu_selection(selected_menu)
{	    
    if ( selected_menu == 7 || selected_menu == 8 || selected_menu == 9 || selected_menu == 3 || selected_menu == 5){
    	$(".collapse_wrap").show();
    } else {
    	$(".collapse_wrap").hide();
    }
}


/***********************************************
GOOGLE MAP
************************************************/
var geocoder;
var map;
function initialize(latitude,longitude,building_name) {
 geocoder = new google.maps.Geocoder(); 
 if (!latitude){ 	 
     var latlng = new google.maps.LatLng(-34.397, 150.644);	
 } else { 	
 	 /*alert(latitude);
 	 alert(longitude);*/
 	 var latlng = new google.maps.LatLng(latitude,longitude);
 }  
 var mapOptions = {
   scrollwheel: false,	
   zoom: 15,
   center: latlng,
   mapTypeId: google.maps.MapTypeId.ROADMAP
 }
 map = new google.maps.Map(document.getElementById('areaMap'), mapOptions);
 
 
 if (latitude){ 	
 	var marker = new google.maps.Marker({
      position: latlng,
      map: map,
      title: building_name
    }); 	
 }
 
}

function codeAddress(address) {	
  var iconBase = 'https://maps.google.com/mapfiles/kml/shapes/';
  //var address = document.getElementById('address').value;
  geocoder.geocode( { 'address': address}, function(results, status) {
  if (status == google.maps.GeocoderStatus.OK) {
    map.setCenter(results[0].geometry.location);
    var marker = new google.maps.Marker({    	
        map: map,
        position: results[0].geometry.location
        /*icon: iconBase + 'schools_maps.png',
        shadow: iconBase + 'schools_maps.shadow.png'*/

    });
  } else {
    //jAlert('Geocode was not successful for the following reason: ' + status,jTitle);
  }
});
}

$(document).ready(function(){  	  		
			
	$( document ).on( "click", ".view_map", function() {		
		var current_text=$(this).text();										
		if ( current_text=="View Receipt"){
			$(".map_wrapper").hide();
			$(".receipt_wrapper").show();
			$(".print_wrap").show();
			$(this).text("View Map")
		} else {
			$(".map_wrapper").show();
			$(".receipt_wrapper").hide();					
			$(".print_wrap").hide();				
			$(this).text("View Receipt")	
			if ( $("#delivery_address_map").length >=1){							
				var delivery_address_map=$("#delivery_address_map").val();
				initialize(); 
				codeAddress(delivery_address_map);
		    }
		}
	});
	
	
    $( document ).delegate( ".view_vouchers", "click", function() {		
		var link=sites_url+"/admin/voucherdetails/id/"+$(this).attr("data-id");		
		animate_link(link);
	});
		
	$( document ).delegate( ".export_to_excel", "click", function() {		
    	 var params="action=export&rpt="+$(this).attr("rel")+"&tbl=export";
    	 window.open(ajax_url+"?"+params);
	});
	
	if( $('#user_type').is(':visible') ) {
		if ( $("#user_type").val() =="admin"){
			$(".user_access_ul").hide();
		} else {
			$(".user_access_ul").show();
		}
	}			
	
	$( document ).delegate( "#user_type", "change", function() {			
		if ( $(this).val() =="admin"){
			$(".user_access_ul").hide();
		} else {
			$(".user_access_ul").show();
		}
	});	
	
});
/***********************************************
END GOOGLE MAP
************************************************/