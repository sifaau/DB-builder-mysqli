DB Builder from beginner<br><br>

sample save data to table<br><br>

include 'db_mysqli.php';<br>
$db = new db_query_builder;<br>
$data_input = array(<br>
	'field1'=>$value1,<br>
	'field2'=>$value2,<br>
	'field3'=>value3,<br>
);<br>
$db->save('table_name',$data_input);


