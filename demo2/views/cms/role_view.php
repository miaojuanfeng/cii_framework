<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Role management</title>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

		<?php $this->load->view('cms/inc/head-area.php'); ?>

		<script>
		$(function(){
			$('input[name="role_id"]').focus();

			/* pagination */
			$('.pagination-area>a, .pagination-area>strong').addClass('btn btn-sm btn-primary');
			$('.pagination-area>strong').addClass('disabled');
		});

		function check_delete(id){
			var answer = prompt("Confirm?");
			if(answer){
				$('input[name="role_id"]').val(id);
				$('input[name="role_delete_reason"]').val(encodeURI(answer));
				$('form[name="list"]').submit();
			}else{
				return false;
			}
		}

		function login_as(id){
			$('input[name="role_id"]').val(id);
			$('input[name="act"]').val('login_as');
			$('form[name="list"]').submit();
		}
		</script>
	</head>

	<body>

		<?php $this->load->view('cms/inc/header-area.php'); ?>

		








































		<?php if($this->router->fetch_method() == 'update' || $this->router->fetch_method() == 'insert'){ ?>
		<div class="content-area">

			<div class="container-fluid">
				<div class="row">

					<h2 class="col-sm-12"><a href="<?=base_url('cms/role')?>">Role management</a> > <?=ucfirst($this->router->fetch_method())?> role</h2>

					<div class="col-sm-12">
						<form method="post">
							<input type="hidden" name="role_id" value="<?=$role->role_id?>" />
							<input type="hidden" name="referrer" value="<?=$this->agent->referrer()?>" />
							<div class="fieldset">
								<div class="row">
									
									<div class="col-sm-4 col-xs-12 pull-right">
										<blockquote>
											<h4 class="corpcolor-font">Instruction</h4>
											<p>* is the required field</p>
											<p>* is the required field</p>
											<p>* is the required field</p>
										</blockquote>
									</div>
									<div class="col-sm-4 col-xs-12">
										<h4 class="corpcolor-font">Basic information</h4>
										<p class="form-group">
											<label for="role_name">Name <span class="highlight">*</span></label>
											<input id="role_name" name="role_name" type="text" class="form-control input-sm required" placeholder="Name" value="<?=$role->role_name?>" />
										</p>
									</div>
									<div class="col-sm-4 col-xs-12">
										<h4 class="corpcolor-font">Related information</h4>
										<?php foreach($permission_classs as $key => $value){ ?>
										<p class="form-group">
											<label for="z_permission_role_permission_id_<?=$value->permission_class?>"><?=ucfirst($value->permission_class)?></label>
											<select id="z_permission_role_permission_id" name="z_permission_role_permission_id[]" data-placeholder="<?=ucfirst($value->permission_class)?>" class="chosen-select" multiple="multiple">
												<option value></option>
												<?php
												foreach($permissions as $key1 => $value1){
													if($value->permission_class == $value1->permission_class){
														$selected = (in_array($value1->permission_id, $z_permission_role_permission_ids)) ? ' selected="selected"' : "" ;
														echo '<option value="'.$value1->permission_id.'"'.$selected.'>'.ucfirst($value1->permission_action).'</option>';
													}
												}
												?>
											</select>
										</p>
										<?php } ?>
									</div>
								</div>

								<div class="row">
									<div class="col-xs-12">
										<button type="submit" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Save</button>
									</div>
								</div>

							</div>
						</form>
					</div>

				</div>
			</div>




		</div>
		<?php } ?>

		











































		<?php if($this->router->fetch_method() == 'select'){ ?>
		<div class="content-area">

			<div class="container-fluid">
				<div class="row">

					<h2 class="col-sm-12">Role management</h2>

					<div class="content-column-area col-md-9 col-sm-12">

						<div class="fieldset left">
							<div class="search-area">

								<form role="form" method="get">
									<input type="hidden" name="role_id" />
									<table>
										<tbody>
											<tr>
												<td width="90%">
													<div class="row">
														<div class="col-sm-4">
															<input type="text" name="role_id" class="form-control input-sm" placeholder="#" value="" />
														</div>
														<div class="col-sm-4">
															<input type="text" name="role_name_like" class="form-control input-sm" placeholder="Name" value="" />
														</div>
														<div class="col-sm-4"></div>
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
						<div class="fieldset left">

							<div class="list-area">
								<form name="list" action="<?=base_url('cms/role/delete')?>" method="post">
									<input type="hidden" name="role_id" />
									<input type="hidden" name="role_delete_reason" />
									<table class="list" id="role">
										<tbody>
											<tr>
												<th>#</th>
												<th>
													<a href="<?=get_order_link('role_name')?>">
														Name <i class="glyphicon glyphicon-sort corpcolor-font"></i>
													</a>
												</th>
												<th>
													<a href="<?=get_order_link('role_modify')?>">
														Modify <i class="glyphicon glyphicon-sort corpcolor-font"></i>
													</a>
												</th>
												<th width="40"></th>
												<th width="40" class="text-right">
													<a href="<?=base_url('cms/role/insert')?>" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Insert">
														<i class="glyphicon glyphicon-plus"></i>
													</a>
												</th>
											</tr>
											<?php foreach($roles as $key => $value){ ?>
											<tr id="<?=$value->role_id?>" class="list-row contract" onclick=""> <!-- the onclick="" is for fixing the iphone problem -->
												<td title="<?=$value->role_id?>"><?=$key+1?></td>
												<td class="expandable"><?=ucfirst($value->role_name)?></td>
												<td class="expandable"><?=convert_datetime_to_date($value->role_modify)?></td>
												<td class="text-right">
													<a href="<?=base_url('cms/role/update/role_id/'.$value->role_id)?>" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Update">
														<i class="glyphicon glyphicon-pencil"></i>
													</a>
												</td>
												<td class="text-right">
													<a onclick="check_delete(<?=$value->role_id?>);" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Delete">
														<i class="glyphicon glyphicon-remove"></i>
													</a>
												</td>
											</tr>
											<?php } ?>

											<?php if(!$roles){ ?>
											<tr class="list-row">
												<td colspan="10"><a href="#" class="btn btn-sm btn-primary">No record found</a></td>
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
					<div class="content-column-area col-md-3 col-sm-12">
						<div class="fieldset right">
							<div class="list-area">
								<table>
									<tbody>
										<tr>
											<th>#</th>
											<th>Name</th>
										</tr>
										<?php for($i=0; $i<3; $i++){ ?>
										<tr class="list-row"> <!-- the onclick="" is for fixing the iphone problem -->
											<td>test</td>
											<td>test</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
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