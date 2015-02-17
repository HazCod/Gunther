<div class="col-md-6 col-md-offset-3">
        <ul class="breadcrumb">
          <li><?= $this->lang['title']; ?></li>
          <li class="active"><?= $this->lang['dashboard']; ?></li>
        </ul>

        <br>

        <h3><?= $this->lang['recentmovies']; ?></h3><hr>
        <div class="slider-movies">
            <? foreach ($this->movies as $movie): ?>
            <a href="/watch/index/<?= $movie->info->imdb; ?>">
	           <img class="owl-lazy" alt="<?= $movie->info->original_title; ?>" data-src="<?= $movie->info->images->poster[0]; ?>" />
            </a>
            <? endforeach; ?>
        </div>

        <br>
        
        <h3><?= $this->lang['recentepi']; ?></h3><hr>
        <div class="slider-series">
	        <img class="owl-lazy" data-src="http://ia.media-imdb.com/images/M/MV5BMTg5MjgzNTQyNl5BMl5BanBnXkFtZTgwNTgzNTEyNDE@._V1_SX214_AL_.jpg" />
	        <img class="owl-lazy" data-src="http://ia.media-imdb.com/images/M/MV5BMTg5MjgzNTQyNl5BMl5BanBnXkFtZTgwNTgzNTEyNDE@._V1_SX214_AL_.jpg" />
	        <img class="owl-lazy" data-src="http://ia.media-imdb.com/images/M/MV5BMTg5MjgzNTQyNl5BMl5BanBnXkFtZTgwNTgzNTEyNDE@._V1_SX214_AL_.jpg" />
	        <img class="owl-lazy" data-src="http://ia.media-imdb.com/images/M/MV5BMTg5MjgzNTQyNl5BMl5BanBnXkFtZTgwNTgzNTEyNDE@._V1_SX214_AL_.jpg" />
	        <img class="owl-lazy" data-src="http://ia.media-imdb.com/images/M/MV5BMTg5MjgzNTQyNl5BMl5BanBnXkFtZTgwNTgzNTEyNDE@._V1_SX214_AL_.jpg" />
        </div>
</div>