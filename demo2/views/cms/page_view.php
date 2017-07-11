<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Page management</title>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

		<?php $this->load->view('cms/inc/head-area.php'); ?>

		<script>
		$(function(){
			$('input[name="page_id"]').focus();

			/* pagination */
			$('.pagination-area>a, .pagination-area>strong').addClass('btn btn-sm btn-primary');
			$('.pagination-area>strong').addClass('disabled');
		});

		function check_delete(id){
			var answer = prompt("Confirm?");
			if(answer){
				$('input[name="page_id"]').val(id);
				$('input[name="page_delete_reason"]').val(encodeURI(answer));
				$('form[name="list"]').submit();
			}else{
				return false;
			}
		}

		function login_as(id){
			$('input[name="page_id"]').val(id);
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

					<h2 class="col-sm-12"><a href="<?=base_url('cms/page')?>">Page management</a> > <?=ucfirst($this->router->fetch_method())?> page</h2>

					<div class="col-sm-12">
						<form method="post" enctype="multipart/form-data">
							<input type="hidden" name="page_id" value="<?=$page->page_id?>" />
							<input type="hidden" name="referrer" value="<?=$this->agent->referrer()?>" />
							<div class="fieldset">
								<div class="row">
									
									<div class="col-sm-4 col-xs-12 pull-right">
										<h4 class="corpcolor-font">Basic information</h4>
										<p class="form-group">
											<?php if($this->router->fetch_method() == 'update'){ ?>
											<label for="page_photo">Page photo <span class="highlight">(460px * 406px)</span></label>
											<input id="page_photo" name="page_photo" type="file" accept="image/*" />
											<?php }else{ ?>
											<label for="page_photo">Page photo <span class="highlight">* (460px * 406px)</span></label>
											<input id="page_photo" name="page_photo" type="file" accept="image/*" class="required" />
											<?php } ?>
										</p>
										<?php
										if($this->router->fetch_method() == 'update'){
											$page_photo_link = '/assets/uploads/page/'.$page->page_id;
											$page_photo = $_SERVER['DOCUMENT_ROOT'].'/joy/km'.$page_photo_link;
											if(file_exists($page_photo)){
												echo '<h4 class="corpcolor-font">Page photo</h4>';
												echo '<img class="box-bg" src="'.base_url($page_photo_link).'?'.time().'" />';
											}
										}
										?>
									</div>
									<div class="col-sm-8 col-xs-12">
										<h4 class="corpcolor-font">Basic information</h4>
										<p class="form-group">
											<label for="page_title">Title <span class="highlight">*</span></label>
											<input id="page_title" name="page_title" type="text" class="form-control input-sm required" placeholder="Name" value="<?=$page->page_title?>" readonly="readonly" />
										</p>
										<p class="form-group">
											<label for="page_content">Content <span class="highlight">*</span></label>
											<textarea id="page_content" name="page_content" class="form-control input-sm required summernote" placeholder="Content"><?=$page->page_content?></textarea>
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col-xs-4">
										<button type="submit" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Save</button>
									</div>
									<div class="col-xs-4"></div>
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

					<h2 class="col-sm-12">Page management</h2>

					<div class="content-column-area col-md-9 col-sm-12">

						<div class="fieldset left">
							<div class="search-area">

								<form role="form" method="get">
									<input type="hidden" name="page_id" />
									<table>
										<tbody>
											<tr>
												<td width="90%">
													<div class="row">
														<div class="col-sm-4">
															<input type="text" name="page_id" class="form-control input-sm" placeholder="#" value="" />
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
								<form name="list" action="<?=base_url('cms/page/delete')?>" method="post">
									<input type="hidden" name="page_id" />
									<input type="hidden" name="page_delete_reason" />
									<table class="list" id="page">
										<tbody>
											<tr>
												<th>#</th>
												<th>
													<a href="<?=get_order_link('page_name')?>">
														Name <i class="glyphicon glyphicon-sort corpcolor-font"></i>
													</a>
												</th>
												<th>
													<a href="<?=get_order_link('page_modify')?>">
														Modify <i class="glyphicon glyphicon-sort corpcolor-font"></i>
													</a>
												</th>
												<th width="40"></th>
												<th width="40" class="text-right">
													
												</th>
											</tr>
											<?php foreach($pages as $key => $value){ ?>
											<tr id="<?=$value->page_id?>" class="list-row" onclick=""> <!-- the onclick="" is for fixing the iphone problem -->
												<td title="<?=$value->page_id?>"><?=$key+1?></td>
												<td class="expandable"><?=$value->page_title?></td>
												<td class="expandable"><?=convert_datetime_to_date($value->page_modifydate)?></td>
												<td class="text-right">
													<a href="<?=base_url('cms/page/update/page_id/'.$value->page_id)?>" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Update">
														<i class="glyphicon glyphicon-pencil"></i>
													</a>
												</td>
												<td class="text-right">
													<a onclick="check_delete(<?=$value->page_id?>);" class="btn btn-sm btn-primary disabled" data-toggle="tooltip" title="Delete">
														<i class="glyphicon glyphicon-remove"></i>
													</a>
												</td>
											</tr>
											<?php } ?>

											<?php if(!$pages){ ?>
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