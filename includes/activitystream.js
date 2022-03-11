jQuery(document).on("click", ".clickoption", function () {   
    jQuery.ajax({
     url: ajaxwoocommerceurl,
     type: "POST",
     cache: false,
     data: {
         action: "activity_stream_types",
     },
     success: function () {
     jQuery.ajax({
     url: ajaxwoocommerceurl,
     type: "POST",
     cache: false,
     data: {
         action: "delete_plugin_options",
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