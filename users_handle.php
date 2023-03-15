<?php

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	echo json_encode(null);
}

if ($_POST['task'] === 'get_users_list') {
	$result = $kunci->query("SELECT * FROM `users`");

	$data = [];

	foreach ($result as $row) {
		if ($row['id'] === $_SESSION['user_id']) {
			continue;
		}

		array_push($data, [
			'id'        => $row['id'],
			'profile'   => $row['fotoprofil'],
			'name'      => $row['namalengkap'],
			'username'  => $row['username'],
			'email'     => $row['email'],
			'is_banned' => $row['is_banned']
		]);
	}

	$kunci = null;

	echo json_encode([
		'recordsTotal'      => count($data),
		'recordsFiltered'   => count($data),
		'data'              => $data
	]);
} else if ($_POST['task'] === 'ban_user' && isset($_POST['id'])) {
	$id = $_POST['id'];
	$affected_rows = $kunci->exec("UPDATE `users` SET `is_banned` = 1 WHERE `id` = $id;");

	$kunci = null;

	echo json_encode($affected_rows ? 1 : 0);
} else if ($_POST['task'] === 'unban_user' && isset($_POST['id'])) {
	$id = $_POST['id'];
	$affected_rows = $kunci->exec("UPDATE `users` SET `is_banned` = 0 WHERE `id` = $id;");

	$kunci = null;

	echo json_encode($affected_rows ? 1 : 0);
} else if ($_POST['task'] === 'delete_user' && isset($_POST['id'])) {
	$id = $_POST['id'];
	$affected_rows = $kunci->exec("DELETE FROM `users` WHERE `id`=$id");

	$kunci = null;

	echo json_encode($affected_rows ? 1 : 0);
} else {
	echo json_encode(null);
}

// include 'db.php';

// if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
// 	echo json_encode(null);
// }

// if ($_POST['task'] === 'get_users_list') {
// 	$result = $kunci->query("SELECT * FROM `users`");

// 	$data = [];

// 	foreach ($result as $row) {
// 		if ($row['id'] === $_SESSION['user_id']) {
// 			continue;
// 		}

// 		array_push($data, [
// 			'id'        => $row['id'],
// 			'name'      => $row['namalengkap'],
// 			'username'  => $row['username'],
// 			'email'     => $row['email'],
// 			'is_banned' => $row['is_banned']
// 		]);
// 	}

// 	$kunci = null;

// 	echo json_encode([
// 		'recordsTotal'      => count($data),
// 		'recordsFiltered'   => count($data),
// 		'data'              => $data
// 	]);
// } else if ($_POST['task'] === 'ban_user' && isset($_POST['id'])) {
// 	$id = $_POST['id'];
// 	$affected_rows = $kunci->exec("UPDATE `users` SET `is_banned` = 1 WHERE `id` = $id;");

// 	$kunci = null;

// 	echo json_encode($affected_rows ? 1 : 0);
// } else if ($_POST['task'] === 'unban_user' && isset($_POST['id'])) {
// 	$id = $_POST['id'];
// 	$affected_rows = $kunci->exec("UPDATE `users` SET `is_banned` = 0 WHERE `id` = $id;");

// 	$kunci = null;

// 	echo json_encode($affected_rows ? 1 : 0);
// } else if ($_POST['task'] === 'delete_user' && isset($_POST['id'])) {
// 	$id = $_POST['id'];
// 	$affected_rows = $kunci->exec("DELETE FROM `users` WHERE `id`=$id");

// 	$kunci = null;

// 	echo json_encode($affected_rows ? 1 : 0);
// } else {
// 	echo json_encode(null);
// }
