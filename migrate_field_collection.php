<?php
$db_con = mysqli_connect("localhost", "oxfordowl", "oxfordowl");
mysqli_select_db($db_con, "drupal7");

$field_collection_machine_name_array = array('field_print_special_position');


$field_collection_fields = array('field_label', 'field_description');

################################

$keep_format_col = array('field_description');


foreach($field_collection_machine_name_array as $field_collection_machine_name => $field_collection_fields) {

$source_table = 'field_data_' . $field_collection_machine_name;
$destination_table = 'node__' . $field_collection_machine_name;

mysqli_query($db_con, "CREATE TABLE $destination_table SELECT * FROM $source_table");
mysqli_query($db_con, "ALTER TABLE `$destination_table` DROP `entity_type`");
mysqli_query($db_con, "ALTER TABLE `$destination_table` CHANGE `language` `langcode` varchar(32) COLLATE 'utf8_general_ci' NOT NULL DEFAULT '' COMMENT 'The language for this data item.' AFTER `revision_id`");



}


foreach($field_collection_fields as $fc_field) {
$source_table = 'field_data_' . $fc_field;
$destination_table = 'field_collection_item__' . $fc_field;
mysqli_query($db_con, "CREATE TABLE $destination_table SELECT * FROM $source_table");
mysqli_query($db_con, "ALTER TABLE `$destination_table` DiROP `entity_type`");
if (!in_array($fc_field, $keep_format_col)) {
        mysqli_query($db_con, "ALTER TABLE `$destination_table` DROP `" . $fc_field . "_format`");
}
mysqli_query($db_con, "ALTER TABLE `$destination_table` CHANGE `language` `langcode` varchar(32) COLLATE 'utf8_general_ci' NOT NULL DEFAULT '' COMMENT 'The language for this data item.' AFTER `revision_id`");

}
