<?php

/*
	"name": "My Favs Gyzgyn",
	"description": "Widgets for tag/category/user/question favorites",
	"uri": "https://www.e-dostluk.com/q2a-demo/",
	"version": "1.0",
	"date": "2018-11-13",
	"author": "Yhlas Sovbetov",
	"author_uri": "https://gyzgyn.e-dostluk.com/agza/DrWaltBishop",
	"license": "GPLv2",
	"min_q2a": "1.7.5",
	"load_order": "after_db_init"
*/


if(!defined('QA_VERSION'))
{
header('Location: ../../');
exit;
}

// admin
qa_register_plugin_module('module', 'myfavs-admin.php', 'myfavs_admin', 'My Favs Admin');

// lang
qa_register_plugin_phrases( 'myfavs-lang.php', 'myfavs_lang' );

// layer 
qa_register_plugin_layer('myfavs-layer.php', 'My Favs Layer');

//widget tags
qa_register_plugin_module( 'widget', 'myfavs-widget-tags.php', 'myfavs_widget_tags', 'My Favs Widget Tags' );

//widget users
qa_register_plugin_module( 'widget', 'myfavs-widget-users.php', 'myfavs_widget_users', 'My Favs Widget Users' );

//widget questions
qa_register_plugin_module( 'widget', 'myfavs-widget-questions.php', 'myfavs_widget_questions', 'My Favs Widget Questions' );

//widget categories
qa_register_plugin_module( 'widget', 'myfavs-widget-categories.php', 'myfavs_widget_categories', 'My Favs Widget Categories' );

	// get my favs
	function myfavs_get($userid, $entitytype)
	{	
		if( empty($entitytype) ){
			$records = qa_db_read_all_assoc(qa_db_query_sub(
				'SELECT *
				FROM ^userfavorites
				WHERE userid = $
				ORDER BY entitytype',
				$userid
			 ));
		} else {
			if($entitytype == 'Q'){
				$limit = qa_opt('widget_limit_questions');
				$left_join = '^posts as x ON u.entityid = x.postid';
				$select = 'x.title as name';
			} elseif($entitytype == 'T'){
				$limit = qa_opt('widget_limit_tags');
				$left_join = '^words as x ON u.entityid = x.wordid';
				$select = 'x.word as name';
			} elseif($entitytype == 'U'){
				$limit = qa_opt('widget_limit_users');
				$left_join = '^users as x ON u.entityid = x.userid';
				$select = 'x.handle as name';
			} elseif($entitytype == 'C'){
				$limit = qa_opt('widget_limit_categories');
				$left_join = '^categories as x ON u.entityid = x.categoryid';
				$select = 'x.title as name, x.backpath as backpath';
			} else {
				$limit = 10;
			}
			
			$records = qa_db_read_all_assoc(qa_db_query_sub(
				'SELECT u.userid, u.entitytype, u.entityid, '.$select.'
				FROM ^userfavorites as u
				LEFT JOIN '.$left_join.'
				WHERE u.userid = $ AND u.entitytype = $ 
				LIMIT #',
				$userid, $entitytype, $limit
			 ));
		}
		
		return $records;
	}
	
	