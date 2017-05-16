<?php
$parent = isset($_POST['id']) ? (int)$_POST['id'] : 0; 

$res = array(
	'data' => array(
		1 => array(
			'name' => 'aaa',
			'type' => 'folder',
			'additionalParameters' => array(
				'id' => 1,
				'children' => 1
			)
		),
		2 => array(
			'name' => 'bbb',
			'type' => 'folder',
			'additionalParameters' => array(
				'id' => 2,
				'children' => 1
			)
		),
		3 => array(
			'name' => 'ccc',
			'type' => 'item',
			'additionalParameters' => array(
				'id' => 3
			)
		),
		4 => array(
			'name' => 'ddd',
			'type' => 'item',
			'additionalParameters' => array(
				'id' => 4
			)
		),
		5 => array(
			'name' => 'eee',
			'type' => 'item',
			'additionalParameters' => array(
				'id' => 5
			)
		)
	)
);

$res1 = array(
	'data' => array(
		11 => array(
			'name' => 'vvv',
			'type' => 'folder',
			'additionalParameters' => array(
				'id' => 11
				// 'children' => 1
			)
		),
		12 => array(
			'name' => 'www',
			'type' => 'item',
			'additionalParameters' => array(
				'id' => 12
				// 'children' => 1
			)
		),
		13 => array(
			'name' => 'ttt',
			'type' => 'item',
			'additionalParameters' => array(
				'id' => 13
			)
		),
		14 => array(
			'name' => 'yyy',
			'type' => 'item',
			'additionalParameters' => array(
				'id' => 14
			)
		),
		15 => array(
			'name' => 'uuu',
			'type' => 'item',
			'additionalParameters' => array(
				'id' => 15
			)
		)
	)
);

$res2 = array(
	'data' => array(
		6 => array(
			'name' => 'vvv',
			'type' => 'item',
			'additionalParameters' => array(
				'id' => 6
				// 'children' => 1
			)
		),
		7 => array(
			'name' => 'www',
			'type' => 'item',
			'additionalParameters' => array(
				'id' => 7
				// 'children' => 1
			)
		),
		8 => array(
			'name' => 'ttt',
			'type' => 'item',
			'additionalParameters' => array(
				'id' => 8
			)
		),
		9 => array(
			'name' => 'yyy',
			'type' => 'item',
			'additionalParameters' => array(
				'id' => 9
			)
		),
		10 => array(
			'name' => 'uuu',
			'type' => 'item',
			'additionalParameters' => array(
				'id' => 10
			)
		)
	)
);

if($parent == 0){
	echo json_encode($res);
}else if ($parent == 1) {
	echo json_encode($res1);
}else if ($parent == 2) {
	echo json_encode($res2);
}else{
	echo json_encode($res);
}




