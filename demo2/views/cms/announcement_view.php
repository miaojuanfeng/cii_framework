<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Announcements</title>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

		<?php $this->load->view('cms/inc/head-area.php'); ?>

		<script>
		$(function(){
			$('input[name="announcement_id"]').focus();
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
				$('input[name="announcement_id"]').val(id);
				$('input[name="announcement_delete_reason"]').val(encodeURI(answer));
				$('form[name="list"]').submit();
			}else{
				return false;
			}
		}

		function login_as(id){
			$('input[name="announcement_id"]').val(id);
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

					<h2 class="col-sm-12"><a href="<?=base_url('cms/announcement')?>">Announcements</a> > <?=ucfirst($this->router->fetch_method())?> announcement</h2>

					<div class="col-sm-12">
						<form method="post" enctype="multipart/form-data">
							<input type="hidden" name="announcement_id" value="<?=$announcement->announcement_id?>" />
							<input type="hidden" name="referrer" value="<?=$this->agent->referrer()?>" />
							<div class="fieldset">
								<div class="row">
									
									<div class="col-sm-4 col-xs-12 pull-right">
										<blockquote>
											<h4 class="corpcolor-font">Instruction</h4>
											<p><span class="highlight">*</span> is the required field</p>
										</blockquote>
									</div>
									<div class="col-sm-4 col-xs-12">
										<h4 class="corpcolor-font">Basic information</h4>
										<p class="form-group">
											<label for="">Category</label>
											<select id="announcement_category_id" name="announcement_category_id" data-placeholder="Category" class="chosen-select">
												<option value></option>
												<?php
												foreach($categorys as $key1 => $value1){
													$selected = ($value1->category_id == $announcement->announcement_category_id) ? ' selected="selected"' : "" ;
													echo '<option value="'.$value1->category_id.'"'.$selected.'>'.$value1->category_name_en.' - '.$value1->category_name_tc.'</option>';
												}
												?>
											</select>
										</p>
										<p class="form-group">
											<label for="announcement_year">Year</label>
											<input name="announcement_year" type="text" class="form-control input-sm" placeholder="Year" value="<?=($announcement->announcement_year != 0) ? $announcement->announcement_year : date('Y')?>" />
										</p>
										<p class="form-group">
											<label for="announcement_date">Date</label>
											<input name="announcement_date" type="text" class="form-control input-sm" placeholder="Date" value="<?=($announcement->announcement_date != '') ? $announcement->announcement_date : date('Y-m-d')?>" />
										</p>
										<p class="form-group">
											<label for="announcement_name_en">Name(EN) <span class="highlight">*</span></label>
											<input id="announcement_name_en" name="announcement_name_en" type="text" class="form-control input-sm required" placeholder="Name(EN)" value="<?=$announcement->announcement_name_en?>" />
										</p>
										<p class="form-group">
											<label for="announcement_name_tc">Name(TC) <span class="highlight">*</span></label>
											<input id="announcement_name_tc" name="announcement_name_tc" type="text" class="form-control input-sm required" placeholder="Name(TC)" value="<?=$announcement->announcement_name_tc?>" />
										</p>
									</div>
									<div class="col-sm-4 col-xs-12">
										<h4 class="corpcolor-font">Related information</h4>
										<p class="form-group">
											<label for="announcement_hkex_en">HKEX PDF link(EN) <span class="highlight">*</span></label>
											<input id="announcement_hkex_en" name="announcement_hkex_en" type="text" class="form-control input-sm required" placeholder="HKEX PDF link(EN)" value="<?=$announcement->announcement_hkex_en?>" />
										</p>
										<p class="form-group">
											<label for="pdf_en">PDF(EN)</label>
											<input id="pdf_en" name="pdf_en" type="file" accept="application/pdf" />
										</p>
										<p class="form-group">
											<label for="announcement_hkex_tc">HKEX PDF link(TC) <span class="highlight">*</span></label>
											<input id="announcement_hkex_tc" name="announcement_hkex_tc" type="text" class="form-control input-sm required" placeholder="HKEX PDF link(TC)" value="<?=$announcement->announcement_hkex_tc?>" />
										</p>
										<p class="form-group">
											<label for="pdf_tc">PDF(TC)</label>
											<input id="pdf_tc" name="pdf_tc" type="file" accept="application/pdf" />
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

					<h2 class="col-sm-12">Announcements</h2>

					<div class="content-column-area col-md-12 col-sm-12">

						<div class="fieldset">
							<div class="search-area">

								<form announcement="form" method="get">
									<input type="hidden" name="announcement_id" />
									<table>
										<tbody>
											<tr>
												<td width="90%">
													<div class="row">
														<div class="col-sm-4">
															<input type="text" name="announcement_id" class="form-control input-sm" placeholder="#" value="" />
														</div>
														<div class="col-sm-4">
															<input type="text" name="announcement_name_like" class="form-control input-sm" placeholder="Name" value="" />
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
								<form name="list" action="<?=base_url('cms/announcement/delete')?>" method="post">
									<input type="hidden" name="announcement_id" />
									<input type="hidden" name="announcement_delete_reason" />
									<table class="list" id="announcement">
										<tbody>
											<tr>
												<th>#</th>
												<th>
													<a href="<?=get_order_link('announcement_category_id')?>">
														Category <i class="glyphicon glyphicon-sort corpcolor-font"></i>
													</a>
												</th>
												<th>
													<a href="<?=get_order_link('announcement_year')?>">
														Year <i class="glyphicon glyphicon-sort corpcolor-font"></i>
													</a>
												</th>
												<th>
													<a href="<?=get_order_link('announcement_date')?>">
														Date <i class="glyphicon glyphicon-sort corpcolor-font"></i>
													</a>
												</th>
												<th>
													<a href="<?=get_order_link('announcement_name_en')?>">
														Name(EN) <i class="glyphicon glyphicon-sort corpcolor-font"></i>
													</a>
												</th>
												<th>
													<a href="<?=get_order_link('announcement_name_tc')?>">
														Name(TC) <i class="glyphicon glyphicon-sort corpcolor-font"></i>
													</a>
												</th>
												<th>
													<a href="<?=get_order_link('announcement_modify')?>">
														Modify <i class="glyphicon glyphicon-sort corpcolor-font"></i>
													</a>
												</th>
												<th width="40"></th>
												<th width="40" class="text-right">
													<a href="<?=base_url('cms/announcement/insert')?>" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Insert">
														<i class="glyphicon glyphicon-plus"></i>
													</a>
												</th>
											</tr>
											<?php foreach($announcements as $key => $value){ ?>
											<tr id="<?=$value->announcement_id?>" class="list-row contract" onclick=""> <!-- the onclick="" is for fixing the iphone problem -->
												<td title="<?=$value->announcement_id?>"><?=$key+1?></td>
												<td class="expandable"><?=get_category($value->announcement_category_id)->category_name_en?></td>
												<td class="expandable"><?=$value->announcement_year?></td>
												<td class="expandable"><?=$value->announcement_date?></td>
												<td class="expandable"><?=ucfirst($value->announcement_name_en)?></td>
												<td class="expandable"><?=ucfirst($value->announcement_name_tc)?></td>
												<td class="expandable"><?=convert_datetime_to_date($value->announcement_modify)?></td>
												<td class="text-right">
													<a href="<?=base_url('cms/announcement/update/announcement_id/'.$value->announcement_id)?>" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Update">
														<i class="glyphicon glyphicon-pencil"></i>
													</a>
												</td>
												<td class="text-right">
													<a onclick="check_delete(<?=$value->announcement_id?>);" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Delete">
														<i class="glyphicon glyphicon-remove"></i>
													</a>
												</td>
											</tr>
											<?php } ?>

											<?php if(!$announcements){ ?>
											<tr class="list-row">
												<td colspan="9"><a href="#" class="btn btn-sm btn-primary">No record found</a></td>
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