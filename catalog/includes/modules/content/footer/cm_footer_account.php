<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2014 osCommerce

  Released under the GNU General Public License
*/

  class cm_footer_account {
    var $code;
    var $group;
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function cm_footer_account() {
      $this->code = get_class($this);
      $this->group = basename(dirname(__FILE__));

      $this->title = MODULE_CONTENT_FOOTER_ACCOUNT_TITLE;
      $this->description = MODULE_CONTENT_FOOTER_ACCOUNT_DESCRIPTION;

      if ( defined('MODULE_CONTENT_FOOTER_ACCOUNT_STATUS') ) {
        $this->sort_order = MODULE_CONTENT_FOOTER_ACCOUNT_SORT_ORDER;
        $this->enabled = (MODULE_CONTENT_FOOTER_ACCOUNT_STATUS == 'True');
      }
    }

    function execute() {
      global $oscTemplate, $customer_id;
      
      switch (MODULE_CONTENT_FOOTER_ACCOUNT_CONTENT_WIDTH) {
        case "100%":
        $content_width = 12;
        break;
        case "75%":
        $content_width = 9;
        break;
        case "66%":
        $content_width = 8;
        break;
        case "50%":
        $content_width = 6;
        break;
        case "33%":
        $content_width = 4;
        break;
        case "25%":
        $content_width = 3;
        break;
        case "20%":
        default:
        $content_width = 2;
      }
      
      if ( isset($_SESSION['customer_id']) ) {
        $account_content = '<li><a href="' . tep_href_link('account.php', '', 'SSL') . '">' . MODULE_CONTENT_FOOTER_ACCOUNT_BOX_ACCOUNT . '</a></li>' .
                           '<li><a href="' . tep_href_link('address_book.php', '', 'SSL') . '">' . MODULE_CONTENT_FOOTER_ACCOUNT_BOX_ADDRESS_BOOK . '</a></li>' .
                           '<li><a href="' . tep_href_link('account_history.php', '', 'SSL') . '">' . MODULE_CONTENT_FOOTER_ACCOUNT_BOX_ORDER_HISTORY . '</a></li>' .
                           '<li><br><a class="btn btn-danger btn-sm btn-block" role="button" href="' . tep_href_link('logoff.php', '', 'SSL') . '"><i class="glyphicon glyphicon-log-out"></i> ' . MODULE_CONTENT_FOOTER_ACCOUNT_BOX_LOGOFF . '</a></li>';
      }
      else {
        $account_content = '<li><a href="' . tep_href_link('create_account.php', '', 'SSL') . '">' . MODULE_CONTENT_FOOTER_ACCOUNT_BOX_CREATE_ACCOUNT . '</a></li>' .
                           '<li><br><a class="btn btn-success btn-sm btn-block" role="button" href="' . tep_href_link('login.php', '', 'SSL') . '"><i class="glyphicon glyphicon-log-in"></i> ' . MODULE_CONTENT_FOOTER_ACCOUNT_BOX_LOGIN . '</a></li>';
      }
      
      ob_start();
      include(DIR_WS_MODULES . 'content/' . $this->group . '/templates/account.php');
      $template = ob_get_clean();

      $oscTemplate->addContent($template, $this->group);
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_CONTENT_FOOTER_ACCOUNT_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Account Footer Module', 'MODULE_CONTENT_FOOTER_ACCOUNT_STATUS', 'True', 'Do you want to enable the Account content module?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Width', 'MODULE_CONTENT_FOOTER_ACCOUNT_CONTENT_WIDTH', '25%', 'What width container should the content be shown in?', '6', '1', 'tep_cfg_select_option(array(\'20%\', \'25%\', \'33%\', \'50%\', \'66%\', \'75%\', \'100%\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_CONTENT_FOOTER_ACCOUNT_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_CONTENT_FOOTER_ACCOUNT_STATUS', 'MODULE_CONTENT_FOOTER_ACCOUNT_CONTENT_WIDTH', 'MODULE_CONTENT_FOOTER_ACCOUNT_SORT_ORDER');
    }
  }
