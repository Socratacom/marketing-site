<?php $asset_url = rwmb_meta( 'downloads_asset' ); ?>
<section class="background-light-grey-4" style="height:100vh; margin-top:-60px;">
	<div class="vertical-center">
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-4">
					<div class="dialog">
						<div class="dialog-header">
							<h4>Thank you for registering</h4>
						</div>
						<div class="dialog-body">
							<p>You can now download "<strong><?php the_title(); ?></strong>".</p>
							<a href="<?php foreach ( $asset_url as $asset ) { echo $asset['url']; } ?>" target="_blank" class="btn btn-primary btn-lg btn-block">Download</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>