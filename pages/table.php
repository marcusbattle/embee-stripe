<div class="wrap">
  <h2></h2>
  <?php 
    $site_summary_table = new Stripe_Object_Table( $data ); 
    $site_summary_table->prepare_items(); 
    $site_summary_table->display(); 
  ?>
</div>