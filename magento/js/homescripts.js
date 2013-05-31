   /**
* Javascript, JQuery 
* 
* 
* Licensed under the MIT license.
* Copyright 2013 Zaria Ruiz
* https://github.com/zruiz
*/

// popup
	function popupHome(popupWidth, popupHeight)
    {

	  if(readCookie('home') !== null) {
		// do nothing
	  }
	  else {

		var content = '<div style="text-align:right"> <a href="javascript:TINY.box.hide()" style="text-decoration:none"><b style="color:black;font-size:9px;">No Thank You X</b></a></div><div style="margin-top:0px; width:450px; height:525px; background-color:white"><a href="http://www.gothamcigars.com/cao-concert-greatest-hits-sampler.html"><img src="/images/popup/CAO_Concert_Greatest_Hits_Samplert_Pop_HP.jpg" alt="CAO Concert Greatest Hits Sampler" style="border:none; width:450; height: 525"/></a></div>';
		TINY.box.show(content, 0, popupWidth, popupHeight, 0);
		createCookie('home',1,3);
	  }

    }
	
	function popupCart(popupWidth, popupHeight)
    {

	  if(readCookie('cart') !== null) {
		// do nothing
	  }
	  else {

		var content = '<div style="margin-top:0px; width:450px; height:525px; background-color:white"><a href="http://www.gothamcigars.com/checkout/cart/add/product/2258/qty/1"><img src="/images/popup/Alec_Bradley_Black_Market_Robusto_5pack_Pop_HP.jpg" alt="Alec Bradley Black Market Robusto Cigars 5 Pack" style="border:none; width:450; height: 525" usemap="#Map"/></a> <map name="Map" id="Map"><area shape="rect" coords="3,550,150,450" href="javascript:TINY.box.hide()"/></map></div>';
		TINY.box.show(content, 0, popupWidth, popupHeight, 0);
		createCookie('cart',1,3);
	  }

    }
	
    function popupOpen(popupUrl, popupWidth, popupHeight)
    {
	   
      var content = '<div style="text-align:right"> <a href="javascript:TINY.box.hide()" style="text-decoration:none"><b style="color:#990000;">Close X</b></a></div><p style="color:green; font-weight:bold;text-align:center;display:none;"></p><iframe id="frameTiny" src="' + popupUrl + '" style="border:none; width:650px; height: 470px;"></iframe>';
      TINY.box.show(content, 0, popupWidth, popupHeight, 0);
      createCookie('email',1,300000);
	  
    }
	
	function popupEmail(popupUrl, popupWidth, popupHeight)
    {
	   if(readCookie('email') !== null) {
    // do nothing
      }
       else {

      var content = '<div style="text-align:right"> <a href="javascript:TINY.box.hide();javascript:popupClose()" style="text-decoration:none"><b style="color:#990000;">No Thank You</b></a></div><p style="color:green; font-weight:bold;text-align:center;display:none;"></p><iframe id="frameTiny" src="' + popupUrl + '" style="border:none; width:640px; height: 470px;"></iframe>';
      TINY.box.show(content, 0, popupWidth, popupHeight, 0);
      createCookie('email',1,3000000);
	
    }
	
    }
	
	function popupClose()
	{
	   createCookie('email',1,3000000);
	}

// home slides	
var slide_open = false;

jQuery(document).ready(function(){
	
	jQuery(".slide").click(function(){
		jQuery("#panel").slideToggle("slow");
		jQuery(this).toggleClass("active");
		if(slide_open) {
			jQuery("#slide_title").html("Free Deals You Don't Want To Miss - [click to open]");
			slide_open = false;
		}
		else {
			jQuery("#slide_title").html("Free Deals You Don't Want To Miss - [click to close]");
			slide_open = true;
		}
		return false;
	});
	
	
	jQuery.featureList(
		jQuery("#tabs li a"),
		jQuery("#output li"), {
			start_item: 0,
			transition_interval: 5000					
		}
	);	
	
	
	//function show() { document.getElementById("promo_code").style.visibility = "visible";}
	
	
	// popup
	if(readCookie('fb_like_7') !== null) {
		// do nothing
	}
	else {
		jQuery('#popup').slideDown();
		jQuery('#like_btn').click(function() { jQuery('#promo_code').show(2000); });
		//jQuery('#popup #like_btn').click(function() { jQuery('#promo_code').show(2000); });  
		//jQuery('#like').click(function() { jQuery('#promo_code').show(2000); }); 
		jQuery('#popup #close_btn').click(function(e) { e.preventDefault(); jQuery('#popup').hide(); });
		createCookie('fb_like_7',1,2);				
	}
	 
});

function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function eraseCookie(name) {
	createCookie(name,"",-1);
}

function redeem()
     {
	   var $j = jQuery.noConflict();
	   if($j('.redeem').length>0){
	   theCode = document.getElementById('redeem').value.toUpperCase();
	   setCodeLiving(theCode);
	   } else {
	   }
	 }
	 
function setCodeLiving(theCode)
	{
	   var $j = jQuery.noConflict();
	   
	   var msg = $j.ajax({type: "GET", url: "/script.php?coupon="+theCode, async: false}).responseText;
	   var msg1 = $j.ajax({type: "GET", url: "/script_gc.php?coupon="+theCode, async: false}).responseText;
	   var msg2 = $j.ajax({type: "GET", url: "/script2.php?coupon="+theCode, async: false}).responseText;
	   
	   if($j('.redeem').length>0){$j('.redeem').remove();}
	   if($j('.living_set').length>0){$j('.living_set').html('Validating...Please wait');}else{$j('<div class="living_set">Validating...Please wait</div>').prependTo('.living');}
	   if(msg != theCode && msg1 != theCode && msg2 != theCode){
        setTimeout(function(){$j('.living_set').html('Incorrect coupon');},2000);
	    setTimeout(function(){$j('.living_set').remove();$j('<input type="text" id="redeem" name="redeem" value="" class="redeem" />').prependTo('.living');},4000);
	   }else if(msg2 == theCode){
        setTimeout(function(){$j('.living_set').html('Coupon was already redeemed');},2000);
	    setTimeout(function(){$j('.living_set').remove();$j('<input type="text" id="redeem" name="redeem" value="" class="redeem" />').prependTo('.living');},4000);
	   }else if(msg == theCode &&  msg2 != theCode){
	     $j.ajax({
	     url:'/checkout/cart/add/product/2146/qty/1',
		 type:'POST',
		 success:function(callback){
	      //if(response){
		     setTimeout(function(){$j('.living_set').html('Coupon accepted. Click checkout button to redeem.');},2000);
			 $j('.gr_button').addClass('gr_checkout').removeClass('gr_button');
			 $j('.gr_checkout').live('click',function()
			 {
			  window.location='http://www.gothamcigars.com/'+theCode;
			});
           //console.log(response);
		  //}
	     },
	     error:function(xhr,status,errorthrown){  
		 setTimeout(function(){$j('.living_set').html('Error validating coupon. Please try again');},2000);
	     setTimeout(function(){$j('.living_set').remove();$j('<input type="text" id="redeem" name="redeem" value="" class="redeem" />').prependTo('.living');},4000);
		 window.location='https://www.gothamcigars.com/livingsocial';
		 }});
	    
	  }
	  else if(msg1 == theCode &&  msg2 != theCode){
	     $j.ajax({
	     url:'/checkout/cart',
		 type:'POST',
		 success:function(callback){
	      //if(response){
		     setTimeout(function(){$j('.living_set').html('Coupon accepted. Click checkout button to redeem.');},2000);
			 $j('.gr_button').addClass('gr_checkout').removeClass('gr_button');
			 $j('.gr_checkout').live('click',function()
			 {
			  window.location='http://www.gothamcigars.com/'+theCode;
			});
           //console.log(response);
		  //}
	     },
	     error:function(xhr,status,errorthrown){  
		 setTimeout(function(){$j('.living_set').html('Error validating coupon. Please try again');},2000);
	     setTimeout(function(){$j('.living_set').remove();$j('<input type="text" id="redeem" name="redeem" value="" class="redeem" />').prependTo('.living');},4000);
		 window.location='https://www.gothamcigars.com/livingsocial';
		 }});
	    
	  }
	}	 
	
function redeemGroupon()
     {
	   var $j = jQuery.noConflict();
	   if($j('.redeem').length>0){
	   theCode = document.getElementById('redeem').value.toUpperCase();
	   setCodeGroupon(theCode);
	   } else {
	   }
	 }
	 
function setCodeGroupon(theCode)
	{
	   var $j = jQuery.noConflict();
	   
	   var msg = $j.ajax({type: "GET", url: "/script_gr_offer1.php?coupon="+theCode, async: false}).responseText;
	   var msg1 = $j.ajax({type: "GET", url: "/script_gr_offer2.php?coupon="+theCode, async: false}).responseText;
	   var msg2 = $j.ajax({type: "GET", url: "/script2_gr.php?coupon="+theCode, async: false}).responseText;
	   
	   if($j('.redeem').length>0){$j('.redeem').remove();}
	   if($j('.groupon_set').length>0){$j('.groupon_set').html('Validating...Please wait');}else{$j('<div class="groupon_set">Validating...Please wait</div>').prependTo('.groupon');}
	   if(msg != theCode && msg1 != theCode && msg2 != theCode){
        setTimeout(function(){$j('.groupon_set').html('Incorrect coupon');},2000);
	    setTimeout(function(){$j('.groupon_set').remove();$j('<input type="text" id="redeem" name="redeem" value="" class="redeem" />').prependTo('.groupon');},4000);
	   }else if(msg2 == theCode){
        setTimeout(function(){$j('.groupon_set').html('Coupon was already redeemed');},2000);
	    setTimeout(function(){$j('.groupon_set').remove();$j('<input type="text" id="redeem" name="redeem" value="" class="redeem" />').prependTo('.groupon');},4000);
	   }else if(msg == theCode &&  msg2 != theCode){
	     $j.ajax({
	     url:'/checkout/cart/add/product/2059/qty/1',
		 type:'POST',
		 success:function(callback){
	      //if(response){
		     setTimeout(function(){$j('.groupon_set').html('Coupon accepted. Click checkout button to redeem.');},2000);
			 $j('.gr_button').addClass('gr_checkout').removeClass('gr_button');
			 $j('.gr_checkout').live('click',function()
			 {
			  window.location='http://www.gothamcigars.com/'+theCode;
			});
           //console.log(response);
		  //}
	     },
	     error:function(xhr,status,errorthrown){  
		 setTimeout(function(){$j('.groupon_set').html('Error validating coupon. Please try again');},2000);
	     setTimeout(function(){$j('.groupon_set').remove();$j('<input type="text" id="redeem" name="redeem" value="" class="redeem" />').prependTo('.groupon');},4000);
		 window.location='https://www.gothamcigars.com/groupon';
		 }});
	    
	  }
	  else if(msg1 == theCode &&  msg2 != theCode){
	     $j.ajax({
	     url:'/checkout/cart/add/product/2227/qty/1',
		 type:'POST',
		 success:function(callback){
	      //if(response){
		     setTimeout(function(){$j('.groupon_set').html('Coupon accepted. Click checkout button to redeem.');},2000);
			 $j('.gr_button').addClass('gr_checkout').removeClass('gr_button');
			 $j('.gr_checkout').live('click',function()
			 {
			  window.location='http://www.gothamcigars.com/'+theCode;
			});
           //console.log(response);
		  //}
	     },
	     error:function(xhr,status,errorthrown){  
		 setTimeout(function(){$j('.groupon_set').html('Error validating coupon. Please try again');},2000);
	     setTimeout(function(){$j('.groupon_set').remove();$j('<input type="text" id="redeem" name="redeem" value="" class="redeem" />').prependTo('.groupon');},4000);
		 window.location='https://www.gothamcigars.com/groupon';
		 }});
	    
	  }
	}	 