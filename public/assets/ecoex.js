$(function() {
    
});
var base_url = 'http://localhost/ecoex_portaldev/ecoex-app-portal/';
//var base_url = 'https://ecoex2.keylines.net.in/';
$(".changePassword").submit(function (e) {
	e.preventDefault();
	let formAction = $(this).attr('action');
    let flag = commonFormChecking(true, 'requiredCheckChangePassword');
    if (flag) {
		//flag = checkPassword('regPassword', 'regCnfPassword');
		if (flag) {
        	var formData = new FormData(this);
			$.ajax({
				type: "POST",
				url: base_url + formAction,
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "JSON",
				beforeSend: function () {
					$(".changePassword").loading();
				},
				success: function (res) {
					$(".changePassword").loading("stop");
					if(res.status){
						$('.changePassword').trigger("reset");
						swalAlert(res.message, 'success', 5000);
					}else{
						$('.changePassword').trigger("reset");
						swalAlert(res.message, 'warning', 5000);						
					}
				},
			});
		}
    }
});
$(".updateProfile").submit(function (e) {
	e.preventDefault();
	let formAction = $(this).attr('action');
    let flag = commonFormChecking(true, 'requiredCheckProfile');
    if (flag) {		
		if (flag) {
   			var formData = new FormData(this);
			$.ajax({
				type: "POST",
				url: base_url + formAction,
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "JSON",
				beforeSend: function () {
					$(".updateProfile").loading();
				},
				success: function (res) {
					$(".updateProfile").loading("stop");
					if(res.status){						
						swalAlert(res.message, 'success', 5000);
					}else{						
						swalAlert(res.message, 'warning', 5000);						
					}
				},
			});
		}
    }
});
$('.visibility').click(function(){
	let inventoryId 	= $(this).attr('data-id');
	let visibilityVal 	= $(this).attr('data-visibility');
	let link 			= $(this).attr('data-link');
	let formAction 		= $(this).attr('data-action');
	$.ajax({
			type: "POST",
			url: base_url + formAction,
			data: {
				inventoryId 	: inventoryId,
				visibilityVal 	: visibilityVal,
				link 			: link,
			},
			dataType: "JSON",
			beforeSend: function () {
				$(".visibility").loading();
			},
			success: function (res) {
				$(".visibility").loading("stop");
				if(res.status){						
					swalAlertThenRedirect(res.message, 'success', base_url + res.response.link);
				}else{						
					swalAlert(res.message, 'warning', 5000);						
				}
			},
	});
});
$("#submitInquiry").submit(function (e) {
	e.preventDefault();
	let formAction = $(this).attr('action');
    let flag = commonFormChecking(true, 'requiredCheckInquiry');
    if (flag) {		
		if (flag) {
   			var formData = new FormData(this);
			$.ajax({
				type: "POST",
				url: base_url + formAction,
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "JSON",
				beforeSend: function () {
					$("#submitInquiry").loading();
				},
				success: function (res) {
					$("#submitInquiry").loading("stop");
					if(res.status){
						$('#submitInquiry').trigger("reset");
						swalAlert(res.message, 'success', 5000);
					}else{
						if(res.response.login_status){
							swalAlert(res.message, 'warning', 5000);
						} else {
							swalAlertThenRedirect(res.message, 'warning', base_url + 'login');
						}												
					}
				},
			});
		}
    }
});
function getMainCategory(inventoryType,memberType,url){
	$.ajax({
			type: "GET",
			url: base_url + url,
			data: {
				inventoryType 	: inventoryType,
				memberType 		: memberType
			},
			dataType: "JSON",
			beforeSend: function () {
				$("#category").loading();
			},
			success: function (res) {
				$("#category").loading("stop");
				if(inventoryType == 'BUY'){
					$('#documentRequired').show();
				} else {
					$('#documentRequired').hide();
				}
				if(res.status){
					$('#category').empty();
					let html = '<option value="" selected>Select Category</option>';
					$.each(res.response, function (key, val) {
				        html += '<option value="'+val.id+'">'+val.name+'</option>';
				    });
				    $('#category').html(html);
					//swalAlertThenRedirect(res.message, 'success', base_url + res.response.link);
				}else{						
					//swalAlert(res.message, 'warning', 5000);						
				}
			},
	});
}
function getFilter(value){
  	let package_request_sorting   = $('#package_request_sorting').val();
  	var subcatAttributeArray    = [];
  	var inventoryTypeAttributeArray = [];
  	var stateAttributeArray     = [];
    $("input:checkbox[name=subcat]:checked").each(function(){
        subcatAttributeArray.push($(this).val());
    });
    $("input:checkbox[name=inventoryType]:checked").each(function(){
        inventoryTypeAttributeArray.push($(this).val());
    });
    $("input:checkbox[name=state]:checked").each(function(){
        stateAttributeArray.push($(this).val());
    });        
  	$.ajax({
	      type: "POST",
	      url: base_url+"/getFilterData",          
	      data: {
	        package_request_sorting       : package_request_sorting,
	        subcatAttributeArray        : subcatAttributeArray,
	        inventoryTypeAttributeArray     : inventoryTypeAttributeArray,
	        stateAttributeArray         : stateAttributeArray,
	      },          
	      dataType: "json",
	      beforeSend: function () {
	        $("#item-list").loading();
	      },
	      success: function (res) {
	        $("#item-list").loading("stop");
	        if(res.status){
	          	$('#item-list').empty();
	          	let html = '';	          	
	          	$.each(res.response, function (key, item) {
	          		let listing_type_html = '';
		          	if(item.listing_type == "SELL"){
		          		listing_type_html = '<div class="tag-text salebg">'+item.listing_type+'</div>';
		          	}
		          	if(item.listing_type == "BUY"){
		          		listing_type_html = '<div class="tag-text buybg">'+item.listing_type+'</div>';
		          	}
		          	let viewDetailsLink = base_url+'/item-details/'+item.listing_from+'/'+item.listing_id;
	                html += '<div class="col-lg-4 col-md-6 col-sm-6 productList">\
				              	<div class="markete_prodict_item">\
					                <div class="marketprod_img">\
					                  	<img src="'+item.image+'" alt="'+item.item+'">\
					                  	<div class="marketprod_saletag">'+listing_type_html+'</div>\
					                </div>\
					                <div class="market_name">\
					                  <h2 style="font-size: 17px;">'+item.item+'</h2>\
					                  <div class="marketplae_price">\
					                    Rs '+item.rate+' /'+item.unit+'\
					                  </div>\
					                </div>\
					                <div class="marketplace_product_info">\
					                  <p>State : <span>'+item.state+'</span></p>\
					                  <p>Collection : <span>'+item.month+' '+item.year+'</span></p>\
					                  <p>Quantity : <span>'+item.qty+''+item.unit+'</span></p>\
					                  <p><a href="'+viewDetailsLink+'" style="float: right;margin-top: -26px;">View Details</a></p>\
					                </div>\
				              	</div>\
				            </div>';
	            });
	        	$('#item-list').html(html);          
	        }else{            
	          
	        }
	      },
  	});
}
function sendVerificationLink(email, linkType){	
	$.ajax({
			type: "POST",
			url: base_url + 'user/sendVerificationLink',
			data: {
				email 		: email,
				linkType 	: linkType,
			},
			dataType: "JSON",
			beforeSend: function () {
				$("#sendVerificationLink").loading();
			},
			success: function (res) {
				$("#sendVerificationLink").loading("stop");
				if(res.status){						
					swalAlertThenRedirect(res.message, 'success', base_url + res.response.linkType);
				} else {						
					swalAlert(res.message, 'warning', 5000);						
				}
			}
	});
}