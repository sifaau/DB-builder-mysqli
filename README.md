DB Builder from beginner

sample save data to table

include 'db_mysqli.php';
$db = new db_query_builder;
$data_input = array(
	'field1'=>$value1,
	'field2'=>$value2,
	'field3'=>value3,
);
$db->save('table_name',$data_input);


