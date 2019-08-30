<?php
$db_con = mysqli_connect("localhost", "oxfordowl", "oxfordowl");
$tablefield_machine_name_array = array('field_table_schedule', 'field_table_online_rates');

################################

$db_prefix_array = array('field_data_' => 'node__', 'field_revision_' => 'node_revision__');


foreach($tablefield_machine_name_array as $tablefield_machine_name) {
foreach($db_prefix_array as $source_prefix => $dest_prefix) {
        $source_table = $source_prefix . $tablefield_machine_name;
        $destination_table = $dest_prefix . $tablefield_machine_name;
        migrate_tablefield_data($source_table , $destination_table, $tablefield_machine_name, $db_con);
}
}

function migrate_tablefield_data($source_table, $destination_table, $tablefield_machine_name, $db_con) {
mysqli_select_db($db_con, "drupal7");
$res = mysqli_query($db_con, "select * from " . $source_table);
mysqli_select_db($db_con, "owl");
while($data = mysqli_fetch_array($res)) {
        mysqli_query($db_con, "insert into " . $destination_table . " (bundle, deleted, entity_id, revision_id, langcode, delta, " . $tablefield_machine_name . "_value, " . $tablefield_machine_name . "_format, " . $tablefield_machine_name . "_caption) values('mediakit', 0, '" . $data['entity_id'] . "','" . $data['revision_id'] . "','en','" . $data['delta'] . "','" . transform_serialize_tablefield($data['field_table_schedule_value']) ."',NULL,NULL)");
}


}

function transform_serialize_tablefield($string) {

$decode = unserialize($string);

$tablearray = array();

foreach($decode as $key => $value) {
        if (substr($key, 0, 5) == 'cell_') {
                $dim = explode("_", $key);
                $tablearray[$dim[1]][$dim[2]] = $value;
        }
}

return str_replace("'", "''", serialize($tablearray));

}
