<?php
/**
 * author : trint
 * modify code : 2020-04
 * phone : 098 406 3678
 */
require '../connect/_con.php';

$id = intval($_GET['id']);

include './more/api.php';

switch($_GET['act'])
{
	case 'get_home_tab':
        get_home_tab($id);
    break;
    
    case 'user_similar':
        user_similar();
    break;

    case 'user_follow_story':
        user_follow_story();
    break;

    case 'user_sub_comment':
        user_sub_comment();
    break;

    case 'show_comment':
        show_comment();        
    break;

    case 'user_comment':
        user_comment();
    break;

    case 'admin_delete_comment':
        admin_delete_comment();
    break;
    
    case 'user_delete_story':
        user_delete_story();
    break;

    case 'admin_check_category':
        admin_check_category();        
    break;
    
    case 'admin_duyet_story':     
        admin_duyet_story();           
    break;    
}

close_mysql();
close_redis();