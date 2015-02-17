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

	<? $this->renderPartial('flashmessage'); ?>

	<form method="post" action="/movies/index">
    <div class="input-group">
      <input type="text" class="form-control" placeholder="Search for a movie" name="search" value="<? if ($this->searchterm){ echo $this->searchterm; } ?>">
      <span class="input-group-btn">
        <button class="btn btn-default" type="submit"><i class="fa fa-search fa-lg"></i></button>
        <a href="/movies/index" class="btn btn-default" type="button"><i class="fa fa-list fa-lg"></i></a>
      </span>
    </div>
	</form>

    <br>
	
	<? foreach ($this->movies as $movie): ?>
	<div class="col-sm-2" style="margin-top:10px;">
		<a href="/watch/index/<?= $movie->_id; ?>">
		<? if ($movie->status == 'done'): ?>
		<img class="imgscale" alt="<?= $movie->info->original_title ?>" src="<?= $movie->info->images->poster[0]; ?>" />
		<? else: ?>
		<img class="imgscale grey-inactive" alt="<?= $movie->info->original_title ?>" src="<?= $movie->info->images->poster[0]; ?>" />
		<? endif; ?>
		</a>
	</div>
	<? endforeach; ?>
</div>