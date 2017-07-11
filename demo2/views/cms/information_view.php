<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Information</title>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

		<?php $this->load->view('cms/inc/head-area.php'); ?>

		<script>
		$(function(){
			$('input[name="information_id"]').focus();
			$('.summernote').summernote({
				toolbar: [
					['style', ['style']],
					['font', ['bold', 'italic', 'underline', 'clear']],
					['color', ['color']],
					['para', ['ul', 'ol', 'paragraph']],
					['height', ['height']],
					['table', ['table']],
					['insert', ['link', 'hr']],
					['view', ['fullscreen', 'codeview']]
				]
			});

			/* pagination */
			$('.pagination-area>a, .pagination-area>strong').addClass('btn btn-sm btn-primary');
			$('.pagination-area>strong').addClass('disabled');
		});

		function check_delete(id){
			var answer = prompt("Confirm?");
			if(answer){
				$('input[name="information_id"]').val(id);
				$('input[name="information_delete_reason"]').val(encodeURI(answer));
				$('form[name="list"]').submit();
			}else{
				return false;
			}
		}

		function login_as(id){
			$('input[name="information_id"]').val(id);
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

					<h2 class="col-sm-12"><a href="<?=base_url('cms/information')?>">Information</a> > <?=ucfirst($this->router->fetch_method())?> information</h2>

					<div class="col-sm-12">
						<form method="post">
							<input type="hidden" name="information_id" value="<?=$information->information_id?>" />
							<!-- <input type="hidden" name="referrer" value="<?=$this->agent->referrer()?>" /> -->
							<div class="fieldset">
								<div class="row">
									
									<div class="col-sm-4 col-xs-12 pull-right">
										<blockquote>
											<h4 class="corpcolor-font">Instruction</h4>
											<p><span class="highlight">*</span> is the required field</p>
										</blockquote>
									</div>
									<div class="col-sm-8 col-xs-12">
										<h4 class="corpcolor-font">Basic information</h4>
										<p class="form-group">
											<label for="information_content_en">Content(EN) <span class="highlight">*</span></label>
											<textarea id="information_content_en" name="information_content_en" class="form-control input-sm required summernote" placeholder="Content(EN)"><?=$information->information_content_en?></textarea>
										</p>
										<p class="form-group">
											<label for="information_content_tc">Content(TC) <span class="highlight">*</span></label>
											<textarea id="information_content_tc" name="information_content_tc" class="form-control input-sm required summernote" placeholder="Content(TC)"><?=$information->information_content_tc?></textarea>
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

					<h2 class="col-sm-12">information</h2>

					<div class="content-column-area col-md-9 col-sm-12">

						<div class="fieldset left">
							<div class="search-area">

								<form information="form" method="get">
									<input type="hidden" name="information_id" />
									<table>
										<tbody>
											<tr>
												<td width="90%">
													<div class="row">
														<div class="col-sm-4">
															<input type="text" name="information_id" class="form-control input-sm" placeholder="#" value="" />
														</div>
														<div class="col-sm-4">
															<input type="text" name="information_name" class="form-control input-sm" placeholder="Name" value="" />
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
								<form name="list" action="<?=base_url('cms/information/delete')?>" method="post">
									<input type="hidden" name="information_id" />
									<input type="hidden" name="information_delete_reason" />
									<table class="list" id="information">
										<tbody>
											<tr>
												<th>#</th>
												<th>Name</th>
												<th>Grade</th>
												<th>Modify</th>
												<th width="40"></th>
												<th width="40" class="text-right">
													<a href="<?=base_url('cms/information/insert')?>" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Insert">
														<i class="glyphicon glyphicon-plus"></i>
													</a>
												</th>
											</tr>
											<?php foreach($informations as $key => $value){ ?>
											<tr id="<?=$value->information_id?>" class="list-row contract" onclick=""> <!-- the onclick="" is for fixing the iphone problem -->
												<td title="<?=$value->information_id?>"><?=$key+1?></td>
												<td class="expandable"><?=ucfirst($value->information_name)?></td>
												<td class="expandable">Grade <?=$value->information_grade?></td>
												<td class="expandable"><?=convert_datetime_to_date($value->information_modify)?></td>
												<td class="text-right">
													<a href="<?=base_url('cms/information/update/information_id/'.$value->information_id)?>" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Update">
														<i class="glyphicon glyphicon-pencil"></i>
													</a>
												</td>
												<td class="text-right">
													<a onclick="check_delete(<?=$value->information_id?>);" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Delete">
														<i class="glyphicon glyphicon-remove"></i>
													</a>
												</td>
											</tr>
											<?php } ?>

											<?php if(!$informations){ ?>
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