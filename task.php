<?php

$db = mysqli_connect("localhost","root",'');
mysqli_select_db($db,'php');


$sql_request = 'SELECT * FROM `data`';
$result = mysqli_query($db,trim($sql_request));

$update =array();
$delete = array();
$new = array();

while ($row = mysqli_fetch_assoc($result)){
    if(in_array($row['ident'],$_GET['ident']))
    {
        $tmp_position = array_search($row['ident'],$_GET['ident']);
        if($row['version'] > $_GET['version'][$tmp_position])
        {
            $update[$row['ident']] = array('version'=> $row['version'],
					  'value' => $row['value'],
					  );
        }
        unset($_GET['ident'][$tmp_position]);
        unset($_GET['value'][$tmp_position]);
        unset($_GET['version'][$tmp_position]);
    }
    else
    {
        $new[$row['ident']] = array(
                                'value' => $row['value'], 
						       'version'=> $row['version'],
        );
    }
}
$delete = array();
if(!empty($_GET)) {
    foreach ($_GET['ident'] as $key => $line)
    {
        $delete[] = $_GET['ident'][$key];
    }
}
$all_result = array(
                'delete' => $delete,
                'update' => $update,
                'new' => $new,
                );
print_r($all_result);
