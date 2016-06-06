<?php

/*
Plugin Name:    Intelligent Dashboard
Plugin URI:     https://wp.cbos.ca
Description:    Intelligently adds indicators to your dashboard to help you monitor your site.
Version:        1.0.0
Author:         wp.cbos.ca
Author URI:     https://wp.cbos.ca
License:        GPLv2+
*/ 

defined( 'ABSPATH' ) || die();

define( 'IQ_DASHBOARD_BREAKER_ON', true );

if ( IQ_DASHBOARD_BREAKER_ON ) {
    function iq_dashboard() {
        if ( current_user_can( 'manage_options' ) ) {
            $args = array( 'slug' => 'iq_dashboard', 'title' => 'Intelligent Dashboard', 'function' => 'get_iq_dashboard' );
            wp_add_dashboard_widget( $args['slug'], $args['title'], $args['function'] );                                                                                
        }
    }
    add_action( 'wp_dashboard_setup', 'iq_dashboard' );
}

function _q( $key ) {
    switch( $key ) {        
        case 'backup' :
            return is_backup_on();
            break;
        
        case 'address' :
            return is_address_on();
            break;
            
        case 'debug' :
            return is_debug_on();
            break;
        
        case 'security' :
            return is_security_on();
            break;
        
        case 'mailer' :
            return is_mailer_on();
            break;
        
        case 'wp_cron' :
            return is_wp_cron_on();
            break;
            
        case 'maintain' :
            return is_maintenance_on();
            break;
        
        case 'maps' :
            return is_maps_on();
            break;
                
        case 'file_edits' :
            return is_file_edits_on();
            break;
        
        case 'caching' :
            return is_caching_present();
            break;
            
       case 'caching_on' :
            return is_caching_on();
            break;     
            
        case 'video' :
            return is_video_on();
            break;
        
        case 'xmlrpc' :
            return is_xmlrpc_on();
            break;
            
        case 'optimization' :
            return is_optimization_on();
            break;
            
        case 'social' :
            return is_social_on();
            break;
        
        case 'analytics' :
            return is_analytics_on();
            break;
            
        default: 
            return null;
        
    }
}

function _a( $bool, $resp ) {
    if ( $bool === true ) {
        return $resp['resp'][0];
    }
    else if ( $bool === false ) {
        return $resp['resp'][1];
    }
    else if ( isset( $resp['resp'][2] ) ) {
        return $resp['resp'][2];
    }
    else {
        return 'ERR';
    }
}

function _cell( $key, $gene, $desc ) {
   $cell = sprintf( '<span title="%s">%s</span>: <strong>%s</strong>', $desc, str_replace( '_', ' ', strtoupper(  $key ) ), $gene );
   return $cell;
}

function _rna( $key, $m ) {
    $genome = $m[ $key ]['run'] ? _cell( $key , _a( _q( $key ), $m[ $key ] ), $m[ $key ]['desc'] ) : _cell( $key , 'N/A', $m[ $key ]['desc'] );
    return $genome;
}

function get_iq_dashboard_files(){
    require_once( dirname(__FILE__) . '/data.php' );
    if ( defined( 'WP_BUNDLE' ) ) {
        require_once( dirname(__FILE__) . '/checker.php' );
    }
    else {
        require_once( dirname(__FILE__) . '/checker-alt.php' );
    }
}

function get_iq_dashboard() {
    get_iq_dashboard_files();
    $m = get_iq_dashboard_molecule();
    
    $str = '<table style="width: 100%;">' . PHP_EOL;
    $str .= '<tr><td style="width: 33%;"></td><td style="width: 33%;"></td><td style="width: 33%;"></td></tr>';
    
    $str .= '<tr><td>';
    $str .= _rna( 'backup', $m ); 
    $str .= '</td><td>';
    $str .= _rna( 'address', $m );
    $str .= '</td><td>';
    $str .= _rna( 'debug', $m );
    $str .= '</td></tr>';
    
    $str .= '<tr><td>';
    $str .= _rna( 'security', $m );
    $str .= '</td><td>';
    $str .= _rna( 'mailer', $m );
    $str .= '</td><td>';
    $str .= _rna( 'wp_cron', $m );
    $str .= '</td></tr>';
    
    $str .= '<tr><td>';
    $str .= _rna( 'maintain', $m );
    $str .= '</td><td>';
    $str .= _rna( 'maps', $m );
    $str .= '</td><td>';
    $str .= _rna( 'file_edits', $m );
    $str .= '</td></tr>';
    
    $str .= '<tr><td>';
    $str .= _rna( 'caching', $m );
    $str .= '</td><td>';
    $str .= _rna( 'video', $m );
    $str .= '</td><td>';
    $str .= _rna( 'xmlrpc', $m );
    $str .= '</td></tr>';
    
    $str .= '<tr><td>';
    $str .= _rna( 'caching_on', $m );
    $str .= '</td><td>';
    $str .= _rna( 'social', $m );
    $str .= '</td><td>';
    $str .= _rna( 'analytics', $m );
    $str .= '</td></tr>';
    
    $str .= '<tr><td>';
    $str .= _rna( 'optimization', $m );
    $str .= '</td><td>';
    
    $str .= '</td><td>';
    
    $str .= '</td></tr>';
    
    $str .= '</table>';
    echo $str;
}
