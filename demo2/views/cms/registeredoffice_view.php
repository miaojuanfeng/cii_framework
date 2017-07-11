<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Registered office</title>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

		<?php $this->load->view('cms/inc/head-area.php'); ?>

		<script>
		$(function(){
			$('input[name="registeredoffice_id"]').focus();
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
				$('input[name="registeredoffice_id"]').val(id);
				$('input[name="registeredoffice_delete_reason"]').val(encodeURI(answer));
				$('form[name="list"]').submit();
			}else{
				return false;
			}
		}

		function login_as(id){
			$('input[name="registeredoffice_id"]').val(id);
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

					<h2 class="col-sm-12"><a href="<?=base_url('cms/registeredoffice')?>">Registered office</a> > <?=ucfirst($this->router->fetch_method())?> group business</h2>

					<div class="col-sm-12">
						<form method="post">
							<input type="hidden" name="registeredoffice_id" value="<?=$registeredoffice->registeredoffice_id?>" />
							<input type="hidden" name="referrer" value="<?=$this->agent->referrer()?>" />
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
											<label for="registeredoffice_title_en">Title(EN) <span class="highlight">*</span></label>
											<input id="registeredoffice_title_en" name="registeredoffice_title_en" type="text" class="form-control input-sm required" placeholder="Title(EN)" value="<?=$registeredoffice->registeredoffice_title_en?>" />
										</p>
										<p class="form-group">
											<label for="registeredoffice_title_tc">Title(TC) <span class="highlight">*</span></label>
											<input id="registeredoffice_title_tc" name="registeredoffice_title_tc" type="text" class="form-control input-sm required" placeholder="Title(TC)" value="<?=$registeredoffice->registeredoffice_title_tc?>" />
										</p>
										<p class="form-group">
											<label for="registeredoffice_content_en">Content(EN) <span class="highlight">*</span></label>
											<input id="registeredoffice_content_en" name="registeredoffice_content_en" type="text" class="form-control input-sm required" placeholder="Content(EN)" value="<?=$registeredoffice->registeredoffice_content_en?>" />
										</p>
										<p class="form-group">
											<label for="registeredoffice_content_tc">Content(TC) <span class="highlight">*</span></label>
											<input id="registeredoffice_content_tc" name="registeredoffice_content_tc" type="text" class="form-control input-sm required" placeholder="Content(TC)" value="<?=$registeredoffice->registeredoffice_content_tc?>" />
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

					<h2 class="col-sm-12">Registered office</h2>

					<div class="content-column-area col-md-12 col-sm-12">

						<div class="fieldset">
							<div class="search-area">

								<form registeredoffice="form" method="get">
									<input type="hidden" name="registeredoffice_id" />
									<table>
										<tbody>
											<tr>
												<td width="90%">
													<div class="row">
														<div class="col-sm-4">
															<input type="text" name="registeredoffice_id" class="form-control input-sm" placeholder="#" value="" />
														</div>
														<div class="col-sm-4">
															<input type="text" name="registeredoffice_title_like" class="form-control input-sm" placeholder="Company name" value="" />
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
						<div class="fieldset">

							<div class="list-area">
								<form name="list" action="<?=base_url('cms/registeredoffice/delete')?>" method="post">
									<input type="hidden" name="registeredoffice_id" />
									<input type="hidden" name="registeredoffice_delete_reason" />
									<table class="list" id="registeredoffice">
										<tbody>
											<tr>
												<th>#</th>
												<th>
													<a href="<?=get_order_link('registeredoffice_title_en')?>">
														Title <i class="glyphicon glyphicon-sort corpcolor-font"></i>
													</a>
												</th>
												<th>
													<a href="<?=get_order_link('registeredoffice_title_tc')?>">
														Title <i class="glyphicon glyphicon-sort corpcolor-font"></i>
													</a>
												</th>
												<th>
													<a href="<?=get_order_link('registeredoffice_content_en')?>">
														Content <i class="glyphicon glyphicon-sort corpcolor-font"></i>
													</a>
												</th>
												<th>
													<a href="<?=get_order_link('registeredoffice_content_tc')?>">
														Content <i class="glyphicon glyphicon-sort corpcolor-font"></i>
													</a>
												</th>
												<th>
													<a href="<?=get_order_link('registeredoffice_modify')?>">
														Modify <i class="glyphicon glyphicon-sort corpcolor-font"></i>
													</a>
												</th>
												<th width="40"></th>
												<th width="40" class="text-right">
													<a href="<?=base_url('cms/registeredoffice/insert')?>" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Insert">
														<i class="glyphicon glyphicon-plus"></i>
													</a>
												</th>
											</tr>
											<?php foreach($registeredoffice as $key => $value){ ?>
											<tr id="<?=$value->registeredoffice_id?>" class="list-row contract" onclick=""> <!-- the onclick="" is for fixing the iphone problem -->
												<td title="<?=$value->registeredoffice_id?>"><?=$key+1?></td>
												<td class="expandable"><?=ucfirst($value->registeredoffice_title_en)?></td>
												<td class="expandable"><?=ucfirst($value->registeredoffice_title_tc)?></td>
												<td class="expandable"><?=ucfirst($value->registeredoffice_content_en)?></td>
												<td class="expandable"><?=ucfirst($value->registeredoffice_content_tc)?></td>
												<td class="expandable"><?=convert_datetime_to_date($value->registeredoffice_modify)?></td>
												<td class="text-right">
													<a href="<?=base_url('cms/registeredoffice/update/registeredoffice_id/'.$value->registeredoffice_id)?>" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Update">
														<i class="glyphicon glyphicon-pencil"></i>
													</a>
												</td>
												<td class="text-right">
													<a onclick="check_delete(<?=$value->registeredoffice_id?>);" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Delete">
														<i class="glyphicon glyphicon-remove"></i>
													</a>
												</td>
											</tr>
											<?php } ?>

											<?php if(!$registeredoffice){ ?>
											<tr class="list-row">
												<td colspan="8"><a href="#" class="btn btn-sm btn-primary">No record found</a></td>
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