<?php
/*
	Plugin Name: My Favs Admin
*/

class myfavs_admin
{
	// option's value is requested
	public function option_default($option) 
	{	
		switch($option) 
		{
			case 'widget_limit_tags':
			case 'widget_limit_users':
			case 'widget_limit_questions':
			case 'widget_limit_categories':
			 	return 10;
			case 'myfavs_exclude_css':
			 	return 0;
			case 'myfavs_credit':
				return 1;
			case 'myfavs_credit_text':
				return '<li id="gyzgyn_credits" style="display:none"><a href="https://gyzgyn.e-dostluk.com/" rel="dofollow" title="Gyzgyn" alt="Gyzgyn">https://gyzgyn.e-dostluk.com</a></li>';
			default:
				return null;
		}
	}
	
	public function allow_template($template)
	{
		return ($template!='admin');
	}       
		
	public function admin_form(&$qa_content)
	{
		// process the admin form when admin hits save button
		$saved = qa_clicked('myfavs_save');

		if ($saved) {
			qa_opt('myfavs_exclude_css', (bool)qa_post_text('myfavs_exclude_css_field')); // empty or 1
			qa_opt('myfavs_credit', (bool)qa_post_text('myfavs_credit_field')); // empty or 1
			qa_opt('widget_limit_users', (int)qa_post_text('widget_limit_users_field'));			
			qa_opt('widget_limit_tags', (int)qa_post_text('widget_limit_tags_field'));		
			qa_opt('widget_limit_questions', (int)qa_post_text('widget_limit_questions_field'));			
			qa_opt('widget_limit_categories', (int)qa_post_text('widget_limit_categories_field'));	
		}
				
		// form fields to display frontend for admin
		$fields = array();
				
		$fields[] = array(
			'type' => 'checkbox',
			'tags' => 'name="myfavs_exclude_css_field" id="myfavs_exclude_css_field"',
			'label' => qa_lang('myfavs_lang/myfavs_exclude_css'),
			'value' => qa_opt('myfavs_exclude_css'),
			'note' => qa_lang('myfavs_lang/myfavs_exclude_css_note'),
		);

		$fields[] = array(
			'type' => 'checkbox',
			'tags' => 'name="myfavs_credit_field" id="myfavs_credit_field"',
			'label' => qa_lang('myfavs_lang/myfavs_credit_label'),
			'value' => qa_opt('myfavs_credit'),
			'note' => qa_lang('myfavs_lang/myfavs_credit_note'),
		);		

		$fields[] = array(
			'type' => 'number',
			'label' => qa_lang('myfavs_lang/limit_widget_users'),
			'tags' => 'name="widget_limit_users_field"',
			'value' => qa_opt('widget_limit_users'),
		);
		
		$fields[] = array(
			'type' => 'number',
			'label' => qa_lang('myfavs_lang/limit_widget_tags'),
			'tags' => 'name="widget_limit_tags_field"',
			'value' => qa_opt('widget_limit_tags'),
		);
		
		$fields[] = array(
			'type' => 'number',
			'label' => qa_lang('myfavs_lang/limit_widget_questions'),
			'tags' => 'name="widget_limit_questions_field"',
			'value' => qa_opt('widget_limit_questions'),
		);
		
		$fields[] = array(
			'type' => 'number',
			'label' => qa_lang('myfavs_lang/limit_widget_categories'),
			'tags' => 'name="widget_limit_categories_field"',
			'value' => qa_opt('widget_limit_categories'),
		);
		
		return array(
			'ok' => $saved ? 'Settings saved' : null,
			
			'fields' => $fields,
			
			'buttons' => array(
				'save' => array(
					'label' => qa_lang_html('main/save_button'),
					'tags' => 'name="myfavs_save"',
				),
			),
		);
	}
	
} // END myfavs_admin