<?php
/**
 *  zcBootstrapBasic.php
 *
 * @copyright Copyright 2003-2017 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  9/8/2017 2:09 AM Modified in  everbrite_coatings
 */

class zcBootstrapBasic extends base{
	function verifyDBTable($tab){
		global $db, $sniffer;
		$database_table = constant('TABLE_BOOTSTRAP_BASIC_' . strtoupper($tab));
		if(!$sniffer->table_exists($database_table)){
			return false;
		} else{
			return $database_table;
		}
	}

	function getTableFields($table){
		global $db, $sniffer;
		$fields  = array();
		$sql     = "SHOW COLUMNS from " . $table;
		$columns = $db->Execute($sql);
		while(!$columns->EOF){
			$fields[] = $columns->fields['Field'];
			$columns->MoveNext();
		}

		return $fields;
	}

	function getTableFieldsDetails($table){
		global $db;
		$column_array = array();
		$sql          = "SHOW COLUMNS from " . $table;
		$columns      = $db->Execute($sql);
		while(!$columns->EOF){
			$field                = $columns->fields['Field'];
			$column_array[$field] = array(
				'type'    => $columns->fields['Type'],
				'null'    => $columns->fields['Null'],
				'key'     => $columns->fields['Key'],
				'default' => $columns->fields['Default'],
				'extra'   => $columns->fields['Extra'],
				'length'  => preg_replace('/[a-z\(\)]/', '', $columns->fields['Type']),
			);
			$result[]             = $columns->fields;
			$columns->MoveNext();
		}
		$result = $column_array;

		return $result;
	}

	function getFieldColumnsDetails($tab){
		$database_table = $this->verifyDBTable($tab);
		if($database_table == false){
			return false;
		}
		$return_array = $this->getTableFieldsDetails($database_table);

		return $return_array;
	}

	function getFieldValues($tab, $id = 0, $sort_array = array(), $filters = array()){
		global $messageStack, $db, $sniffer;
		$return_array   = array();
		$database_table = $this->verifyDBTable($tab);
		if($database_table == false){
			return false;
		}
		$table_key      = 'bootstrap_basic_' . $tab . '_id';
		$order_by_array = array();
		if(is_array($sort_array) && count($sort_array) > 0){
			foreach($sort_array as $sort_key => $sort_val){
				if(isset($sort_val['field'])){
					$sort_field = zen_db_prepare_input($sort_val['field']);
					if($sniffer->field_exists($database_table, $sort_field)){
						$order_by_order = 'ASC';
						if(isset($sort_val['order']) && strtoupper($sort_val['order']) == 'DESC'){
							$order_by_order = 'DESC';
						}
						$order_by_array[] = ' ' . $sort_field . ' ' . $order_by_order;
					}
				}
			}
		}
		if(count($order_by_array) < 1){
			if($sniffer->field_exists($database_table, $table_key)){
				$order_by_array = array(' ' . $table_key . ' ' . $order_by_order);
			}
		}

		$order_by_string = implode(', ', $order_by_array);
		$sql             = "SELECT * FROM " . $database_table;

		if($id != 0){
			$sql .= " WHERE " . $table_key . " = '" . $id . "'";
		} elseif(is_array($filters) && count($filters) > 0){
			$where_array = array();
			foreach($filters as $filter){
				$where_array[] = $filter['field'] . " = '" . $filter['value'] . "'";
			}
			$where_str = implode(" AND ", $where_array);
			$sql       .= " WHERE " . $where_str . " ";
		}
		$sql    .= " ORDER BY " . $order_by_string;
		$values = $db->Execute($sql);
		$fields = $this->getTableFields($database_table);
		while(!$values->EOF){
			$response_array = array();
			foreach($fields as $field){
				$sm_field                  = strtolower($field);
				$response_array[$sm_field] = $values->fields[$sm_field];
			}
			$return_array['values'][] = $response_array;
			$values->MoveNext();
		}
		$return_array['fields'] = $fields;

		return $return_array;
	}

	function formDetails($tab, $id = 0){
		global $db;
		$return_array = array();
		$form_details = array();
		$table        = $this->verifyDBTable($tab);
		if($table == false){
			return false;
		}
		$table_key    = 'bootstrap_basic_' . $tab . '_id';
		$field_arrays = array();
		$sql          = "SHOW COLUMNS from " . $table;
		if($id != 0){
			$form_values = $db->Execute("SELECT * FROM " . $table . " WHERE " . $table_key . " = " . "'" . $id . "'");
			if($form_values->RecordCount() > 0){
				$id_present = true;
			}
		} else{
			$id_present = false;
		}
		$columns        = $db->Execute($sql);
		$fields_details = $this->fieldsDetails($tab);
		while(!$columns->EOF){
			$field_array         = array();
			$field_name          = $columns->fields['Field'];
			$field_array['name'] = $field_name;

			$type                      = $columns->fields['Type'];
			$rgx                       = preg_match('/^[a-z]*/', $type, $matches);
			$field_array['field_type'] = $matches[0];
			$field_array['length']     = preg_replace('/[a-z\(\)]/', '', $type);
			if($field_name == $table_key || $columns->fields['Key'] == 'PRI' || $columns->fields['Extra'] == 'auto_increment'){
				$field_array['field_type'] = 'hidden';
			}
			$field_array['default'] = $columns->fields['Default'];
			if($id_present == true && isset($field_name)){
				$field_array['value'] = $form_values->fields[$field_name];
			}
			if(isset($fields_details[$field_name])){
				$field_array['field_type'] = $fields_details[$field_name]['type'];
				$field_array['display']    = $fields_details[$field_name]['display'];
				$field_array['required']   = (isset($fields_details[$field_name]['required']) && $fields_details[$field_name]['required'] == true) ? true : false;
				if(isset($fields_details[$field_name]['parameters']) && $fields_details[$field_name]['parameters'] != ''){
					$field_array['parameters'] = $fields_details[$field_name]['parameters'];
				}
			}
			if(!isset($field_array['display'])){
				$field_array['display'] = ucfirst(str_replace('_', ' ', $field_name));
			}
			$field_arrays[] = $field_array;
			$columns->MoveNext();
		}
		$form_details['fields']      = $field_arrays;
		$form_details['id']          = 'bootstrap_basic_' . $tab;
		$form_details['key_id']      = $id;
		$form_details['change_type'] = ($id == 0) ? 'Add' : 'Edit';
		$return_array['tab']         = $tab;
		$return_array['details']     = $form_details;

		return $return_array;
	}

	function buildFormHtml($form_array, $action_type = ''){
		$tab          = $form_array['tab'];
		$form_details = $form_array['details'];
		$form_id      = 'formBootstrapBasic' . ucfirst($tab);
		$form_name    = ucfirst($form_details['change_type']) . ' ' . ucfirst($tab);
		$html         = zen_draw_form($form_id, FILENAME_BOOTSTRAP_BASIC, '', 'POST', ' onsubmit="return false;" role="form" id="' . $form_id . '" data-tag="' . $tab . '" data-id="' . $form_details['id'] . '"');
		$field_arrays = $form_details['fields'];
		$html         .= '<legend>' . $form_name . '</legend>';
		$html         .= '<div id="' . 'formBootstrapBasic' . ucfirst($tab) . 'Errors"></div>';
		$html         .= zen_draw_hidden_field('bootstrapBasicFormType', $tab . '-' . strtolower($form_details['change_type']), 'id="bootstrapBasicFormType"');

		foreach($field_arrays as $field_array){
			$parameters      = (isset($field_array['parameters'])) ? $field_array['parameters'] : '';
			$type            = (isset($field_array['field_type'])) ? $field_array['field_type'] : 'text';
			$required        = $field_array['required'];
			$name            = (isset($field_array['name'])) ? $field_array['name'] : '';
			$value           = (isset($field_array['value'])) ? $field_array['value'] : '';
			$display         = (isset($field_array['display'])) ? $field_array['display'] : '';
			$max_length      = (isset($field_array['length'])) ? (int)$field_array['length'] : 0;
			$table_key_field = (isset($field_array['key'])) ? (int)$field_array['key'] : false;
			if($type == 'readonly'){
				$type       = 'text';
				$parameters .= " readonly";
			}
			if(isset($max_length) && $max_length != 0){
				$parameters .= ' maxlength="' . $max_length . '"';
			}
			$req_html = '';
			if($required == true){
				$parameters .= " required";
				$req_html   = TEXT_FIELD_REQUIRED;
			}
			$input_html = '';
			$field_html = '<div class="form-group"><div class="row">';
			$field_html .= zen_draw_label($display, $name, 'class="control-label col-xs-2"');
			$field_html .= '<div class="col-xs-10">';

			switch($type){
				case 'select':
					$select_return = $this->getFormSelectArray($tab, $name);
					$select_array  = $select_return['options'];
					$default       = $select_return['default'];
					$input_html    .= zen_draw_pull_down_menu($name, $select_array, $default, $parameters, $required);
					break;
				case 'hidden':
					$req_html = '';
				case 'text':
				case 'color':
				case 'date':
				case 'password':
				case 'url':
				case 'number':
					$input_html .= zen_draw_input_field($name, $value, $parameters, $required, $type) . $req_html;
					break;
				case 'textarea':
					$input_html .= zen_draw_textarea_field($name, 'soft', 30, 15, '', 'class="editorHook"') . $req_html;
					break;
				default:
					$input_html = $this->getSpecialFieldInput($type, $name, $value, $parameters, $required);
					break;
			}

			$field_html .= $input_html;
			$field_html .= '</div></div></div>';
			if($type == "hidden"){
				$field_html = $input_html;
			}
			if($table_key_field == true && $action_type == 'add'){
				$field_html = '';
			}
			$html .= $field_html;
		}

		$html .= '<div class="col-xs-12 col-sm-8 col-md-6 col-lg-4" id="bootstrapBasicFormButtons">';
		$html .= '<button type="reset" class="btn btn-default" onclick="clickBootstrapBasicAddEditBoxCancel()">';
		$html .= '<i class="fa fa-times-circle"></i> Cancel';
		$html .= '</button>';

		$html .= '<button type="submit" class="btn btn-success" onclick="clickBootstrapBasicAddEditBoxSubmit(\'' . $form_id . '\')">';
		$html .= '<i class="fa fa-plus-circle"></i> ' . $form_details['change_type'];
		$html .= '</button>';
		$html .= '<div id="bootstrapBasicFormResult"></div>';
		$html .= '</div>';

		$html .= '</form>';

		return $html;
	}

	// Defines Tab
	public function getDefines(){
		if(isset($_POST['bootstrap_basic_defines_id']) && $_POST['bootstrap_basic_defines_id'] != ''){
			$id = (int)zen_db_prepare_input($_POST['bootstrap_basic_defines_id']);
		} else{
			$id = 0;
		}
		$return = $this->getFieldValues('defines', $id);

		return $return;
	}

	public function getListingDefines(){
		$filter_array = array();
		$sort         = array();
		if(isset($_POST['filter_languages_id']) && $_POST['filter_languages_id'] != ''){
			$filter_post    = zen_db_prepare_input($_POST['filter_languages_id']);
			$filter_array[] = array('field' => 'languages_id', 'value' => $filter_post);
		}
		if(isset($_POST['filter_defines_group']) && $_POST['filter_defines_group'] != ''){
			$filter_post    = zen_db_prepare_input($_POST['filter_defines_group']);
			$filter_array[] = array('field' => 'defines_group', 'value' => $filter_post);
		}
		$return = $this->getListing('defines', $sort, $filter_array);

		return $return;
	}

	public function getFormDefines(){
		if(isset($_POST['bootstrap_basic_defines_id']) && $_POST['bootstrap_basic_defines_id'] != ''){
			$id = (int)zen_db_prepare_input($_POST['bootstrap_basic_defines_id']);
		} else{
			$id = 0;
		}
		$form_details        = $this->formDetails('defines', $id);
		$form_html           = $this->buildFormHtml($form_details);
		$return['form_html'] = $form_html;

		return $return;
	}

	public function addDefines(){
		global $db;
		$table         = TABLE_BOOTSTRAP_BASIC_DEFINES;
		$table_key     = 'bootstrap_basic_defines_id';
		$req_posts     = array('defines_define');
		$no_adds       = array('bootstrap_basic_defines_id');
		$unique_fields = array('defines_define');
		$table_fields  = $this->getTableFields($table);
		$errors        = array();
		$sql_array     = array();
		foreach($req_posts as $req_post){
			if(!isset($_POST[$req_post])){
				$error[] = array('incomplete: ' . $req_post);
			}
		}

		foreach($no_adds as $no_add){
			if(isset($_POST[$no_add]) && $_POST[$no_add] != ''){
				$errors = array('extra_data: ' . $no_add);
			}
		}
		foreach($unique_fields as $unique_field){
			$current_query = $db->Execute("SELECT * FROM " . $table . " WHERE " . $unique_field . "='" . $sql_array[$unique_field] . "'");
			if($current_query->RecordCount() > 0){
				$error[] = array('already_present: ' . $unique_field);
			}
		}

		$sql_values = '';
		$sql_fields = '';
		foreach($table_fields as $all_field){
			if(isset($_POST[$all_field]) && $_POST[$all_field] != ''){
				$sql_values .= " '" . zen_db_prepare_input($_POST[$all_field]) . "',";
				$sql_fields .= " " . $all_field . ",";
			}
		}

		if(count($errors) < 1){
			$sql_values = rtrim($sql_values, ',');
			$sql_fields = rtrim($sql_fields, ',');
			$sql        = " INSERT INTO " . $table . "  (" . $sql_fields . ") VALUES (" . $sql_values . ")";
			$db->Execute($sql);
			$id               = $db->insert_ID();
			$return['result'] = array('success' => array('data' => array('id' => $id)));

			return $return;
		} else{
			$return['errors'] = $errors;

			return $return;
		}
	}

	public function editDefines(){
		global $db, $sniffer;
		if(isset($_POST['bootstrap_basic_defines_id']) && $_POST['bootstrap_basic_defines_id'] != ''){
			$id = (int)zen_db_prepare_input($_POST['bootstrap_basic_defines_id']);
		} else{
			$return['errors'] = array('invalid_id');

			return $return;
		}
		$table        = TABLE_BOOTSTRAP_BASIC_DEFINES;
		$table_fields = $this->getTableFields($table);
		$table_key    = 'bootstrap_basic_defines_id';
		$return       = array();
		$check        = $db->Execute("SELECT * FROM " . $table . " WHERE " . $table_key . "='" . (int)$id . "'");
		if($check->RecordCount() < 1){
			$return['errors'] = array('not_present: ' . $id);

			return $return;
		}
		$sql_values = '';
		foreach($table_fields as $all_field){
			if(isset($_POST[$all_field]) && $_POST[$all_field] != '' && $all_field != $table_key){
				$sql_values .= " " . $all_field . "='" . zen_db_prepare_input($_POST[$all_field]) . "',";
			}
		}

		if(count($return['errors']) < 1){
			$sql_values    = rtrim($sql_values, ',');
			$where_text    = $table_key . "='" . $id . "'";
			$sql           = " UPDATE " . $table . " SET " . $sql_values . " WHERE " . $where_text;
			$return['sql'] = $sql;
			$db->Execute($sql);
			$id               = $db->insert_ID();
			$return['result'] = array('success' => array('data' => array('id' => $id)));

			return $return;
		}

	}


	public function deleteDefines(){
		global $db;
		if(isset($_POST['bootstrap_basic_defines_id']) && $_POST['bootstrap_basic_defines_id'] != ''){
			$id = (int)zen_db_prepare_input($_POST['bootstrap_basic_defines_id']);
		} else{
			$id = 0;
		}
		$table     = TABLE_BOOTSTRAP_BASIC_DEFINES;
		$table_key = 'bootstrap_basic_defines_id';
		$errors    = array();
		if($id != 0 && $id != ''){
			$check = $db->Execute("SELECT * FROM " . $table . " WHERE " . $table_key . " = '" . $id . "'");
			if($check->RecordCount() > 0){
//                $db->Execute("DELETE FROM " . $table . " WHERE " . $table_key . " = " . $id);
			} else{
				$errors[] = array('id_not_given', $id);
			}
		}
		if(count($errors) > 0){
			return $errors;
		} else{
			$return['result'] = array('success' => array('data' => array('id' => $id)));

			return $return;
		}
	}

	// Menu Tab
	public function getMenu(){
		if(isset($_POST['bootstrap_basic_menu_id']) && $_POST['bootstrap_basic_menu_id'] != ''){
			$id = (int)zen_db_prepare_input($_POST['bootstrap_basic_menu_id']);
		} else{
			$id = 0;
		}
		$return = $this->getFieldValues('menu', $id);

		return $return;
	}

	public function getListingMenu(){
		$sort         = array();
		$sort[]       = array('field' => 'parent_id', 'order' => 'ASC');
		$sort[]       = array('field' => 'sort_order', 'order' => 'ASC');
		$sort[]       = array('field' => 'display_name', 'order' => 'ASC');
		$sort[]       = array('field' => 'parent_item', 'order' => 'DESC');
		$filter_array = array();
		if(isset($_POST['filter_parent_id']) && $_POST['filter_parent_id'] != ''){
			$filter_post    = zen_db_prepare_input($_POST['filter_parent_id']);
			$filter_array[] = array('field' => 'parent_id', 'value' => $filter_post);
		}
		if(isset($_POST['filter_parent_item']) && $_POST['filter_parent_item'] != ''){
			$filter_post    = zen_db_prepare_input($_POST['filter_parent_item']);
			$filter_array[] = array('field' => 'parent_item', 'value' => $filter_post);
		}
		if(isset($_POST['filter_item_type']) && $_POST['filter_item_type'] != ''){
			$filter_post    = zen_db_prepare_input($_POST['filter_item_type']);
			$filter_array[] = array('field' => 'item_type', 'value' => $filter_post);
		}
		$return = $this->getListing('menu', $sort, $filter_array);

		return $return;
	}

	public function getFormMenu(){
		if(isset($_POST['bootstrap_basic_menu_id']) && $_POST['bootstrap_basic_menu_id'] != ''){
			$id = (int)zen_db_prepare_input($_POST['bootstrap_basic_menu_id']);
		} else{
			$id = 0;
		}
		$form_details        = $this->formDetails('menu', $id);
		$form_html           = $this->buildFormHtml($form_details);
		$return['form_html'] = $form_html;

		return $return;
	}

	public function addMenu(){
		global $db;
		$return       = array();
		$table        = TABLE_BOOTSTRAP_BASIC_MENU;
		$table_fields = $this->getTableFields($table);
		$no_adds      = array('bootstrap_basic_menu_id');
		$errors       = array();

		foreach($no_adds as $no_add){
			if(isset($_POST[$no_add]) && $_POST[$no_add] != ''){
				$errors = array('extra_data: ' . $no_add);
			}
		}

		$sql_values = '';
		$sql_fields = '';
		foreach($table_fields as $all_field){
			if(isset($_POST[$all_field]) && $_POST[$all_field] != ''){
				$sql_values .= " '" . zen_db_prepare_input($_POST[$all_field]) . "',";
				$sql_fields .= " " . $all_field . ",";
			}
		}

		if(count($errors) < 1){
			$sql_values = rtrim($sql_values, ',');
			$sql_fields = rtrim($sql_fields, ',');
			$sql        = " INSERT INTO " . $table . "  (" . $sql_fields . ") VALUES (" . $sql_values . ")";
			$db->Execute($sql);
			$id               = $db->insert_ID();
			$return['result'] = array('success' => array('data' => array('id' => $id)));

			return $return;
		} else{
			$return['errors'] = $errors;

			return $return;
		}
	}

	public function editMenu(){
		global $db, $sniffer;
		if(isset($_POST['bootstrap_basic_menu_id']) && $_POST['bootstrap_basic_menu_id'] != ''){
			$id = (int)zen_db_prepare_input($_POST['bootstrap_basic_menu_id']);
		} else{
			$return['errors'] = array('invalid_id');

			return $return;
		}
		$table        = TABLE_BOOTSTRAP_BASIC_MENU;
		$table_fields = $this->getTableFields($table);
		$table_key    = 'bootstrap_basic_menu_id';
		$return       = array();
		$check        = $db->Execute("SELECT * FROM " . $table . " WHERE " . $table_key . "='" . (int)$id . "'");
		if($check->RecordCount() < 1){
			$return['errors'] = array('not_present: ' . $id);

			return $return;
		}
		$sql_values = '';
		foreach($table_fields as $all_field){
			if(isset($_POST[$all_field]) && $_POST[$all_field] != '' && $all_field != $table_key){
				$sql_values .= " " . $all_field . "='" . zen_db_prepare_input($_POST[$all_field]) . "',";
			}
		}

		if(count($return['errors']) < 1){
			$sql_values = rtrim($sql_values, ',');
			$where_text = $table_key . "='" . $id . "'";
			$sql        = " UPDATE " . $table . " SET " . $sql_values . " WHERE " . $where_text;
			$db->Execute($sql);
			$id               = $db->insert_ID();
			$return['result'] = array('success' => array('data' => array('id' => $id)));

			return $return;
		}
	}

	public function deleteMenu(){
		global $db;
		if(isset($_POST['bootstrap_basic_menu_id']) && $_POST['bootstrap_basic_menu_id'] != ''){
			$id = (int)zen_db_prepare_input($_POST['bootstrap_basic_menu_id']);
		} else{
			$id = 0;
		}
		$table     = TABLE_BOOTSTRAP_BASIC_MENU;
		$table_key = 'bootstrap_basic_menu_id';
		$errors    = array();
		if($id != 0 && $id != ''){
			$check = $db->Execute("SELECT * FROM " . $table . " WHERE " . $table_key . " = '" . $id . "'");
			if($check->RecordCount() > 0){
				$db->Execute("DELETE FROM " . $table . " WHERE " . $table_key . " = " . $id);
			} else{
				$errors[] = array('id_not_given', $id);
			}
		} else{
			$errors[] = array('id_not_given', $id);
		}
		if(count($errors) > 0){
			return $errors;
		} else{
			return $id;
		}
	}


	// options tab

	public function getOptions(){
		if(isset($_POST['bootstrap_basic_options_id']) && $_POST['bootstrap_basic_options_id'] != ''){
			$id = (int)zen_db_prepare_input($_POST['bootstrap_basic_options_id']);
		} else{
			$id = 0;
		}
		$return = $this->getFieldValues('options', $id);

		return $return;
	}

	public function getListingOptions(){
		$filter_array = array();
		$sort         = array();
		if(isset($_POST['filter_options_group']) && $_POST['filter_options_group'] != ''){
			$filter_post    = zen_db_prepare_input($_POST['filter_options_group']);
			$filter_array[] = array('field' => 'options_group', 'value' => $filter_post);
		}
		$return = $this->getListing('options', $sort, $filter_array);

		return $return;
	}

	public function getFormOptions(){
		if(isset($_POST['bootstrap_basic_options_id']) && $_POST['bootstrap_basic_options_id'] != ''){
			$id = (int)zen_db_prepare_input($_POST['bootstrap_basic_options_id']);
		} else{
			$id = 0;
		}
		$form_details        = $this->formDetails('options', $id);
		$form_html           = $this->buildFormHtml($form_details);
		$return['form_html'] = $form_html;

		return $return;
	}

	public function addOptions(){
		global $db;
		$table        = TABLE_BOOTSTRAP_BASIC_OPTIONS;
		$table_fields = $this->getTableFields($table);
		$no_adds      = array('bootstrap_basic_options_id');
		$errors       = array();
		$sql_array    = array();

		foreach($no_adds as $no_add){
			if(isset($_POST[$no_add])){
				$error[] = array('extra_data:' . $no_add);
			}
		}

		foreach($table_fields as $all_field){
			if(isset($_POST[$all_field]) && $_POST[$all_field] != ''){
				$sql_array[$all_field] = zen_db_prepare_input($_POST[$all_field]);
			}
		}

		if(count($errors) < 1){
			$db->perform($table, $sql_array);
			$id = $db->insert_ID();

			return $id;
		} else{
			$return['errors'] = $errors;

			return $return;
		}
	}

	public function editOptions(){
		global $db, $sniffer;
		if(isset($_POST['bootstrap_basic_options_id']) && $_POST['bootstrap_basic_options_id'] != ''){
			$id = (int)zen_db_prepare_input($_POST['bootstrap_basic_options_id']);
		} else{
			$return['errors'] = array('invalid_id');

			return $return;
		}
		$table        = TABLE_BOOTSTRAP_BASIC_OPTIONS;
		$table_fields = $this->getTableFields($table);
		$table_key    = 'bootstrap_basic_options_id';
		$return       = array();
		$check        = $db->Execute("SELECT * FROM " . $table . " WHERE " . $table_key . "='" . (int)$id . "'");
		if($check->RecordCount() < 1){
			$return['errors'] = array('not_present: ' . $id);

			return $return;
		}
		$sql_values = '';
		foreach($table_fields as $all_field){
			if(isset($_POST[$all_field]) && $_POST[$all_field] != '' && $all_field != $table_key){
				$sql_values .= " " . $all_field . "='" . zen_db_prepare_input($_POST[$all_field]) . "',";
			}
		}

		if(count($return['errors']) < 1){
			$sql_values = rtrim($sql_values, ',');
			$where_text = $table_key . "='" . $id . "'";
			$sql        = " UPDATE " . $table . " SET " . $sql_values . " WHERE " . $where_text;
			$db->Execute($sql);
			$id               = $db->insert_ID();
			$return['result'] = array('success' => array('data' => array('id' => $id)));

			return $return;
		}
	}

	public function deleteOptions(){
		global $db;
		if(isset($_POST['bootstrap_basic_options_id']) && $_POST['bootstrap_basic_options_id'] != ''){
			$id = (int)zen_db_prepare_input($_POST['bootstrap_basic_options_id']);
		} else{
			$id = 0;
		}
		$table     = TABLE_BOOTSTRAP_BASIC_OPTIONS;
		$table_key = 'bootstrap_basic_options_id';
		$errors    = array();
		if($id != 0 && $id != ''){
			$check = $db->Execute("SELECT * FROM " . $table . " WHERE " . $table_key . " = '" . $id . "'");
			if($check->RecordCount() > 0){
				$db->Execute("DELETE FROM " . $table . " WHERE " . $table_key . " = " . $id);
			} else{
				$errors[] = array('id_not_given', $id);
			}
		} else{
			$errors[] = array('id_not_given', $id);
		}
		if(count($errors) > 0){
			return $errors;
		} else{
			return $id;
		}
	}

	public function fieldsDetails($tab){
		switch($tab){
			case 'defines':
				$field_array = array(
					'bootstrap_basic_defines_id' => array('type' => 'hidden', 'display' => '', 'key' => true),
					'languages_id'               => array('type' => 'lang_flag', 'display' => 'Language', 'required' => true),
					'defines_title'              => array('type' => 'text', 'display' => 'Title', 'required' => true),
					'defines_group'              => array('type' => 'select', 'display' => 'Group', 'required' => true),
					'defines_define'             => array('type' => 'text', 'display' => 'Define', 'required' => true),
					'defines_input_type'         => array('type' => 'select', 'display' => 'Input Type', 'required' => true),
					'defines_value'              => array('type' => 'textarea', 'display' => 'Value'),
				);
				break;
			case 'options':
				$field_array = array(
					'bootstrap_basic_options_id' => array('type' => 'hidden', 'display' => '', 'key' => true),
					'options_name'               => array('type' => 'readonly', 'display' => 'Title', 'required' => true),
					'options_define'             => array('type' => 'text', 'display' => 'Define', 'required' => true),
					'options_group'              => array('type' => 'select', 'display' => 'Group', 'required' => true),
					'options_input_type'         => array('type' => 'select', 'display' => 'Input Type', 'required' => true),
					'options_value_default'      => array('type' => 'text', 'display' => 'Default'),
					'options_value'              => array('type' => 'text', 'display' => 'Value'),
				);
				break;
			case 'menu':
				$field_array = array(
					'bootstrap_basic_menu_id' => array('type' => 'hidden', 'display' => '', 'key' => true),
					'parent_id'               => array('type' => 'select', 'display' => 'Parent', 'required' => true),
					'sort_order'              => array('type' => 'number', 'display' => 'Sort Order', 'required' => true),
					'display_name'            => array('type' => 'text', 'display' => 'Name'),
					'item_type'               => array('type' => 'select', 'display' => 'Menu Item Type', 'required' => true),
					'menu_link'               => array('type' => 'text', 'display' => 'Menu Link'),
					'parent_item'             => array('type' => 'select', 'display' => 'Parent'),
				);
				break;
		}

		return $field_array;

	}

	public function getFieldToolTip($field_name){
		switch($field_name){
			case 'defines_title':
			case 'options_name':
				$alt = 'Title for easy reference';
				break;
			case 'defines_group':
			case 'options_group':
				$alt = 'Group to which this defines belongs to, only useful for finding later';
				break;
			case 'defines_define':
			case 'options_define':
				$alt = 'Constant to be used';
				break;
			case 'defines_input_type':
			case 'options_input_type':
				$alt = 'Type of field that should be used for value input';
				break;
			case 'defines_value':
			case 'options_value':
				$alt = "Value of defines/constant";
				break;
			case 'options_value_default':
				$alt = "Default value";
				break;
			case 'parent_id':
				$alt = "Which item this is a child of";
				break;
			case 'sort_order':
				$alt = "Order which these should appear";
				break;
			case 'display_name':
				$alt = 'Text to appear on the catalog side';
				break;
			case 'item_type':
				$alt = "Type of item";
				break;
			case 'menu_link':
				$alt = "Link: full link to a url" . '<br/>' . "Divider: A break between items" . '<br/>' . "Product: Product ID" . '<br/>' . "Category: Category ID" . '<br/>' . "EZ Page: EZ Page ID" . '<br/>' . "Define Page Name: (example define_privacy)";
				break;
			case 'parent_item':
				$alt = "Has Children";
				break;
			default:
				$alt = '';
				break;
		}
		$html = '';
		if($alt != ''){
			$html .= '<a href="#" class="bootstrapBasicToolTip" data-toggle="tooltip" title="' . $alt . '">';
			$html .= '<i class="fa fa-question-circle"></i>';
			$html .= '</a>';
		}

		return $html;
	}

	function getFormSelectArray($tab, $name, $vars = array()){
		global $db;
		$select_array = array();
		$return       = array();
		switch($tab){
			case 'defines':
				switch($name){
					case 'defines_group':
						$select_array[] = array('id' => 'main', 'text' => 'Sitewide');
						$select_array[] = array('id' => 'home', 'text' => 'Homepage');
						$select_array[] = array('id' => 'product', 'text' => 'Product Page');
						$select_array[] = array('id' => 'product_listing', 'text' => 'Product Listing Page');
						$select_array[] = array('id' => 'category_listing', 'text' => 'Category Listing Page');
						$default        = 'main';
						break;
					case 'defines_input_type':
						$select_array[] = array('id' => 'text', 'text' => 'Text');
						$select_array[] = array('id' => 'hidden', 'text' => 'Hidden');
						$select_array[] = array('id' => 'color', 'text' => 'Color');
						$select_array[] = array('id' => 'date', 'text' => 'Date');
						$select_array[] = array('id' => 'password', 'text' => 'Password');
						$select_array[] = array('id' => 'phone', 'text' => 'Phone');
						$select_array[] = array('id' => 'url', 'text' => 'URL');
						$select_array[] = array('id' => 'textarea', 'text' => 'Text Area');
						$select_array[] = array('id' => 'select', 'text' => 'Select');
						$select_array[] = array('id' => 'readonly', 'text' => 'Readonly');
						$select_array[] = array('id' => 'lang_flag', 'text' => 'Language');
						$default        = 'text';
						break;
					default:
						$select_array = false;
						$default      = '';
						break;
				}
				break;
			case 'options':
				switch($name){
					case 'options_group':
						$select_array[] = array('id' => 'main', 'text' => 'Sitewide');
						$select_array[] = array('id' => 'home', 'text' => 'Homepage');
						$select_array[] = array('id' => 'product', 'text' => 'Product Page');
						$select_array[] = array('id' => 'product_listing', 'text' => 'Product Listing Page');
						$select_array[] = array('id' => 'category_listing', 'text' => 'Category Listing Page');
						$default        = 'main';
						break;
					case 'options_input_type':
						$select_array[] = array('id' => 'text', 'text' => 'Text');
						$select_array[] = array('id' => 'hidden', 'text' => 'Hidden');
						$select_array[] = array('id' => 'color', 'text' => 'Color');
						$select_array[] = array('id' => 'date', 'text' => 'Date');
						$select_array[] = array('id' => 'password', 'text' => 'Password');
						$select_array[] = array('id' => 'phone', 'text' => 'Phone');
						$select_array[] = array('id' => 'url', 'text' => 'URL');
						$select_array[] = array('id' => 'textarea', 'text' => 'Text Area');
						$select_array[] = array('id' => 'select', 'text' => 'Select');
						$select_array[] = array('id' => 'readonly', 'text' => 'Readonly');
						$select_array[] = array('id' => 'lang_flag', 'text' => 'Language');
						$default        = 'text';
						break;
					default:
						$select_array = false;
						$default      = '';
						break;
				}
				break;
			case 'menu':
				switch($name){
					case 'parent_id':
//                        $menu_parents = $db->Execute("SELECT * FROM " . TABLE_BOOTSTRAP_BASIC_MENU . " WHERE item_type='parent' ORDER BY parent_id ASC, sort_order ASC");
						$menu_parents   = $db->Execute("SELECT * FROM " . TABLE_BOOTSTRAP_BASIC_MENU . " WHERE parent_item='1' ORDER BY parent_id ASC, sort_order ASC");
						$select_array[] = array('id' => '0', 'text' => 'Top');
						while(!$menu_parents->EOF){
							$select_array[] = array('id' => $menu_parents->fields['bootstrap_basic_menu_id'], 'text' => $menu_parents->fields['display_name']);
							$menu_parents->MoveNext();
						}
						break;
					case 'item_type':
						$select_array[] = array('id' => 'link', 'text' => 'Link');
//                        $select_array[] = array('id' => 'parent', 'text' => 'Parent');
						$select_array[] = array('id' => 'text', 'text' => 'Text');
						$select_array[] = array('id' => 'divider', 'text' => 'Divider');
						$select_array[] = array('id' => 'product', 'text' => 'Product ID');
						$select_array[] = array('id' => 'category', 'text' => 'Category ID');
						$select_array[] = array('id' => 'ez_page', 'text' => 'EZ Page ID');
						$select_array[] = array('id' => 'define_page', 'text' => 'Define Page Name');
						$select_array[] = array('id' => 'cat_dropdown', 'text' => 'Category Dropdown');
						$default        = 'link';
						break;
					case 'parent_item':
						$select_array[] = array('id' => '0', 'text' => 'No');
						$select_array[] = array('id' => '1', 'text' => 'Yes');
						$default        = 0;
						break;
					default:
						$select_array = false;
						$default      = '';
						break;
				}
				break;
			default:
				$select_array = false;
				$default      = '';
				break;
		}
		$return['name']    = $name;
		$return['options'] = $select_array;
		$return['default'] = $default;

		return $return;
	}


	public function getListing($tab, $sort_array = array(), $filter_array = array()){
		$table                  = array();
		$head                   = array();
		$valers_array           = array();
		$index_names            = array();
		$select_fields          = array();
		$special_field_names    = array();
		$special_fields_details = array();
		$values_array           = $this->getFieldValues($tab, 0, $sort_array, $filter_array);
		$field_details          = $this->fieldsDetails($tab);
		$table_layout           = $this->getListingLayout($tab);
		$table_fields_Details   = $this->getFieldColumnsDetails($tab);
		$input_applies          = $table_layout['input_type_applies'];
		$input_defined          = $table_layout['input_type_defined'];
		$table['input_apply']   = array(
			'to'   => $input_applies,
			'from' => $input_defined,
		);
		$fi                     = 0;
		foreach($table_layout['order'] as $so_idx => $so_field){
			$head_array = array();
			if(isset($field_details[$so_field]) && in_array($so_field, $table_layout['order'])){
				$field_detail          = $field_details[$so_field];
				$head_array['index']   = $so_idx;
				$head_array['name']    = $so_field;
				$head_array['default'] = $table_fields_Details[$so_field]['default'];
				$head_array['length']  = (int)$table_fields_Details[$so_field]['length'];
				$head_array['tooltip'] = $this->getFieldToolTip($so_field);
				$head_array['display'] = $field_detail['display'];
				$head_array['type']    = $field_detail['type'];

				$filter_array = $this->getFieldFilterSelect($tab, $so_field);
				if(is_array($filter_array) && count($filter_array) > 1){
					$filter_select_name   = 'filter_' . $so_field;
					$parameters           = ' onchange="getBootstrapBasicFilteredDisplay(\'' . $tab . '\',\'' . $filter_select_name . '\')" id="' . $filter_select_name . '" class="bootstrapBasicDisplayFilter"';
					$head_array['filter'] = zen_draw_pull_down_menu($filter_select_name, $filter_array, '', $parameters);
				}

				if($field_detail['type'] == 'select'){
					$select_fields[]      = $so_field;
					$head_array['select'] = true;
				}
				$special_types_array = array('lang_flag', 'foo', 'bar');
				if(in_array($field_detail['type'], $special_types_array)){
					$special_type                      = $field_detail['type'];
					$special_field_names[]             = $so_field;
					$special_fields_details[$so_field] = $special_type;
					$head_array['name']                = $so_field;
					$head_array['type']                = $this->getSpecialFieldTypeType($special_type);
				}
			}
			if($so_field == $input_applies){
				$head_array['type'] = 'input_apply';
			}
			$head[]                    = $head_array;
			$index_names[]             = $so_field;
			$fields_indexed[$so_field] = $fi;
			$fi ++;
		}
		$table['keys'] = $head;
		if(is_array($values_array['values'])){
			foreach($values_array['values'] as $val_row){
				$vals_array = array();
				foreach($index_names as $index_index => $index_name){
					if(isset($select_fields) && is_array($select_fields) && in_array($index_name, $select_fields)){
						// Select Fields
						$sel_vars = array();
						if($index_name == 'bootstrap_basic_menu_id'){
							$sel_vars['menu_id'] = $val_row[$index_name];
						}
						$select_array          = $this->getFormSelectArray($tab, $index_name, $sel_vars);
						$select_val['value']   = $val_row[$index_name];
						$select_val['name']    = $index_name;
						$select_val['options'] = $select_array['options'];
						$select_val['default'] = $select_array['default'];
						$vals_select['select'] = $select_val;
						$vals_array[]          = $vals_select;
					} elseif(isset($special_field_names) && is_array($special_field_names) && in_array($index_name, $special_field_names)){
						// Special Fields
						$special_type    = $special_fields_details[$index_name];
						$special_display = $this->getSpecialFieldDisplay($special_type, $index_name, $val_row[$index_name]);
						$vals_array[]    = array('html' => $special_display);
					} elseif($input_applies == $index_name){
						$vals_array[] = array(
							'apply' => array(
								'to'    => $input_applies,
								'from'  => $input_defined,
								'type'  => $val_row[$input_defined],
								'value' => $val_row[$index_name],
							),
						);
					} elseif($index_index == 0){
						$vals_array[] = array('uniqueid' => $val_row[$index_name]);
					} else{
						// Normal Fields
						$vals_array[] = array('normal' => $val_row[$index_name]);
					}
//	            $vals_array[] = array('readonly' => 'defines');
				}
				$valers_array[] = $vals_array;
			}
		} else{
			$valers_array = array();
		}
		$table['values'] = $valers_array;
		$table['tab']    = $tab;
		$table['count']  = count($valers_array);

		return $table;
	}


	function getSpecialFieldInput($type, $name, $value, $parameters = '', $required = 'false'){
		global $db;
		switch($type){
			case 'lang_flag':
				$lns = $db->Execute("select name, languages_id from " . TABLE_LANGUAGES);
				while(!$lns->EOF){
					$language_array[] = array('text' => $lns->fields['name'], 'id' => $lns->fields['languages_id']);
					$lns->MoveNext();
				}
				$input_field = zen_draw_pull_down_menu($name, $language_array, $value, $parameters, $required);
				break;
			default:
				$input_field = 'ERROR UNDEFINED FIELD TYPE';
				break;
		}
		$return = $input_field;

		return $return;
	}

	function getSpecialFieldDisplay($type, $name, $value, $parameters = ''){
		switch($type){
			case 'lang_flag':
				$display = '<span id="' . $name . '">' . zen_get_language_icon($value) . " " . zen_get_language_name($value) . '</span>';
				break;
			default:
				$display = '<div ' . $parameters . ' id="' . $name . '">' . $value . '</div>';
				break;
		}

		return $display;
	}

	function getSpecialFieldTypeType($type){
		switch($type){
			case 'lang_flag':
				$return = 'html';
				break;
			default:
				$return = 'html';
				break;
		}

		return $return;
	}

	public function getListingLayout($tab){
		$layout = array();
		switch($tab){
			case 'defines':
				$layout['order']              = array('bootstrap_basic_defines_id', 'languages_id', 'defines_title', 'defines_group', 'defines_define', 'defines_value');
				$layout['input_type_applies'] = 'defines_value';
				$layout['input_type_defined'] = 'defines_input_type';
				$layout['editable']           = array('defines_value');
				$layout['display_only']       = array('bootstrap_basic_defines_id', 'languages_id', 'defines_define');
				$layout['filter']             = array('languages_id', 'defines_group');
				break;
			case 'options':
				$layout['order']              = array('bootstrap_basic_options_id', 'options_name', 'options_define', 'options_group', 'options_input_type', 'options_value', 'options_value');
				$layout['input_type_applies'] = 'options_value';
				$layout['input_type_defined'] = 'options_input_type';
				$layout['editable']           = array('options_value');
				$layout['display_only']       = array('bootstrap_basic_options_id', 'options_name', 'options_group');
				$layout['filter']             = array('options_group');
				break;
			case 'menu':
				$layout['order']              = array('bootstrap_basic_menu_id', 'sort_order', 'display_name', 'parent_id', 'menu_link', 'item_type', 'parent_item');
				$layout['input_type_applies'] = '';
				$layout['input_type_defined'] = '';
				$layout['editable']           = array('parent_id', 'sort_order', 'item_type', 'menu_link', 'parent_item');
				$layout['display_only']       = array('bootstrap_basic_menu_id');
				$layout['filter']             = array('parent_id', 'item_type', 'parent_item');
				break;

		}

		return $layout;
	}

	function getFieldFilterSelect($tab, $field){
		global $db, $sniffer;
		$filter_array = array();
		$table        = $this->verifyDBTable($tab);
		if($table == false){
			return false;
		}

		$table_field = zen_db_prepare_input($field);
		if(!$sniffer->field_exists($table, $table_field)){
			return false;
		}
		$filter_array[] = array('id' => '', 'text' => 'Filter');
		switch($tab){
			case 'defines':
				switch($field){
					case 'languages_id':
						$lns = $db->Execute("SELECT name , languages_id FROM " . TABLE_LANGUAGES . " ORDER BY languages_id");
						while(!$lns->EOF){
							$filter_array[] = array('id' => $lns->fields['languages_id'], 'text' => $lns->fields['name']);
							$lns->MoveNext();
						}
						break;
					case 'defines_group':
						$filter_array[] = array('id' => 'main', 'text' => 'Sitewide');
						$filter_array[] = array('id' => 'home', 'text' => 'Homepage');
						$filter_array[] = array('id' => 'product', 'text' => 'Product Page');
						$filter_array[] = array('id' => 'product_listing', 'text' => 'Product Listing Page');
						$filter_array[] = array('id' => 'category_listing', 'text' => 'Category Listing Page');
						break;
					default:
						return false;
						break;
				}
				break;
			case 'options':
				switch($field){
					case 'options_group':
						$filter_array[] = array('id' => 'main', 'text' => 'Sitewide');
						$filter_array[] = array('id' => 'home', 'text' => 'Homepage');
						$filter_array[] = array('id' => 'product', 'text' => 'Product Page');
						$filter_array[] = array('id' => 'product_listing', 'text' => 'Product Listing Page');
						$filter_array[] = array('id' => 'category_listing', 'text' => 'Category Listing Page');
						break;
					default:
						return false;
						break;
				}
				break;
			case 'menu':
				switch($field){
					case 'parent_id':
//                        $menu_parents = $db->Execute("SELECT * FROM " . TABLE_BOOTSTRAP_BASIC_MENU . " WHERE item_type='parent' ORDER BY display_name ASC");
						$menu_parents   = $db->Execute("SELECT * FROM " . TABLE_BOOTSTRAP_BASIC_MENU . " WHERE parent_item='1' ORDER BY display_name ASC");
						$filter_array[] = array('id' => '0', 'text' => 'Top');
						while(!$menu_parents->EOF){
							$filter_array[] = array('id' => $menu_parents->fields['bootstrap_basic_menu_id'], 'text' => $menu_parents->fields['display_name']);
							$menu_parents->MoveNext();
						}
						break;
					case 'item_type':
						$filter_array[] = array('id' => 'link', 'text' => 'Link');
//                        $filter_array[] = array('id' => 'parent', 'text' => 'Parent');
						$filter_array[] = array('id' => 'text', 'text' => 'Text');
						$filter_array[] = array('id' => 'divider', 'text' => 'Divider');
						$filter_array[] = array('id' => 'product', 'text' => 'Product ID');
						$filter_array[] = array('id' => 'category', 'text' => 'Category ID');
						$filter_array[] = array('id' => 'ez_page', 'text' => 'EZ Page ID');
						$filter_array[] = array('id' => 'define_page', 'text' => 'Define Page Name');
						$select_array[] = array('id' => 'cat_dropdown', 'text' => 'Category Dropdown');
						break;
					case 'parent_item':
						$filter_array[] = array('id' => 0, 'text' => 'No');
						$filter_array[] = array('id' => 1, 'text' => 'Yes');
						break;
					default:
						return false;
						break;
				}
				break;
			default:
				return false;
				break;
		}

		return $filter_array;
	}

	public function getAdminAccessPermissions(){
		$permissions = bootstrap_basic_admin_permissions();
		$tab         = zen_db_prepare_input($_POST['tab']);
		$task        = zen_db_prepare_input($_POST['task']);
		if(isset($permissions[$tab]) && in_array($task, $permissions[$tab])){
			$return['permission'] = 1;
		} else{
			$return['permission'] = 0;
		}

		return $return;
	}

}
