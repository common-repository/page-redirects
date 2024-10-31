<?php

// Don't call the file directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Settings page for the plugin
function pluginsclub_redirect_url_admin_page_callback() {
    
// Load CSS only on the settings page
$screen = get_current_screen();
if ( $screen->id === 'settings_page_pluginsclub_redirect_url'){
    wp_enqueue_style( 'settings_page_pluginsclub_redirect_url', plugin_dir_url( __FILE__ ) . 'css/settings-page.css', array(), '1.0.1' );
}    

?>
<div id="pluginsclub-cpanel">
					<div id="pluginsclub-cpanel-header">
			<div id="pluginsclub-cpanel-header-title">
				<div id="pluginsclub-cpanel-header-title-image">
<h1><a href="http://plugins.club/" target="_blank" class="logo"><img src="<?php echo plugins_url('images/pluginsclub_logo_black.png', __FILE__) ?>" style="height:27px"></a></h1></div>

				<div id="pluginsclub-cpanel-header-title-image-sep">
				</div>      
<div id="pluginsclub-cpanel-header-title-nav">
	<?php
// Get our API endpoint and from it build the menu
$plugins_club_api_link = 'https://api.plugins.club/list_of_wp_org_plugins.php';
$remote_data = file_get_contents($plugins_club_api_link);
$menuItems = json_decode($remote_data, true);

foreach ($menuItems as $menuItem) :
    $isActive = isset($_GET['page']) && ($_GET['page'] === $menuItem['page']);
    $activeClass = $isActive ? 'active' : '';
    $isInstalled = function_exists($menuItem['check_function']) && function_exists($menuItem['check_callback']);
    $name = $menuItem['name'];
    if (!$isInstalled) {
        $name = ' <span class="dashicons dashicons-plus-alt"></span> '.$name;
    } else {
        $name .= ' <span class="dashicons dashicons-plugins-checked"></span>';
    }
?>
    <div class="pluginsclub-cpanel-header-nav-item <?php echo $activeClass; ?>">
        <?php if ($isInstalled) : ?>
            <a href="<?php echo $menuItem['url']; ?>" class="tab"><?php echo $name; ?></a>
        <?php else : ?>
            <a href="<?php echo $menuItem['fallback_url']; ?>" target="_blank" class="tab"><?php echo $name; ?></a>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
</div>
      
			</div>
		</div>
		
		

				<div id="pluginsclub-cpanel-admin-wrap" class="wrap">
			<h1 class="pluginsclub-cpanel-hide">Redirects</h1>
			<form id="pluginsclub-cpanel-form">
				<h2>Redirects</h2>
		  <div class="wrap">    				<p>
<?php
$search = ( isset( $_GET['search'] ) ) ? sanitize_text_field( $_GET['search'] ) : '';
echo '<form method="get">';
echo '<input type="hidden" name="page" value="pluginsclub_redirect_url" />';
echo '<p>';
echo '<label class="screen-reader-text" for="search">Search:</label>';
echo '<input type="search" id="search" name="search" value="' . esc_attr( $search ) . '" />';
echo '<input type="submit" id="search-submit" class="button" value="Search" />';
echo '</p>';
echo '</form>';
?>
	
		<div class="pluginsclub-cpanel-sep"></div>
		
<table class="wp-list-table widefat fixed" role="presentation">
<?php    
echo '<thead>';
echo '<tr>';
echo '<th>Post/Page/Product</th>';
echo '<th>Redirect URL</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

$args = array(
    'post_type' => array( 'post', 'page', 'product' ),
    'meta_query' => array(
        array(
            'key' => 'pluginsclub_redirect_url',
            'compare' => 'EXISTS'
        )
    )
);

if ( ! empty( $search ) ) {
    $args['s'] = $search;
}

$query = new WP_Query( $args );
while ( $query->have_posts() ) {
    $query->the_post();
   
$pluginsclub_redirect_url = get_post_meta( get_the_ID(), 'pluginsclub_redirect_url', true );
if(empty($pluginsclub_redirect_url))
continue;
echo '<tr>';
echo '<td>' . '<a href="' . get_edit_post_link() . '">' . get_the_title() . '</a>' . '</td>';
echo '<td>' . esc_html( $pluginsclub_redirect_url ) . '</td>';
echo '</tr>';
}
wp_reset_postdata();
echo '</tbody>';
echo '</table>';
echo '</div>';
}



