<?php
	
	class myfavs_widget_tags {
	
		var $urltoroot;
	
		function load_module($directory, $urltoroot)
		{
			$this->urltoroot = $urltoroot;
		}
	
		function allow_template($template)
		{
			$allow=false;
					
			if( qa_is_logged_in() ) {
				$allow=true;
			}
			
			return $allow;
		}

		function allow_region($region)
		{
			$allow=false;
		
			switch ($region)
			{
				case 'side':
					$allow=true;
					break;
				case 'full':					
					break;
			}
		
			return $allow;
		}

		function output_widget($region, $place, $themeobject, $template, $request, $qa_content)
		{							
			// set up user
			$userid = qa_get_logged_in_userid();		
			$myfavs = myfavs_get($userid, 'T');
			
			$output = '';
			$output .= '<h2 class="myfavs_title">'.qa_lang('myfavs_lang/title_widget_tags').'</h2>';
			$output .= '<ul class="myfavs_ul">';
			if(!empty($myfavs)) {
				foreach ($myfavs as $key=>$myfav) {
					$output .= '<form method="post" action="'.qa_path_html('tag/' . $myfav['name']).'">';
					$output .= '<li>'.qa_tag_html($myfav['name'], $microdata = true, $favorited = true).' <button class="ajax_remove_button" name="favorite_T_'.$myfav['entityid'].'_0" onclick="return qa_favorite_click(this);" type="submit" value="" class="qa-unfavorite-button">'.qa_lang('myfavs_lang/remove').'</button></li>';
					$output .= '<input name="code" type="hidden" value="'.qa_get_form_security_code('favorite-T-'.$myfav['entityid']).'"></form>';
				}
			} else {
				$output .= '<li>'.qa_lang('myfavs_lang/myfavs_no_records_yet').'</li>';
			}			
			if(qa_opt('myfavs_credit')) {
				$output .= ''.qa_opt('myfavs_credit_text').'</ul>';
			} else {
				$output .= '</ul>';
			}
			
			$themeobject->output(
				$output
			);			
		}
	};


/*
	Omit PHP closing tag to help avoid accidental output
*/
