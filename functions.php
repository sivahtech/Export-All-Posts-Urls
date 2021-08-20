<?php
function sh_your_post_selected($post_type, $custom_posts_names)
{

    switch ($post_type) {

        case "any":

            $type = "any";
            break;

        case "page":

            $type = "page";
            break;

        case "post":

            $type = "post";
            break;

        default:

            for ($i = 0; $i < count($custom_posts_names); $i++) {

                if ($post_type == $custom_posts_names[$i]) {

                    $type = $custom_posts_names[$i];

                }

            }

    }

    return $type;
	

}
function sh_print_output($output,$selected_post_type){
	?>
	<div class="mainrow">
	
	<?php
	$the_query = new WP_Query( $output );
	if( $the_query->have_posts()){
		$count = $the_query->found_posts; 
	?>
	<h2 class="center"><?php echo $count."   ".$selected_post_type ?> Found</h2>
	<table class="postdetails" id="postdetails">
	<thead>
	<th>SR NO</th>
	<th>TITLE</th>
	<th>LINK</th>
	<th>DATE</th>
	</thead>
	<tbody>
	<?php
	$i=1;
	while( $the_query->have_posts()){
		$the_query->the_post();
	?>
	
		<tr>
		<td><?php echo $i; ?></td>
		<td><?php echo get_the_title(get_the_ID()); ?></td>
		<td><?php echo get_permalink(get_the_ID()); ?></td>
		<td><?php echo $post_date = get_the_date( 'Y/m/d  H:i:s A' );  ?></td>
		</tr>
	
	<?php	
	$i=$i+1;
	}
	echo "</tbody></table>";
	}else{
	echo "No Post Found";
		
	
	}
	?>
	</div>
	
<?php	
}