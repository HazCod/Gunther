<div class="col-sm-8 col-sm-offset-2">
	<ul class="breadcrumb">
	  <li><?= $this->lang['title']; ?></li>
	  <li class="active"><?= $this->lang['movies']; ?></li>
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

	<?php $this->renderPartial('flashmessage'); ?>

	<form method="post" action="/movies/index">
    <div class="input-group">
      <input type="text" class="form-control" placeholder="<?= $this->lang['searchmovie']; ?>" name="search" value="<?php if ($this->searchterm){ echo $this->searchterm; } ?>">
      <span class="input-group-btn">
        <button class="btn btn-default" type="submit"><i class="fa fa-search fa-lg"></i></button>
        <a href="/movies/index" class="btn btn-default" type="button"><i class="fa fa-list fa-lg"></i></a>
      </span>
    </div>
	</form>

    <br>
	
	<?php if ($this->movies): ?>
	<?php foreach ($this->movies as $movie): ?>
	<div class="col-sm-2" style="margin-top:10px;">
		<a href="/info/movie/<?= $movie->id; ?>">
			<img class="imgscale<?php if ($movie->status == 'active'){ echo ' grey-inactive';} ?>" alt="<?= $movie->name; ?>" data-src="<?php if ($movie->images['poster'] != false) { echo $movie->images['poster']; } else { echo 'http://www.clipartbest.com/cliparts/9T4/ep4/9T4ep4xac.png'; }; ?>" />
		</a>
	</div>
	<?php endforeach; ?>
	<?php else: ?>
	<p>
		<?= $this->lang['nomovies']; ?>
	</p>
	<p>
		<a href="/movies/search"><?= $this->lang['oraddit']; ?></a>
	</p>
	<?php endif; ?>
</div>
