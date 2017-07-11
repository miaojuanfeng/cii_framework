<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Menu management</title>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

		<?php $this->load->view('cms/inc/head-area.php'); ?>

		<script>
		$(function(){
			$('input[name="menu_id"]').focus();

			/* pagination */
			$('.pagination-area>a, .pagination-area>strong').addClass('btn btn-sm btn-primary');
			$('.pagination-area>strong').addClass('disabled');
		});

		function check_delete(id){
			var answer = prompt("Confirm?");
			if(answer){
				$('input[name="menu_id"]').val(id);
				$('input[name="menu_delete_reason"]').val(encodeURI(answer));
				$('form[name="list"]').submit();
			}else{
				return false;
			}
		}

		function login_as(id){
			$('input[name="menu_id"]').val(id);
			$('input[name="act"]').val('login_as');
			$('form[name="list"]').submit();
		}
		</script>
	</head>

	<body>

		<?php $this->load->view('cms/inc/header-area.php'); ?>

		<script>
		$(function(){
			$('input[name="information_id"]').focus();
			$('.summernote').summernote({
				// toolbar: [
				// 	['style', ['style']],
				// 	['font', ['bold', 'italic', 'underline', 'clear']],
				// 	['color', ['color']],
				// 	['para', ['ul', 'ol', 'paragraph']],
				// 	['height', ['height']],
				// 	['table', ['table']],
				// 	['insert', ['link', 'hr']],
				// 	['view', ['fullscreen', 'codeview']]
				// ],
				minHeight: 200
			});

			/* pagination */
			$('.pagination-area>a, .pagination-area>strong').addClass('btn btn-sm btn-primary');
			$('.pagination-area>strong').addClass('disabled');
		});
		</script>








































		<?php if($this->router->fetch_method() == 'update' || $this->router->fetch_method() == 'insert'){ ?>
		<div class="content-area">

			<div class="container-fluid">
				<div class="row">

					<h2 class="col-sm-12"><a href="<?=base_url('cms/menu')?>">Menu management</a> > <?=ucfirst($this->router->fetch_method())?> menu</h2>

					<div class="col-sm-12">
						<form method="post"  enctype="multipart/form-data">
							<input type="hidden" name="menu_id" value="<?=$menu->menu_id?>" />
							<input type="hidden" name="menu_country" value="<?=$this->session->userdata('country_id')?>" />
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
											<label for="menu_name">Name <span class="highlight">*</span></label>
											<?php if (($this->router->fetch_method() == 'update') && ($menu->menu_parent==0)) { ?>
												<input id="menu_name" name="menu_name" type="text" class="form-control input-sm required" disabled placeholder="Name" value="<?=$menu->menu_name?>" />
											<?php } else { ?>
												<input id="menu_name" name="menu_name" type="text" class="form-control input-sm required" placeholder="Name" value="<?=$menu->menu_name?>" />
											<?php } ?>
										</p>
										<p class="form-group">
											<label for="menu_hide">Hide?</label>
											<select id="menu_hide" name="menu_hide" data-placeholder="Hide" class="chosen-select">
												<option value="1" <?php if($menu->menu_hide == 1) echo "selected='selected'"; ?>>Y</option>
												<option value="0" <?php if($menu->menu_hide == 0) echo "selected='selected'"; ?>>N</option>
											</select>
										</p>
									</div>
									<div class="col-sm-4 col-xs-12">
										<h4 class="corpcolor-font">Related information</h4>
										<?php if ( $this->router->fetch_method() == 'insert' || $menu->menu_parent != 0 ) { ?>
											<p class="form-group">
												<label for="menu_parent">Parent</label>
												<?php if (($this->router->fetch_method() == 'update') && ($menu->menu_parent==0)) { ?>
													<select id="menu_parent" name="menu_parent" data-placeholder="Parent" disabled class="chosen-select">
												<?php } else { ?>
													<select id="menu_parent" name="menu_parent" data-placeholder="Parent" class="chosen-select">
												<?php } ?>
													<?php
													foreach($parent as $key => $value){
														$selected = ($value->menu_id == $menu->menu_parent) ? ' selected="selected"' : "" ;
														echo '<option value="'.$value->menu_id.'"'.$selected.'>'.$value->menu_name.'</option>';
													}
													?>
												</select>
											</p>
										<?php } ?>
										<?php if ( is_numeric($menu->menu_parent) && $menu->menu_parent == 0 ) { ?>
											<p class="form-group">
												<?php if( $this->router->fetch_method() == 'update' ){ ?>
												<label for="footer_photo">menu footer photo <span class="highlight">(900px * 450px)</span></label>
												<input id="footer_photo" name="footer_photo" type="file" accept="image/*" />
												<?php }else{ ?>
												<label for="footer_photo">menu footer photo <span class="highlight">* (900px * 450px)</span></label>
												<input id="footer_photo" name="footer_photo" type="file" accept="image/*" class="required" />
												<?php } ?>
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

					<h2 class="col-sm-12">Menu management</h2>

					<div class="content-column-area col-md-9 col-sm-12">

						<div class="fieldset left">
							<div class="search-area">

								<form role="form" method="get">
									<input type="hidden" name="menu_id" />
									<table>
										<tbody>
											<tr>
												<td width="90%">
													<div class="row">
														<div class="col-sm-4">
															<input type="text" name="menu_id" class="form-control input-sm" placeholder="#" value="" />
														</div>
														<div class="col-sm-4"></div>
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
								<form name="list" action="<?=base_url('cms/menu/delete')?>" method="post">
									<input type="hidden" name="menu_id" />
									<input type="hidden" name="menu_delete_reason" />
									<table class="list" id="menu">
										<tbody>
											<tr>
												<th>#</th>
												<th>
													<a href="<?=get_order_link('menu_name')?>">
														Name <i class="glyphicon glyphicon-sort corpcolor-font"></i>
													</a>
												</th>
												<th>
													<a href="<?=get_order_link('menu_modify')?>">
														Modify <i class="glyphicon glyphicon-sort corpcolor-font"></i>
													</a>
												</th>
												<th width="40"></th>
												<th width="40" class="text-right">
													<a href="<?=base_url('cms/menu/insert')?>" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Insert">
														<i class="glyphicon glyphicon-plus"></i>
													</a>
												</th>
											</tr>
											<?php foreach($menus as $key => $value){ ?>
											<tr id="<?=$value->menu_id?>" class="list-row contract" onclick=""> <!-- the onclick="" is for fixing the iphone problem -->
												<td title="<?=$value->menu_id?>"><?=$key+1?></td>
												<td class="expandable"><?=$value->menu_name?></td>
												<td class="expandable"><?=convert_datetime_to_date($value->menu_modifydate)?></td>
												<td class="text-right">
													<a href="<?=base_url('cms/menu/update/menu_id/'.$value->menu_id)?>" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Update">
														<i class="glyphicon glyphicon-pencil"></i>
													</a>
												</td>
												<td class="text-right">
													<a onclick="check_delete(<?=$value->menu_id?>);" class="btn btn-sm btn-primary disabled" data-toggle="tooltip" title="Delete">
														<i class="glyphicon glyphicon-remove"></i>
													</a>
												</td>
											</tr>
											<?php } ?>

											<?php if(!$menus){ ?>
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