$(function() {
	function base_url() {
		var pathparts = location.pathname.split('/');
		var url;

		if (location.host == 'localhost') {
			url = location.origin+'/'+pathparts[1].trim('/')+'/'; // http://localhost/myproject/
		}else{
			url = location.origin + "/"; // http://stackoverflow.com/
		}
		return url;
	}

	$('#tbl_events').DataTable();
	$('#tbl_announcements').DataTable();
	$('#tbl_news').DataTable();

	$('#inputEventFee').maskMoney();

	function addEvent(){
		$("#frmAddEvent").submit(function(e) {
			//prevent Default functionality
			e.preventDefault();
			var formAction = e.currentTarget.action;
			var formData = new FormData(this);
			var formType = "POST";
			
			//get the action-url of the form
			var actionUrl = e.currentTarget.action;
			
			$.confirm({
				title: 'Confirmation!',
				content: 'Are you sure you want to add this event?',
				useBootstrap: false, 
				theme: 'supervan',
				buttons: {
					NO: function () {
						//do nothing
					},
					YES: function () {
						$.ajax({
							url: actionUrl,
							type: formType,
							data: formData,
							processData: false,
							contentType: false,
							cache: false,
							async: false,
							success: function(data) {
								var obj = data;
								
								if(obj.flag === 0){
									$.alert({
										title: "Oops! We're sorry!",
										content: obj.msg,
										useBootstrap: false,
										theme: 'supervan',
										buttons: {
											'Ok, Got It!': function () {
												//do nothing
											}
										}
									});
								}else{
									$.alert({
										title: 'Success!',
										content: obj.msg,
										useBootstrap: false,
										theme: 'supervan',
										buttons: {
											'Ok, Got It!': function () {
												location.replace(base_url());
											}
										}
									});
								}
							},
							error: function(xhr, status, error){
								var errorMessage = xhr.status + ': ' + xhr.statusText;
								$.alert({
									title: "Oops! We're sorry!",
									content: errorMessage,
									useBootstrap: false,
									theme: 'supervan',
									buttons: {
										'Ok, Got It!': function () {
											//do nothing
										}
									}
								});
							}
						});
						
					}
				}
			});
		});
	}

	function addNewsAndArticles(){
		$("#frmAddNews").submit(function(e) {
			//prevent Default functionality
			e.preventDefault();
			
			//get the action-url of the form
			var actionUrl = e.currentTarget.action;
			
			$.confirm({
				title: 'Confirmation!',
				content: 'Are you sure you want to add this news or article?',
				useBootstrap: false, 
				theme: 'supervan',
				buttons: {
					NO: function () {
						//do nothing
					},
					YES: function () {
						$.ajax({
							url: actionUrl,
							type: 'POST',
							data: $("#frmAddNews").serialize(),
							success: function(data) {
								var obj = data;
								
								if(obj.flag === 0){
									$.alert({
										title: "Oops! We're sorry!",
										content: obj.msg,
										useBootstrap: false,
										theme: 'supervan',
										buttons: {
											'Ok, Got It!': function () {
												//do nothing
											}
										}
									});
								}else{
									$.alert({
										title: 'Success!',
										content: obj.msg,
										useBootstrap: false,
										theme: 'supervan',
										buttons: {
											'Ok, Got It!': function () {
												location.replace(base_url());
											}
										}
									});
								}
							},
							error: function(xhr, status, error){
								var errorMessage = xhr.status + ': ' + xhr.statusText;
								$.alert({
									title: "Oops! We're sorry!",
									content: errorMessage,
									useBootstrap: false,
									theme: 'supervan',
									buttons: {
										'Ok, Got It!': function () {
											//do nothing
										}
									}
								});
							}
						});
						
					}
				}
			});
		});
	}

	function addAnnouncement(){
		$("#frmAddAnnouncement").submit(function(e) {
			//prevent Default functionality
			e.preventDefault();
			
			//get the action-url of the form
			var actionUrl = e.currentTarget.action;
			
			$.confirm({
				title: 'Confirmation!',
				content: 'Are you sure you want to add this announcement?',
				useBootstrap: false, 
				theme: 'supervan',
				buttons: {
					NO: function () {
						//do nothing
					},
					YES: function () {
						$.ajax({
							url: actionUrl,
							type: 'POST',
							data: $("#frmAddAnnouncement").serialize(),
							success: function(data) {
								var obj = data;
								
								if(obj.flag === 0){
									$.alert({
										title: "Oops! We're sorry!",
										content: obj.msg,
										useBootstrap: false,
										theme: 'supervan',
										buttons: {
											'Ok, Got It!': function () {
												//do nothing
											}
										}
									});
								}else{
									$.alert({
										title: 'Success!',
										content: obj.msg,
										useBootstrap: false,
										theme: 'supervan',
										buttons: {
											'Ok, Got It!': function () {
												location.replace(base_url());
											}
										}
									});
								}
							},
							error: function(xhr, status, error){
								var errorMessage = xhr.status + ': ' + xhr.statusText;
								$.alert({
									title: "Oops! We're sorry!",
									content: errorMessage,
									useBootstrap: false,
									theme: 'supervan',
									buttons: {
										'Ok, Got It!': function () {
											//do nothing
										}
									}
								});
							}
						});
						
					}
				}
			});
		});
	}

	function editVenue(){
		var productId = '';

		$('.btnEditProduct').click(function(){
			productId = $(this).data("id");

			var getProductDetailsUrl = base_url() + 'home/get_product_details?product_id=' + productId;
			$.getJSON(getProductDetailsUrl, function(productResponse) {
				$("input[id='edit_inputProductName']").val(productResponse['product_details'][0].product_name);
				$("input[id='edit_inputProductAmount']").val(productResponse['product_details'][0].product_amount);
				$("textarea[id='edit_inputProductDescription']").val(productResponse['product_details'][0].product_description);
				$("input[id='edit_inputProductQuantity']").val(productResponse['product_details'][0].product_quantity);
				$("input[id='edit_inputProductSeller']").val(productResponse['product_details'][0].product_seller);
			});
		});

		$("#frmEditProduct").submit(function(e) {
			console.log('productId: ' + productId);

			//prevent Default functionality
			e.preventDefault();
			
			//get the action-url of the form
			var actionUrl = e.currentTarget.action;
			
			$.confirm({
				title: 'Confirmation!',
				content: 'Are you sure you want to edit this product?',
				useBootstrap: false, 
				theme: 'supervan',
				buttons: {
					NO: function () {
						//do nothing
					},
					YES: function () {
						$.ajax({
							url: actionUrl + "?product_id=" + productId,
							type: 'POST',
							data: $("#frmEditProduct").serialize(),
							success: function(data) {
								var obj = JSON.parse(data);
								
								if(obj.flag === 0){
									$.alert({
										title: "Oops! We're sorry!",
										content: obj.msg,
										useBootstrap: false,
										theme: 'supervan',
										buttons: {
											'Ok, Got It!': function () {
												//do nothing
											}
										}
									});
								}else{
									$.alert({
										title: 'Success!',
										content: obj.msg,
										useBootstrap: false,
										theme: 'supervan',
										buttons: {
											'Ok, Got It!': function () {
												location.replace(base_url());
											}
										}
									});
								}
							},
							error: function(xhr, status, error){
								var errorMessage = xhr.status + ': ' + xhr.statusText;
								$.alert({
									title: "Oops! We're sorry!",
									content: errorMessage,
									useBootstrap: false,
									theme: 'supervan',
									buttons: {
										'Ok, Got It!': function () {
											//do nothing
										}
									}
								});
							}
						});
						
					}
				}
			});
		});
	}

	function deleteVenue(){
		$('.btnDeclineOrder').click(function(){
			var orderId = $(this).data("id");
			console.log('orderId: ' + orderId);

			$.confirm({
				title: 'Confirmation!',
				content: 'Are you sure you want to decline this pending order?',
				useBootstrap: false, 
				theme: 'supervan',
				buttons: {
					NO: function () {
						//do nothing
					},
					YES: function () {
						$.ajax({
							url: base_url() + 'home/decline_pending_order?order_id=' + orderId,
							type: "POST",
							processData: false,
							contentType: false,
							cache: false,
							async: false,
							success: function(data) {
								var obj = JSON.parse(data);
		
								if(obj.flag === 0){
									$.alert({
										title: "Oops! We're sorry!",
										content: obj.msg,
										useBootstrap: false,
										theme: 'supervan',
										buttons: {
											'Ok, Got It!': function () {
												//do nothing
											}
										}
									});
								}else{
									$.alert({
										title: 'Success!',
										content: obj.msg,
										useBootstrap: false,
										theme: 'supervan',
										buttons: {
											'Ok, Got It!': function () {
												location.replace(base_url());
											}
										}
									});
								}
							},
							error: function(xhr, status, error){
								var errorMessage = xhr.status + ': ' + xhr.statusText;
								$.alert({
									title: "Oops! We're sorry!",
									content: errorMessage,
									useBootstrap: false,
									theme: 'supervan',
									buttons: {
										'Ok, Got It!': function () {
											//do nothing
										}
									}
								});
							 }
						});
						
					}
				}
			});
		});
	}

	$('#frmAddEvent').parsley().on('field:validated', function() {
		var ok = $('.parsley-error').length === 0;
	});

	$('#frmAddNews').parsley().on('field:validated', function() {
		var ok = $('.parsley-error').length === 0;
	});

	// $('#frmAddOrder').parsley().on('field:validated', function() {
	// 	var ok = $('.parsley-error').length === 0;
	// });

	addEvent();
	addNewsAndArticles();
	addAnnouncement();
	
	//editProduct();
	//deleteProduct();

	// addOrder();
	// approveOrder();
	// declineOrder();
});
