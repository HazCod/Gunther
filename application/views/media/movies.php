<div class="col-sm-8 col-sm-offset-2">
	<ul class="breadcrumb">
	  <li>Gunther</li>
	  <li class="active">Movies</li>
	  <div class="pull-right">
		<a href="/movies/add">
			<i class="fa fa-plus-square-o fa-lg"></i>
          </a>
		&nbsp;&nbsp;
          <a href="/movies/busy">
			<i class="fa fa-clock-o fa-lg"></i>
		</a>
        </div>
	</ul>
	
	<? foreach ($this->movies as $movie): ?>
	<div class="col-sm-2" style="margin-top:10px;">
		<a href="/watch/index/<?= $movie->_id; ?>">
		<img class="imgscale" alt="<?= $movie->info->original_title ?>" src="<?= $movie->info->images->poster[0]; ?>" />
		</a>
	</div>
	<? endforeach; ?>
</div>
