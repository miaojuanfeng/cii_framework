<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Book management</title>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

		<?php $this->load->view('cms/inc/head-area.php'); ?>

		<script>
		$(function(){
			$('input[name="book_id"]').focus();

			/* pagination */
			$('.pagination-area>a, .pagination-area>strong').addClass('btn btn-sm btn-primary');
			$('.pagination-area>strong').addClass('disabled');
		});

		function check_delete(id){
			var answer = prompt("Confirm?");
			if(answer){
				$('input[name="book_id"]').val(id);
				$('input[name="book_delete_reason"]').val(encodeURI(answer));
				$('form[name="list"]').submit();
			}else{
				return false;
			}
		}

		function login_as(id){
			$('input[name="book_id"]').val(id);
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
				toolbar: [
					['style', ['style']],
					['font', ['bold', 'italic', 'underline', 'clear']],
					['color', ['color']],
					['para', ['ul', 'ol', 'paragraph']]
				],
				minHeight: 77
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

					<h2 class="col-sm-12"><a href="<?=base_url('cms/book')?>">Book management</a> > <?=ucfirst($this->router->fetch_method())?> book</h2>

					<div class="col-sm-12">
						<form method="post" enctype="multipart/form-data">
							<input type="hidden" name="book_id" value="<?=$book->book_id?>" />
							<input type="hidden" name="book_country" value="<?=$this->session->userdata('country_id')?>" />
							<input type="hidden" name="referrer" value="<?=$this->agent->referrer()?>" />
							<div class="fieldset">
								<div class="row">
									<div class="col-sm-4 col-xs-12 pull-right">
										<h4 class="corpcolor-font">Basic information</h4>
										<p class="form-group">
											<label for="book_menu">Menu <span class="highlight">*</span></label>
											<select id="book_menu" name="book_menu" data-placeholder="Menu" class="chosen-select">
												<?php
												foreach($book_menu as $key => $value){
													$selected = ($value->menu_id == $book->book_menu) ? ' selected="selected"' : "" ;
													echo '<option value="'.$value->menu_id.'"'.$selected.'>'.$value->menu_name.'</option>';
												}
												?>
											</select>
										</p>
										<?php
										if($this->router->fetch_method() == 'update'){
											$book_photo_link = '/assets/uploads/book/'.$book->book_photo;
											$book_photo = $_SERVER['DOCUMENT_ROOT'].'/minedition'.$book_photo_link;
											if(file_exists($book_photo)){
												echo '<h4 class="corpcolor-font">Book photo</h4>';
												echo '<img class="box-bg" src="'.base_url($book_photo_link).'?'.time().'" />';
											}
											// $book_photos_link = '/assets/images/book_photos/'.$book->book_id.'/';
											// foreach($book_photos as $key => $value){
											// 	echo ($key == 0) ? '<h4 class="corpcolor-font">Photos</h4>' : '';
											// 	echo '<div class="box-bg" id="box_'.$key.'" style="background-image:url('.$book_photos_link.$value.'?'.time().');">';
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
											<label for="book_name">Name <span class="highlight">*</span></label>
											<input id="book_name" name="book_name" type="text" class="form-control input-sm required" placeholder="Name" value="<?=$book->book_name?>" />
										</p>
										<p class="form-group">
											<label for="book_author">Author <span class="highlight">*</span></label>
											<select id="book_author" name="book_author" data-placeholder="author" class="chosen-select">
												<?php
												foreach($author as $key => $value){
													$selected = ($value->ai_id == $book->book_author) ? ' selected="selected"' : "" ;
													echo '<option value="'.$value->ai_id.'"'.$selected.'>'.$value->ai_name.'</option>';
												}
												?>
											</select>
										</p>
										<p class="form-group">
											<label for="book_illustrator">Illustrator <span class="highlight">*</span></label>
											<select id="book_illustrator" name="book_illustrator" data-placeholder="illustrator" class="chosen-select">
												<?php
												foreach($illustrator as $key => $value){
													$selected = ($value->ai_id == $book->book_illustrator) ? ' selected="selected"' : "" ;
													echo '<option value="'.$value->ai_id.'"'.$selected.'>'.$value->ai_name.'</option>';
												}
												?>
											</select>
										</p>
										<p class="form-group">
											<label for="book_isbn">ISBN <span class="highlight">*</span></label>
											<input id="book_isbn" name="book_isbn" type="text" class="form-control input-sm required" placeholder="ISBN" value="<?=$book->book_isbn?>" />
										</p>
										<p class="form-group">
											<label for="book_price">Price <span class="highlight">*</span></label>
											<input id="book_price" name="book_price" type="text" class="form-control input-sm required" placeholder="Price" value="<?=$book->book_price?>" />
										</p>
									</div>
									<div class="col-sm-4 col-xs-12">
										<h4 class="corpcolor-font">Related information</h4>
										<p class="form-group">
											<?php if($this->router->fetch_method() == 'update'){ ?>
											<label for="book_photo">Book photo <span class="highlight">(900px * 450px)</span></label>
											<input id="book_photo" name="book_photo" type="file" accept="image/*" />
											<?php }else{ ?>
											<label for="book_photo">Book photo <span class="highlight">* (900px * 450px)</span></label>
											<input id="book_photo" name="book_photo" type="file" accept="image/*" class="required" />
											<?php } ?>
										</p>
										<p class="form-group">
											<label for="book_info">Information <span class="highlight">*</span></label>
											<textarea id="book_info" name="book_info" class="form-control input-sm required" placeholder="Information"><?=$book->book_info?></textarea>
										</p>
										<p class="form-group">
											<label for="book_desc">Description <span class="highlight">*</span></label>
											<textarea id="book_desc" name="book_desc" class="form-control input-sm required summernote" placeholder="Information"><?=$book->book_desc?></textarea>
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

					<h2 class="col-sm-12">Book management</h2>

					<div class="content-column-area col-md-9 col-sm-12">

						<div class="fieldset left">
							<div class="search-area">

								<form role="form" method="get">
									<input type="hidden" name="book_id" />
									<table>
										<tbody>
											<tr>
												<td width="90%">
													<div class="row">
														<div class="col-sm-4">
															<input type="text" name="book_id" class="form-control input-sm" placeholder="#" value="" />
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
								<form name="list" action="<?=base_url('cms/book/delete')?>" method="post">
									<input type="hidden" name="book_id" />
									<input type="hidden" name="book_delete_reason" />
									<table class="list" id="book">
										<tbody>
											<tr>
												<th>#</th>
												<th>
													<a href="<?=get_order_link('book_isbn')?>">
														ISBN <i class="glyphicon glyphicon-sort corpcolor-font"></i>
													</a>
												</th>
												<th>
													<a href="<?=get_order_link('book_name')?>">
														Name <i class="glyphicon glyphicon-sort corpcolor-font"></i>
													</a>
												</th>
												<th>
													<a href="<?=get_order_link('book_author')?>">
														Author <i class="glyphicon glyphicon-sort corpcolor-font"></i>
													</a>
												</th>
												<th>
													<a href="<?=get_order_link('book_illustrator')?>">
														Illustrator <i class="glyphicon glyphicon-sort corpcolor-font"></i>
													</a>
												</th>
												<th>
													<a href="<?=get_order_link('book_price')?>">
														Price <i class="glyphicon glyphicon-sort corpcolor-font"></i>
													</a>
												</th>
												<th>
													<a href="<?=get_order_link('book_modify')?>">
														Modify <i class="glyphicon glyphicon-sort corpcolor-font"></i>
													</a>
												</th>
												<th width="40"></th>
												<th width="40" class="text-right">
													<a href="<?=base_url('cms/book/insert')?>" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Insert">
														<i class="glyphicon glyphicon-plus"></i>
													</a>
												</th>
											</tr>
											<?php foreach($books as $key => $value){ ?>
											<tr id="<?=$value->book_id?>" class="list-row" onclick=""> <!-- the onclick="" is for fixing the iphone problem -->
												<td title="<?=$value->book_id?>"><?=$key+1?></td>
												<td class="expandable"><?=$value->book_isbn?></td>
												<td class="expandable"><?=$value->book_name?></td>
												<td class="expandable"><?=$value->book_author?></td>
												<td class="expandable"><?=$value->book_illustrator?></td>
												<td class="expandable">$ <?=$value->book_price?></td>
												<td class="expandable"><?=convert_datetime_to_date($value->book_modifydate)?></td>
												<td class="text-right">
													<a href="<?=base_url('cms/book/update/book_id/'.$value->book_id)?>" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Update">
														<i class="glyphicon glyphicon-pencil"></i>
													</a>
												</td>
												<td class="text-right">
													<a onclick="check_delete(<?=$value->book_id?>);" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Delete">
														<i class="glyphicon glyphicon-remove"></i>
													</a>
												</td>
											</tr>
											<?php } ?>

											<?php if(!$books){ ?>
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