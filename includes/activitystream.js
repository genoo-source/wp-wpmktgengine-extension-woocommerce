jQuery(document).ready(function(){

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
 
jQuery(".selectall").click(function () {
    jQuery('input:checkbox').not(this).prop('checked', this.checked);
 });

jQuery(document).on("click",".pushalltogenoo",function()
{
        var objectvalue = jQuery(this).closest('.form-table');
        var checkboxes = [];
        var activity_streamtypes = [];
        var streamtype_val = [];
        var parentDiv=jQuery(objectvalue);
        parentDiv.find(".checkbox:checked").each(function(){
        var data_value  = {};
        data_value.label= jQuery(this).attr("id");
        data_value.labelvalue = jQuery(this).attr("name");
        data_value.label_sub_id = jQuery(this).attr("datasubid");
        streamtype_val[[ jQuery(this).attr("id")]] = data_value;
        checkboxes.push(data_value);
  
        }); 

    jQuery.ajax({
            url: ajaxurl,
            type: "POST",
            cache: false,
            data: {
                action: "push_data_into_genoo",
                order_id:checkboxes
            },
    success: function (data) {
        if(data!=null)
        {
              jQuery.ajax({
            url: ajaxurl,
                    type: "POST",
                    cache: false,
                    data: {
                        action: "order_status_update",
                        status:'1',
                        order_id:checkboxes
                    },
            success: function () {
              location.reload(); 
            },

    error: function (errorThrown) {
                console.log(errorThrown);
            },
            });
        }
        else
        {
             location.reload(); 
        }
    
        },
        error: function (errorThrown) {
                console.log(errorThrown);
        },
    });
        

});




});