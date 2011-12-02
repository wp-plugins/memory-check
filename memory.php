<?php
/*
Plugin Name: Memory check
Plugin URI:
Description: This plugin shows WordPress memory usage .
Version: 1.0
Author:
Author URI: http://savremena.me
License: GPL2
*/


function peric_init()
{
	$memorychack["memused"] .= "ACTION HOOK: init - " . round(memory_get_usage() / 1048576,2) . " MBs\n";
}

function meric_footer()
{
	$memorychack["memused"] .= "ACTION HOOK: wp_footer - " . round(memory_get_usage() / 1048576,2) . " MBs\n";
}

function meric_plugins_loaded()
{
	$memorychack["memused"] .= "ACTION HOOK: plugins_loaded - " . round(memory_get_usage() / 1048576,2) . " MBs\n";
}

function meric_setup_theme()
{
	$memorychack["memused"] .= "ACTION HOOK: setup_theme - " . round(memory_get_usage() / 1048576,2) . " MBs\n";
}

function meric_loop_start()
{
	$memorychack["memused"] .= "ACTION HOOK: loop_start - " . round(memory_get_usage() / 1048576,2) . " MBs\n";
}

function meric_loop_end()
{
	$memorychack["memused"] .= "ACTION HOOK: loop_end - " . round(memory_get_usage() / 1048576,2) . " MBs\n";
}

function mevric_wp_head()
{
	$memorychack["memused"] .= "ACTION HOOK: wp_head - " . round(memory_get_usage() / 1048576,2) . " MBs\n";
}

function merh_widgits_init()
{
	$memorychack["memused"] .= "ACTION HOOK: widgits_init - " . round(memory_get_usage() / 1048576,2) . " MBs\n";
}

function merv_shutdown()
{
	$memorychack["memused"] .= "ACTION HOOK: plugins_loaded - " . round(memory_get_usage() / 1048576,2) . " MBs\n";
	$memorychack["memused"] .= "MAX MEMORY USED: " . round(memory_get_peak_usage() / 1048576,2) . " MBs\n";

	echo "
<!--


" . $memorychack["memused"] . "
-->";
}

add_action("init", "peric_init");
add_action("wp_footer", "meric_footer");
add_action("plugins_loaded", "meric_plugins_loaded");
add_action("setup_theme", "meric_setup_theme");
add_action("loop_start", "meric_loop_start");
add_action("loop_end", "meric_loop_end");
add_action("wp_head", "mevric_wp_head");
add_action("widgits_init", "merh_widgits_init");
add_action("shutdown", "merv_shutdown");
?>