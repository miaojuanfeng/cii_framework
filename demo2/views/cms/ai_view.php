<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Author/Illustrator management</title>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

		<?php $this->load->view('cms/inc/head-area.php'); ?>

		<script>
		$(function(){
			$('input[name="ai_id"]').focus();

			/* pagination */
			$('.pagination-area>a, .pagination-area>strong').addClass('btn btn-sm btn-primary');
			$('.pagination-area>strong').addClass('disabled');
		});

		function check_delete(id){
			var answer = prompt("Confirm?");
			if(answer){
				$('input[name="ai_id"]').val(id);
				$('input[name="ai_delete_reason"]').val(encodeURI(answer));
				$('form[name="list"]').submit();
			}else{
				return false;
			}
		}

		function login_as(id){
			$('input[name="ai_id"]').val(id);
			$('input[name="act"]').val('login_as');
			$('form[name="list"]').submit();
		}
		</script>
	</head>

	<body>

		<?php $this->load->view('cms/inc/header-area.php'); ?>

		
		<script>
		$(function(){
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

					<h2 class="col-sm-12"><a href="<?=base_url('cms/ai')?>">Author/Illustrator management</a> > <?=ucfirst($this->router->fetch_method())?> Author/Illustrator</h2>

					<div class="col-sm-12">
						<form method="post" enctype="multipart/form-data">
							<input type="hidden" name="ai_id" value="<?=$ai->ai_id?>" />
							<input type="hidden" name="ai_country" value="<?=$this->session->userdata('country_id')?>" />
							<input type="hidden" name="referrer" value="<?=$this->agent->referrer()?>" />
							<div class="fieldset">
								<div class="row">
									
									<div class="col-sm-4 col-xs-12 pull-right">
										<?php
										if($this->router->fetch_method() == 'update'){
											$ai_photo_link = '/assets/uploads/ai/'.$ai->ai_photo;
											$ai_photo = $_SERVER['DOCUMENT_ROOT'].'/minedition'.$ai_photo_link;
											if(file_exists($ai_photo)){
												echo '<h4 class="corpcolor-font">Author/Illustrator photo</h4>';
												echo '<img class="box-bg" src="'.base_url($ai_photo_link).'?'.time().'" />';
											}
											// $ai_photos_link = '/assets/images/ai_photos/'.$ai->ai_id.'/';
											// foreach($ai_photos as $key => $value){
											// 	echo ($key == 0) ? '<h4 class="corpcolor-font">Photos</h4>' : '';
											// 	echo '<div class="box-bg" id="box_'.$key.'" style="background-image:url('.$ai_photos_link.$value.'?'.time().');">';
											// 	echo '<div class="box-function-area">';
											// 	echo '<div class="text-right">';
											// 	echo '<input type="checkbox" id="'.$key.'" name="photos_remove[]" value="'.$value.'" />';
											// 	echo '<a id="a_'.$key.'" onclick="check_photos_delete('.$key.');" class="btn btn-sm btn-primary" data-toggle="tooltip" title="刪除">';
											// 	echo '<i class="glyphicon glyphicon-remove"></i>';
											// 	echo '</a>';
											// 	echo '</div>';
											// 	echo '</div>';
											// 	echo '</div>';
											// }
										}
										?>
									</div>
									<div class="col-sm-4 col-xs-12">
										<h4 class="corpcolor-font">Basic information</h4>
										<p class="form-group">
											<label for="ai_name">Name <span class="highlight">*</span></label>
											<input id="ai_name" name="ai_name" type="text" class="form-control input-sm required" placeholder="Name" value="<?=$ai->ai_name?>" />
										</p>
										<p class="form-group">
											<label for="z_ai_type_type_id">Type</label>
											<select id="z_ai_type_type_id" name="z_ai_type_type_id[]" data-placeholder="Type" class="chosen-select required" multiple="multiple">
												<option value="1" <?php if(isset($z_ai_type_type_ids) && is_array($z_ai_type_type_ids) && in_array(1, $z_ai_type_type_ids)) echo "selected='selected'"; ?>>Author</option>
												<option value="2" <?php if(isset($z_ai_type_type_ids) && is_array($z_ai_type_type_ids) && in_array(2, $z_ai_type_type_ids)) echo "selected='selected'"; ?>>Illustrator</option>
											</select>
										</p>
										<p class="form-group">
											<label for="ai_desc">Description <span class="highlight">*</span></label>
											<textarea id="ai_desc" name="ai_desc" class="form-control input-sm required summernote" placeholder="Content"><?=$ai->ai_desc?></textarea>
										</p>
									</div>
									<div class="col-sm-4 col-xs-12">
										<h4 class="corpcolor-font">Related information</h4>
										<p class="form-group">
											<?php if($this->router->fetch_method() == 'update'){ ?>
											<label for="ai_photo">Photo <span class="highlight">(300px * 300px)</span></label>
											<input id="ai_photo" name="ai_photo" type="file" accept="image/*" />
											<?php }else{ ?>
											<label for="ai_photo">Photo <span class="highlight">* (300px * 300px)</span></label>
											<input id="ai_photo" name="ai_photo" type="file" accept="image/*" class="required" />
											<?php } ?>
										</p>
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

					<h2 class="col-sm-12">Author/Illustrator management</h2>

					<div class="content-column-area col-md-9 col-sm-12">

						<div class="fieldset left">
							<div class="search-area">

								<form role="form" method="get">
									<input type="hidden" name="ai_id" />
									<table>
										<tbody>
											<tr>
												<td width="90%">
													<div class="row">
														<div class="col-sm-4">
															<input type="text" name="ai_id" class="form-control input-sm" placeholder="#" value="" />
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
								<form name="list" action="<?=base_url('cms/ai/delete')?>" method="post">
									<input type="hidden" name="ai_id" />
									<input type="hidden" name="ai_delete_reason" />
									<table class="list" id="ai">
										<tbody>
											<tr>
												<th>#</th>
												<th>
													<a href="<?=get_order_link('ai_name')?>">
														Name <i class="glyphicon glyphicon-sort corpcolor-font"></i>
													</a>
												</th>
												<th>
													<a href="<?=get_order_link('ai_type')?>">
														Type <i class="glyphicon glyphicon-sort corpcolor-font"></i>
													</a>
												</th>
												<th>
													<a href="<?=get_order_link('ai_modify')?>">
														Modify <i class="glyphicon glyphicon-sort corpcolor-font"></i>
													</a>
												</th>
												<th width="40"></th>
												<th width="40" class="text-right">
													<a href="<?=base_url('cms/ai/insert')?>" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Insert">
														<i class="glyphicon glyphicon-plus"></i>
													</a>
												</th>
											</tr>
											<?php foreach($ais as $key => $value){ ?>
											<tr id="<?=$value->ai_id?>" class="list-row contract" onclick=""> <!-- the onclick="" is for fixing the iphone problem -->
												<td title="<?=$value->ai_id?>"><?=$key+1?></td>
												<td class="expandable"><?=$value->ai_name?></td>
												<td class="expandable"><?=$value->ai_type?></td>
												<td class="expandable"><?=convert_datetime_to_date($value->ai_modifydate)?></td>
												<td class="text-right">
													<a href="<?=base_url('cms/ai/update/ai_id/'.$value->ai_id)?>" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Update">
														<i class="glyphicon glyphicon-pencil"></i>
													</a>
												</td>
												<td class="text-right">
													<a onclick="check_delete(<?=$value->ai_id?>);" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Delete">
														<i class="glyphicon glyphicon-remove"></i>
													</a>
												</td>
											</tr>
											<?php } ?>

											<?php if(!$ais){ ?>
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