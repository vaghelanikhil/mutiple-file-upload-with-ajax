<?php

$response['isError'] = false;
$k =0;
if (isset($_FILES['files']) && !empty($_FILES['files'])) {
	$no_files = count($_FILES["files"]['name']);
	for ($i = 0; $i < $no_files; $i++) {
		if ($_FILES["files"]["error"][$i] > 0) {
			$response['response'][$k]['isError'] = true;
			$response['response'][$k]['message'] = "Error: " . $_FILES["files"]["error"][$i];
			$k++;
		} else {
			if (file_exists('uploads/' . $_FILES["files"]["name"][$i])) {
				$response['response'][$k]['isError'] = false;
				$response['response'][$k]['file'] = 'uploads/' . $_FILES["files"]["name"][$i];
				$response['response'][$k]['message'] = 'File successfully uploaded : uploads/' . $_FILES["files"]["name"][$i] . ' ';
				$k++;
			} else {
				move_uploaded_file($_FILES["files"]["tmp_name"][$i], 'uploads/' . $_FILES["files"]["name"][$i]);
				$response['response'][$k]['isError'] = false;
				$response['response'][$k]['file'] = 'uploads/' . $_FILES["files"]["name"][$i];
				$response['response'][$k]['message'] = 'File successfully uploaded : uploads/' . $_FILES["files"]["name"][$i] . ' ';
				$k++;
			}
		}
	}
} else {
	$response['isError'] = true;
}

echo json_encode($response);
die;
