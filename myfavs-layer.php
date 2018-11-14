<?php

class qa_html_theme_layer extends qa_html_theme_base
{
	function head_script()
	{
		qa_html_theme_base::head_script();
			
		$enabled_plugins = qa_opt('enabled_plugins');		
		if( strpos($enabled_plugins, 'myfavs-gyzgyn') !== false && qa_is_logged_in() && qa_opt('myfavs_exclude_css') !== 1 ) {			
			$this->output('
				<script>
					$(function() {
						$(".ajax_remove_button").attr("type", "button"); //button for unfavorite
						$(".ajax_remove_button").click( function(){	
							if (!confirm("You are trying to unfavorite this entity. Are you sure to do this?")) {
								stopImmediatePropagation();
								preventDefault();
							}
							location.reload();
						});
					});
				</script>
			'); 
		}		
	}
	
	function head_custom()
	{
		parent::head_custom();
		$enabled_plugins = qa_opt('enabled_plugins');
		
		if( strpos($enabled_plugins, 'myfavs-gyzgyn') !== false && qa_is_logged_in() && qa_opt('myfavs_exclude_css') !== 1 ) {
			$myfavs_css = '
				<style>
				h2.myfavs_title {
					font-size: 1.15em!important;
				}
				ul.myfavs_ul {
					list-style: none;
					padding: 0;
				}
				ul.myfavs_ul li {
					display: flow-root;
					border-bottom: 1px solid #eee;
					padding: 5px 0px;
					font-size: 12px;
				}
				ul.myfavs_ul li a {
					float: left;
				}
				ul.myfavs_ul li button {
					float: right;
					padding: 2px 8px;
					background: #e74c3c;
					color: #fff;
					border: none;
					font-size: 12px;
				}
				ul.myfavs_ul li button:hover {
					background: #d03f30;
				}
				ul.myfavs_ul li a.myfav-q {
					font-size: 12px;
				}
				</style>';
			$this->output_raw( $myfavs_css );
		}
	}
}