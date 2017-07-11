<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>System log</title>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

		<?php $this->load->view('cms/inc/head-area.php'); ?>

		<script>
		$(function(){
			$('input[name="log_id"]').focus();

			/* pagination */
			$('.pagination-area>a, .pagination-area>strong').addClass('btn btn-sm btn-primary');
			$('.pagination-area>strong').addClass('disabled');
		});
		</script>
	</head>

	<body>

		<?php $this->load->view('cms/inc/header-area.php'); ?>

		








































		<?php if($this->router->fetch_method() == 'update' || $this->router->fetch_method() == 'insert'){ ?>
		<?php } ?>

		











































		<?php if($this->router->fetch_method() == 'select'){ ?>
		<div class="content-area">

			<div class="container-fluid">
				<div class="row">

					<h2 class="col-sm-12">System log</h2>

					<div class="content-column-area col-md-12 col-sm-12">
						<div class="fieldset">
							<div class="search-area">

								<form role="form" method="get">
									<table>
										<tbody>
											<tr>
												<td width="90%">
													<div class="row">
														<div class="col-sm-4">
															<input type="text" name="log_id" class="form-control input-sm" placeholder="#" value="" />
														</div>
														<div class="col-sm-4">
															<select name="log_permission_class" data-placeholder="Class" class="chosen-select">
																<option value></option>
																<?php foreach($permission_classs as $key => $value){ ?>
																<option value="<?=$value->permission_class?>"><?=$value->permission_class?></option>
																<?php } ?>
															</select>
														</div>
														<div class="col-sm-4">
															<select name="log_permission_action" data-placeholder="Action" class="chosen-select">
																<option value></option>
																<?php foreach($permission_actions as $key => $value){ ?>
																<option value="<?=$value->permission_action?>"><?=$value->permission_action?></option>
																<?php } ?>
															</select>
														</div>
													</div>
												</td>
												<td valign="top" width="10%" class="text-right">
													<button type="submit" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Search">
														<i class="glyphicon glyphicon-search"></i>
													</button>
												</td>
											</tr>
										</tbody>
									</table>
								</form>

							</div> <!-- list-container -->
						</div>
						<div class="fieldset">
							<div class="list-area">
								<form name="list" method="post">
									<table class="list" id="log">
										<tbody>
											<tr>
												<th>#</th>
												<th>Handler</th>
												<th>IP</th>
												<th>path</th>
												<th>Class</th>
												<th>Record</th>
												<th>Action</th>
												<th>Create</th>
											</tr>
											<?php foreach($logs as $key => $value){ ?>
											<tr id="<?=$value->log_id?>" class="list-row contract" onclick=""> <!-- the onclick="" is for fixing the iphone problem -->
												<td title="<?=$value->log_id?>"><?=$key+1?></td>
												<td class="expandable"><?=get_user($value->log_user_id)->user_name?></td>
												<td class="expandable"><?=$value->log_IP?></td>
												<td class="expandable"><?=$value->log_path?></td>
												<td class="expandable"><?=$value->log_permission_class?></td>
												<td class="expandable"><?=$value->log_record_id?></td>
												<td class="expandable"><?=$value->log_permission_action?></td>
												<td class="expandable"><?=$value->log_create?></td>
											</tr>
											<?php } ?>

											<?php if(count($logs) < 1){ ?>
											<tr class="list-row">
												<td colspan="8">No record found</td>
											</tr>
											<?php } ?>

										</tbody>
									</table>
									<div class="page-area">
										<span class="btn btn-sm btn-default"><?php print_r($num_rows); ?></span>
										<?=$this->pagination->create_links()?>
									</div>
								</form>
							</div> <!-- list-area -->							
						</div>
					</div>
				</div>
			</div>

		</div>
		<?php } ?>












































		<?php $this->load->view('cms/inc/footer-area.php'); ?>

	</body>
</html>