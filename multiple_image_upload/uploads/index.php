<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>File upload using PHP, jQuery and AJAX</title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
        <script type="text/javascript">
			$(document).ready(function (e) {
				$('#myfile').on('change', function () {
					var ins = document.getElementById('myfile').files.length;
					var form_data = new FormData();
					var file_count = 0;
					var total_ins = (ins - 1);
					var success = true;
					for (var x = 0; x < ins; x++) {
						if (file_count == 0) {
							form_data = new FormData();
							form_data.append("files[]", document.getElementById('myfile').files[x]);
							file_count++;
						} else {
							form_data.append("files[]", document.getElementById('myfile').files[x]);
							file_count++;
						}
						if (file_count == 10 || total_ins == x) {
							$.ajax({
								url: 'uploads.php', // point to server-side PHP script 
								dataType: 'text', // what to expect back from the PHP script
								cache: false,
								contentType: false,
								processData: false,
								data: form_data,
								type: 'post',
								async: false,
								success: function (data) {
									var data = $.parseJSON(data);
									if (data.isError == false) {
										$.each(data.response, function (key, value) {
											var box_clone = $(".file_clone").clone();
											box_clone.removeClass('file_clone');
											if (value.isError == false) {
												box_clone.find("img").attr('src', value.file);
												box_clone.find(".file_box_response").html('<i class="fa fa-check fa-3" style="font-size: 30px;line-height: 50px;color: lightgreen;" aria-hidden="true"></i>');
											} else {
												success = false;
												box_clone.find(".file_image").html("<span style='line-height:50px'>" + value.file + " " + value.message + "</span>");
												box_clone.find(".file_box_response").html('<i class="fa fa-times fa-3" style="font-size: 30px;line-height: 50px;color: red;" aria-hidden="true"></i>');
											}
											box_clone.show();
											$(".response_box").append(box_clone);
										});
									} else {
									}
								},
								error: function (response) {
								}
							});
							file_count = 0;
						}
					}
				});
			});
        </script>
    </head>
    <body>
        <p id="msg"></p>
		<div class="row file_clone" style="display: none">
			<div class="col-md-12" style="margin-top: 5px;">
				<div class="col-md-6 file_image">
					<img src=""  width="60px" height="60px"/>
				</div>
				<div class="col-md-6 file_box_response" >
					<span style="line-height: 60px;"><i class="fa fa-check fa-3" aria-hidden="true"></i></span>
				</div>
			</div>
		</div>
		<div>
			<div id="fileuploder" style="width: 75%;border: 4px dotted #3c8dbc;">

				<div style="width: 250px;position: absolute;/*! top: 0; */margin-top: 10px;margin-left: 20px;color: #3c8dbc;font-weight: 900;font-size: 18px;">Drag And Drop File</div>
				<input style="opacity: 0;padding: 10px 215px 10px 0px;border: 1px solid black;" id="myfile" name="myfile[]" multiple="multiple" type="file">
			</div>
			<div class="form-group response_box" style="margin-top: 20px;">
			</div>
		</div>
    </body>
</html>