/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";
// === button toggle ====
jQuery(function ($){
    $(".segment-select").Segment();
 });

$("#cssmenu").menumaker({
	title: "",              // The text of the button which toggles the menu
	breakpoint: 992,			// The breakpoint for switching to the mobile view
	format: "multitoggle"       // It takes three values: dropdown for a simple toggle menu, select for select list menu, multitoggle for a menu where each submenu can be toggled separately
});
 