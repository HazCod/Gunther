<div class="col-md-8 col-md-offset-2">
	<ul class="breadcrumb">
	  <li>Gunther</li>
	  <li class="active">Inactive Movies</li>
	  <div class="pull-right">
		<a href="/movies/add">
			<i class="fa fa-plus-square-o fa-lg"></i>
          </a>
		&nbsp;&nbsp;
          <a href="/movies/index">
			<i class="fa fa-th-list fa-lg"></i>
		</a>
        </div>
	</ul>
	
	<? foreach ($this->movies as $movie): ?>
	<div class="col-sm-2" style="margin-top:10px;">
		<img class="grey-inactive imgscale" alt="<?= $movie->info->original_title ?>" src="<?= $movie->info->images->poster[0]; ?>" />
	</div>
	<? endforeach; ?>
</div>