<title>Images List</title>
<?php
include 'inc/header.php';

if(isset($_GET['delete'])) {
	delete('images', $_GET['delete']);
}
?>

<main id="main" class="main">

	<div class="pagetitle">
		<h1>Images</h1>
	</div><!-- End Page Title -->
	<section class="section">
		<div class="row">
			<div class="col-lg-12">

				<div class="card recent-sales overflow-auto">

					<div class="card-body">

						<table class="table table-borderless datatable">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Name</th>
									<th scope="col">URL</th>
									<th scope="col">Domain</th>
									<th scope="col">Created At</th>
									<th scope="col">Last Accessed</th>
									<th scope="col">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i=1;
								$images = fetch('images',null,'last_accessed');
								foreach($images as $img) {
								?>
								<tr>
									<td>#<?=$i?></td>
									<td><?=$img['name']?></td>
									<td><img src="<?=$img['url']?>?access=false" width="30" /></td>
									<td><?=$img['domain']?></td>
									<td><?=date('Y-m-d H:i:s', $img['created_at'])?></td>
									<td><?=date('Y-m-d H:i:s', $img['last_accessed'])?></td>
									<td>
										<!--<a href="button" class="btn btn-primary btn-sm">Edit</a>-->
										<a href="images-list.php?delete=<?=$img['id']?>" class="btn btn-outline-danger btn-sm">Delete</a>
									</td>
								</tr>
								<?php $i++;} ?>
							</tbody>
						</table>

					</div>

				</div>



			</div>
		</div>
	</section>

</main><!-- End #main -->

<?php include 'inc/footer.php';?>