jQuery(document).on("click", ".clickoption", function () {
    var ajaxwoocommerceurl = jQuery(".admininsertvalue").val();
    jQuery.ajax({
     url: ajaxwoocommerceurl,
     type: "POST",
     cache: false,
     data: {
         action: "woocommerce_activity_stream_types",
     },
     success: function () {
     jQuery.ajax({
     url: ajaxwoocommerceurl,
     type: "POST",
     cache: false,
     data: {
         action: "woocommerce_delete_plugin_options",
     },
     success: function (data) {
      location.reload();
     },
     error: function (errorThrown) {
         console.log(errorThrown);
     },
     });
     },
     error: function (errorThrown) {
         console.log(errorThrown);
     },
     });
      });
	  
	  
