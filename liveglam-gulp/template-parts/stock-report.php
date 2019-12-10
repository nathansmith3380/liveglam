<?php
/*
Template Name: Stock Report
*/
if (!is_user_logged_in() || !current_user_can('manage_options')) wp_die('This page is private.');
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php _e('Stock Report'); ?></title>
	<style>
		body { background:white; color:black; width: 95%; margin: 0 auto; }
		table { border: 1px solid #000; width: 100%; }
		table td, table th { border: 1px solid #000; padding: 6px; }
	</style>
</head>
<body>
	<header>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		    <h1 class="title"><?php the_title(); ?></h1>
		
			<?php the_content(); ?>
			
		<?php endwhile; endif; ?>
	</header>
	<section>
	<?php 

	global $woocommerce;
	?>
	<table cellspacing="0" cellpadding="2">
		<thead>
			<tr>	
				<th scope="col" style="text-align:left;"><?php _e('Product', 'woothemes'); ?></th>
				<th scope="col" style="text-align:left;"><?php _e('SKU', 'woothemes'); ?></th>
				<th scope="col" style="text-align:left;"><?php _e('Stock', 'woothemes'); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php

		$args = array(
			'post_type'			=> 'product',
			'post_status' 		=> 'publish',
	        'posts_per_page' 	=> -1,
	        'orderby'			=> 'title',
	        'order'				=> 'ASC',
			'meta_query' 		=> array(
	            array(
	                'key' 	=> '_manage_stock',
	                'value' => 'yes'
	            )
	        ),
			'tax_query' => array(
				array(
					'taxonomy' 	=> 'product_type',
					'field' 	=> 'slug',
					'terms' 	=> array('simple'),
					'operator' 	=> 'IN'
				)
			)
		);
		
		$loop = new WP_Query( $args );
	
		while ( $loop->have_posts() ) : $loop->the_post();
		
                        global $product;
			?>
			<tr>
				<td><?php echo $product->get_title(); ?></td>
				<td><?php echo $product->sku; ?></td>
				<td><?php echo $product->stock; ?></td>
			</tr>
			<?php
		endwhile; 
		
		?>
		</tbody>
	</table>
	<br>
<br>
        <h3>Report KM sale</h3>
        <table cellspacing="0" cellpadding="2">
            <tbody>
            <?php
                $total = count_sale_km("'9999995176', '9999995195', '9999995199'");
                $monthly = count_sale_km("'9999995176'");
                $sixmonths = count_sale_km("'9999995195'");
                $annual = count_sale_km("'9999995199'");
            ?>
            <tr><td>KissMe Monthly</td><td><?php echo $monthly; ?></td></tr>
            <tr><td>KissMe SixMonths</td><td><?php echo $sixmonths; ?></td></tr>
            <tr><td>KissMe Annual</td><td><?php echo $annual; ?></td></tr>
            <tr><td>Total</td><td><?php echo $total; ?></td></tr>
            </tbody>
        </table>
        <br>
        <br>
	</body>
</html>
<?php function count_sale_km( $product ){
    global $wpdb;
    $sql = "SELECT count(DISTINCT ps.ID)
            FROM wp_posts as ps
            LEFT JOIN wp_postmeta as pm on ps.ID = pm.post_id
            LEFT JOIN wp_woocommerce_order_items AS oi1 ON ps.ID = oi1.order_id
            LEFT JOIN wp_woocommerce_order_itemmeta AS oi2 ON oi1.order_item_id = oi2.order_item_id
            WHERE ps.post_type = 'shop_order'
            AND ps.post_status in ( 'wc-completed','wc-processing' )
            AND oi2.meta_key = '_product_id'
            AND oi2.meta_value IN ( {$product} )
            AND pm.meta_key = 'lgs_kissme_sale'
            AND pm.meta_value = 'lgs_kissme_sale-2018'
            AND ps.ID IN ( SELECT post_parent FROM wp_posts WHERE post_type = 'shop_subscription' )";

    $total = $wpdb->get_var($sql);
    return $total;
}