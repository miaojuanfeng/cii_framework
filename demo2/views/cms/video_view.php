<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Video management</title>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

		<?php $this->load->view('cms/inc/head-area.php'); ?>

		<script>
		$(function(){
			$('input[name="video_id"]').focus();
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
				$('input[name="video_id"]').val(id);
				$('input[name="video_delete_reason"]').val(encodeURI(answer));
				$('form[name="list"]').submit();
			}else{
				return false;
			}
		}

		function login_as(id){
			$('input[name="video_id"]').val(id);
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

					<h2 class="col-sm-12"><a href="<?=base_url('cms/video')?>">Video management</a> > <?=ucfirst($this->router->fetch_method())?> video</h2>

					<div class="col-sm-12">
						<form method="post" enctype="multipart/form-data">
							<input type="hidden" name="video_id" value="<?=$video->video_id?>" />
							<input type="hidden" name="referrer" value="<?=$this->agent->referrer()?>" />
							<div class="fieldset">
								<div class="row">
									<div class="col-sm-4 col-xs-12 pull-right">
										<?php
										// if($this->router->fetch_method() == 'update'){
										// 	$video_photo_link = '/assets/uploads/video/'.$video->video_photo;
										// 	$video_photo = $_SERVER['DOCUMENT_ROOT'].'/minedition'.$video_photo_link;
										// 	if(file_exists($video_photo)){
										// 		echo '<h4 class="corpcolor-font">Video photo</h4>';
										// 		echo '<img class="box-bg" src="'.base_url($video_photo_link).'?'.time().'" />';
										// 	}
										// }
										?>
									</div>
									<div class="col-sm-4 col-xs-12">
										<h4 class="corpcolor-font">Basic information</h4>
										<p class="form-group">
											<label for="video_name">Name</label>
											<input id="video_name" name="video_name" type="text" class="form-control input-sm required" placeholder="Name" value="<?=$video->video_name?>" />
										</p>
									</div>
									<div class="col-sm-4 col-xs-12">
										<h4 class="corpcolor-font">Related information</h4>
										<p class="form-group">
											<label for="video_path">Path</label>
											<input id="video_path" name="video_path" type="text" class="form-control input-sm required" placeholder="Path" value="<?=$video->video_path?>" />
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

					<h2 class="col-sm-12">Video management</h2>

					<div class="content-column-area col-md-9 col-sm-12">

						<div class="fieldset left">
							<div class="search-area">

								<form video="form" method="get">
									<input type="hidden" name="video_id" />
									<table>
										<tbody>
											<tr>
												<td width="90%">
													<div class="row">
														<div class="col-sm-4">
															<input type="text" name="video_id" class="form-control input-sm" placeholder="#" value="" />
														</div>
														<div class="col-sm-4">
															<input type="text" name="video_name" class="form-control input-sm" placeholder="Name" value="" />
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
								<form name="list" action="<?=base_url('cms/video/delete')?>" method="post">
									<input type="hidden" name="video_id" />
									<input type="hidden" name="video_delete_reason" />
									<table class="list" id="video">
										<tbody>
											<tr>
												<th>#</th>
												<th>Name</th>
												<th>Modify</th>
												<th width="40"></th>
												<th width="40" class="text-right">
													<a href="<?=base_url('cms/video/insert')?>" class="btn btn-sm btn-primary disabled" data-toggle="tooltip" title="Insert">
														<i class="glyphicon glyphicon-plus"></i>
													</a>
												</th>
											</tr>
											<?php foreach($videos as $key => $value){ ?>
											<tr id="<?=$value->video_id?>" class="list-row" onclick=""> <!-- the onclick="" is for fixing the iphone problem -->
												<td title="<?=$value->video_id?>"><?=$key+1?></td>
												<td class="expandable"><a target='_blank' href='<?=$value->video_video?>'><?=$value->video_name?></a></td>
												<td class="expandable"><?=convert_datetime_to_date($value->video_modifydate)?></td>
												<td class="text-right">
													<a href="<?=base_url('cms/video/update/video_id/'.$value->video_id)?>" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Update">
														<i class="glyphicon glyphicon-pencil"></i>
													</a>
												</td>
												<td class="text-right">
													<a onclick="check_delete(<?=$value->video_id?>);" class="btn btn-sm btn-primary disabled" data-toggle="tooltip" title="Delete">
														<i class="glyphicon glyphicon-remove"></i>
													</a>
												</td>
											</tr>
											<?php } ?>

											<?php if(!$videos){ ?>
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