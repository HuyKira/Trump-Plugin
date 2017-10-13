<?php
/*
Plugin Name: Trump Plugin
Plugin URI: https://huykira.net/webmaster/wordpress/plugin-lay-tin-tu-dong-tu-vnexpress-net.html
Description: Trump Plugin by Huy Kira
Author: Huy Kira
Version: 1.1
Author URI: http://www.huykira.net
*/
if ( !function_exists( 'add_action' ) ) {
  echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
  exit;
}

define('TRUMP_PLUGIN_URL', plugin_dir_url(__FILE__));
define('TRUMP_PLUGIN_RIR', plugin_dir_path(__FILE__));

function get_operating_system() {
    $result = 'Unknown OS';
    $os = array(
        '/windows nt 10.0/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile'
    );
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    foreach($os as $regex => $value) {
        if(preg_match($regex, $user_agent)) {
            $result = $value;
            break;
        }
    }
    return $result;
}

function get_visitor_ip() {
    $result = '';
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $result = $_SERVER['HTTP_CLIENT_IP'];
    } elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $result = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $result = $_SERVER['REMOTE_ADDR'];
    }
    $result = apply_filters('wpb_get_ip', $result);
    return $result;
}

function get_browser_name() {
    $result = 'Unknown Browser';
    $browsers = array(
        '/msie/i' => 'Internet Explorer',
        '/firefox/i' => 'Firefox',
        '/chrome/i' => 'Chrome',
        '/safari/i' => 'Safari',
        '/opera/i' => 'Opera',
        '/netscape/i' => 'Netscape',
        '/maxthon/i' => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/mobile/i' => 'Handheld Browser'
    );
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    foreach($browsers as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $result = $value;
            break;
        }
    }
    return $result;
}

function count_post(){
    $count_posts = wp_count_posts();
    return $published_posts = $count_posts->publish;
}
function count_category(){
    $args = array( 
        'hide_empty' => 0,
        'taxonomy' => 'category',
    ); 
    $cates = get_categories( $args ); 
    return count($cates);
}

class Trump_Widget extends WP_Widget {
    function Trump_Widget() {
        $tpwidget_options = array(
            'classname' => 'Trump_widget_class', //ID của widget
            'description' => 'Hiển thị ông Trump ra ngoài'
        );
        $this->WP_Widget('Trump_widget_id', 'Trump Widget', $tpwidget_options);
    }
    function form( $instance ) {
        $default = array(
            'title' => 'Tôi là Donald Trump'
        );
        $instance = wp_parse_args( (array) $instance, $default);
        $title = esc_attr( $instance['title'] );
        echo "<p>Nhập tiêu đề <input type='text' class='widefat' name='".$this->get_field_name('title')."' value='".$title."' /></p>";
    }
    function update( $new_instance, $old_instance ) {
        
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }
    function widget( $args, $instance ) {
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );
        echo $before_widget;
        echo $before_title.$title.$after_title; ?>
            <link rel="stylesheet" href="<?php echo TRUMP_PLUGIN_URL.'trump.css'?>"">
            <div class="trump-widget">
                <div class="content">
                    <center>Chào mừng bạn đến với website</center>
                    <p><strong>IP của bạn là: </strong><?php echo get_visitor_ip(); ?></p>
                    <p><strong>Trình duyệt: </strong><?php echo get_browser_name(); ?></p>
                    <p><strong>Hệ điều hành: </strong><?php echo get_operating_system(); ?></p>
                </div>
                <img src="<?php echo TRUMP_PLUGIN_URL.'trump.png'?>" alt="trump">
            </div>
        <?php echo $after_widget;
    }
}
add_action( 'widgets_init', 'create_Trump_widget' );
function create_Trump_widget() {
    register_widget('Trump_Widget');
}