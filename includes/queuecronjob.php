<?php
//cron for remove leadtype after subscripton expired.
function my_cron_schedules($schedules)
{
  $schedules["permin"] = [
    "interval" => 1 * 60,
    "display" => __("Once every 1 minutes"),
  ];

  return $schedules;
}
add_filter("cron_schedules", "my_cron_schedules");

if (!wp_next_scheduled("send_queue_record")) {
 
  wp_schedule_event(time(), "permin", "send_queue_record");
}
add_action("send_queue_record", "send_queue_record_details");

function send_queue_record_details()
{
   global $wpdb, $WPME_API;

  $genoomem_genooqueue = $wpdb->prefix . "genooqueue"; 
  
  $get_all_queue_records = $wpdb->get_results("select * from $genoomem_genooqueue where status=0");
  
  foreach($get_all_queue_records as $get_all_queue_record)
  {
      
    $order_id = $get_all_queue_record->order_id;
    
    $getpayload = json_decode($get_all_queue_record->payload);
    
    $orderpayload = json_decode($get_all_queue_record->order_payload);
    
    $order = new \WC_Order($order_id);

    
     if (method_exists($WPME_API, 'callCustom')):
        try {
            // Make a POST request, to Genoo / WPME api, for that rest endpoint
                $subscription_streamtypes = [
                    "subscription on hold",
                    "subscription reactivated",
                    "Subscription Pending Cancellation",
                    "subscription completed",
                    "subscription expired",
                    "order refund full",
                    "order refund partial",
                    "cancelled order",
                 
                ];
                $subscription_item_values = ['subscription started','subscription Renewal','new order'];
                
                $failed_order_values = ['sub payment failed','sub renewal failed','payment failed'];

    if (!in_array($get_all_queue_record->order_activitystreamtypes, $subscription_streamtypes)) {
        
            $passorders = $WPME_API->callCustom('/wpmeorders', 'POST', $getpayload);
            
             if($passorders->order_id){
                 
                 if(in_array($get_all_queue_record->order_activitystreamtypes,$subscription_item_values)){
                 
                  $orderpayload->financial_status = 'paid';
                  $orderpayload->order_status = 'subpayment';
                 }
                 
                  if(!in_array($get_all_queue_record->order_activitystreamtypes,$failed_order_values)){
               $result = $WPME_API->updateCart($passorders->order_id,$orderpayload);
           update_post_meta($order_id,'wpme_order_id',$passorders->order_id);
                  }
       }
    }
        $subscription_product_name = get_wpme_subscription_activity_name(
                    $order_id
                );
                $subscription_product_name_values = implode(
                    "," . " ",
                    $subscription_product_name
                );
                  $genoo_ids = get_post_meta(
                        $order_id,
                        "wpme_order_id",
                        true
                    );

                    $genoo_lead_id = get_wpme_order_lead_id($genoo_ids);
                    
                wpme_fire_activity_stream(
                    $genoo_lead_id,
                    $get_all_queue_record->order_activitystreamtypes,
                    $subscription_product_name_values, // Title  $order->parent_id
                    $subscription_product_name_values, // Content
                    " "
                    // Permalink
                );
                 if($result==true || $genoo_lead_id){
                    $wpdb->update(
            $genoomem_genooqueue,
            [
                "status" => 1,
            ],
            [
                "order_id" => $order_id,
              "order_activitystreamtypes" =>  $get_all_queue_record->order_activitystreamtypes
            ]
        );
                 }
       }catch (Exception $e) {
            if ($WPME_API->http->getResponseCode() == 404):
             // Looks like orders not found
            endif;
        }
   endif;

}
}
function custom_logs11($message) { 
    if(is_array($message)) { 
        $message = json_encode($message); 
    } 
    $file = fopen("../custom_logs128912.log","a"); 
    echo fwrite($file, "\n" . date('Y-m-d h:i:s') . " :: " . $message); 
    fclose($file); 
}
?>