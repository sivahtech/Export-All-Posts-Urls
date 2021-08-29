<?php
require_once(plugin_dir_path(__FILE__) . 'functions.php');
function sh_epua_plugin_html()
{
	
	$custom_posts_names = array();
    $custom_posts_labels = array();
    $user_ids = array();
    $user_names = array();

    $args = array(
        'public' => true,
        '_builtin' => false
    );

    $output = 'objects';

    $operator = 'and';
	
	$allpost_types = get_post_types($args, $output, $operator);
	
	foreach ($allpost_types as $post_type) {

        $custom_posts_names[] = $post_type->name;
        $custom_posts_labels[] = $post_type->labels->singular_name;

    }
	?>
	<div class="maincontentplugin" id="main-content">
		<h2 align="center">Export all posts urls</h2>
		<div class="shmainwrapper">
            <div id="shmainontainer" class="postbox shcolumns">

                <div class="inside">
					<form method="post" action="" id="allurlsetting">
						<table id="allurlsettingtable">
							<tr>
							<th>Select Post type url you want to export</th>
							<td><div class="form-group">
							 <label><input type="radio" name="selected_post_type" value="any"  disabled /> All
                                        Types (pages, posts, and custom post types) <span class="bold">(Available in pro)</span></label>
							</div><div class="form-group">
							 <label><input type="radio" name="selected_post_type" value="page" required="required" checked /> Pages
                                        </label>
							</div><div class="form-group">
							 <label><input type="radio" name="selected_post_type" value="post" required="required" checked /> Posts
                                   </label>
							</div>
							<?php

                                    if (!empty($custom_posts_names) && !empty($custom_posts_labels)) {
                                        for ($i = 0; $i < count($custom_posts_names); $i++) {
                                            echo '<div class="form-group"><label><input type="radio" name="post-type" value="' . esc_html($custom_posts_names[$i]) . '" disabled/> ' . esc_html($custom_posts_labels[$i]) . ' Posts <span class="bold">(Available in pro)</span></label></div>';
                                        }
                                    }
                                    ?>
							
							</td>
							</tr>
							  <tr>
								<td class="submitrow" colspan="2"> 
                                    <input type="submit" name="export" class="button button-primary"
                                           value="Get All Selected Urls"/>
                                </td>

                            </tr>
							
					
						</table>
					</form>
				</div>	
	       </div>
		</div>
	</div>
<?php
if (isset($_POST['export'])) {
	
	if (!empty($_POST['selected_post_type'])){
		$allowed_values = ['page', 'post'];
		if(in_array($_POST['selected_post_type'],$allowed_values )){
			$post_type = sanitize_text_field($_POST['selected_post_type']);
			$offset = 'all';
			$post_per_page = 'all';
			$selected_post_type = sh_epua_your_post_selected($post_type, $custom_posts_names);
			
			
			$args =array(
				'post_type' => $selected_post_type,
				'posts_per_page' => -1,
				
			);
			
			
			sh_epua_print_output($args,$selected_post_type);
		}else{
			
			echo "<div class='notice notice-error' style='width: 93%'>Sorry, Please select either page or post! :)</div>";
			exit;	
		}
	}else{
		echo "<div class='notice notice-error' style='width: 93%'>Sorry, you missed something, Please recheck above options! :)</div>";
		exit;
    }
}
	
}
sh_epua_plugin_html();