<?php

class Watch extends Core_controller
{

    public function __construct()
    {
        parent::__construct(true);
        //set our partials in the template
        $this->template->setPartial('navbar')
            ->setPartial('headermeta')
            ->setPartial('footer')
            ->setPartial('flashmessage');

        //set page title
        $this->template->setPagetitle($this->lang['title']);	

        include(APPLICATION_PATH . 'includes/VideoStream.php');
    }

    private function streamMovie($id){
        $movie = $this->mediamodel->getMovie($id); 
        if ($movie && file_exists($movie->releases[0]->files->movie[0])){
            $stream = new VideoStream($movie->releases[0]->files->movie[0]);
            return $stream->start();
        } else {
            header("HTTP/1.0 404 Not Found");
            return '404 - File Not Found';
        }
    }

    private function streamShow($id){
        $parts = explode('-', $id);
        $serie_id = $parts[0];
        $season_id = $parts[1];
        $episode_id = $parts[2];
        $serie = $this->mediamodel->getEpisode($serie_id, $season_id, $episode_id);
        if ($serie and file_exists($serie->location) and (strcmp($serie->location, '') != 0)){
            $stream = new VideoStream($serie->location);
            return $stream->start();
        } else {
            header("HTTP/1.0 404 Not Found");
            return '404 - File Not Found';
        }
    }

    public function getmovie($id){
        return $this->offerFile($this->mediamodel->getMovie($id)->releases[0]->files->movie[0]);
    }

   public function stream($id=false){

        $prefix = substr($id, 0, 2);
        if (strcmp($prefix, 'ss') == 0){
            #custom id, so tv show
            return $this->streamShow(substr($id, 2));
        } else {
            return $this->streamMovie($id);
        }
   }

   private function getMovieSub($id, $lang){
        $subfile = false;
        $movie = $this->mediamodel->getMovie($id);
        $filepath = $movie->releases[0]->files->movie[0];
        $moviename = substr(basename($filepath), 0, strlen(basename($filepath))-4);
        $sub = dirname($filepath) . '/' . $moviename . '.' . $lang . '.srt';
        if (file_exists($sub)){
            $subfile = $sub;
        } else {
            # try without a lang, so movie.srt
            $sub = dirname($filepath) . '/' . $moviename . '.srt';
            if (file_exists($sub)){
                $subfile = $sub;
            }
        }
        return $subfile;
   }

   private function getShowSub($id, $lang){
        $subfile = false;
        $parts = explode('-', $id);
        $serie_id = $parts[0];
        $season_id = $parts[1];
        $episode_id = $parts[2];
        $episode = $this->mediamodel->getEpisode($serie_id, $season_id, $episode_id);
        $filepath= $episode->location;

        $showname = substr(basename($filepath), 0, strlen(basename($filepath))-4);
        $sub = dirname($filepath) . '/' . $showname . '.' . $lang . '.srt';
        if (file_exists($sub)){
            $subfile = $sub;
        } else {
            # try without a lang, so movie.srt
            $sub = dirname($filepath) . '/' . $showname . '.srt';
            if (file_exists($sub)){
                $subfile = $sub;
            }
        }
        return $subfile; 
   }

   public function sub($id=false, $lang=false){
        if (substr_count($id, '-') > 0){
            #custom id, so tv show
            $subfile = $this->getShowSub($id, $lang);
        } else {
            $subfile = $this->getMovieSub($id, $lang);
        }
        return $this->offerFile($subfile);
   }

   private function offerFile($file){
        if ($file and file_exists($file)){
            header('Content-Type: application/download');
            header('Content-Type: ' . $this->mediamodel->getMimeType($file));
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
            header("Content-Length: " . filesize($file));
            header("Pragma: public");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            $fp = fopen($file, "r");
            fpassthru($fp);
            fclose($fp);
        } else {
            $this->setFlashmessage('File not found', 'danger');
            $this->redirect('dashboard/index');
        }
   }


   private function watchMovie($id){
        $movie = $this->mediamodel->getMovie($id);
        if ($movie && $movie->releases && (count($movie->releases) >0) && $movie->releases[0]->files && file_exists($movie->releases[0]->files->movie[0])){
            $filepath = $movie->releases[0]->files->movie[0];
            $this->template->file = $id;
            $this->template->type = $this->mediamodel->getMimeType($filepath);
            $this->template->codec= $this->mediamodel->getCodecInfo($filepath)['videoCodec'];
            $subs = array();
            foreach (glob(dirname($filepath) . '/*.srt') as $sub){
                $lang='en';
                if (substr_count(basename($sub), '.') > 1){
                    $lang = substr($sub, strlen($sub)-6, 2);
                }
                array_push($subs, $lang);
            }
            $this->template->streamstr = $id;
            $this->template->subs = array_unique($subs);
            $this->template->setPagetitle($movie->info->original_title . ' - Gunther');
            $this->template->render('media/watch');
        } else {
            $this->setFlashmessage($this->lang['movienotfound'], 'danger');
            if ($movie){
                error_log("Movie not found: " . $movie->releases[0]->files->movie[0]);
            }
            $this->redirect('movies/index');
        }
   }

   private function watchShow($id){
        $parts = explode('-', $id);
        $serie_id = $parts[0];
        $season_id = $parts[1];
        $episode_id = $parts[2];
        $episode = $this->mediamodel->getEpisode($serie_id, $season_id +1, $episode_id +1); #no zero
        if ($episode && file_exists($episode->location)){
            $this->template->file = $id;
            $this->template->type = $this->mediamodel->getMimeType($episode->location);
            $this->template->codec = $this->mediamodel->getCodecInfo($episode->location)['videoCodec'] . ',' . $this->mediamodel->getCodecInfo($episode->location)['audioCodec'];
            $this->template->streamstr = 'ss' . $id;
            $subs = array();
            foreach (glob(dirname($episode->location) . '/*.srt') as $sub){
                $lang='en';
                if (substr_count(basename($sub), '.', 0) > 1){
                    $lang = substr($sub, strlen($sub)-6, 2);
                }
                array_push($subs, $lang);
            }
            $this->template->subs = array_unique($subs);
            $this->template->setPagetitle($episode->name . ' - ' . $this->lang['title']);
            $this->template->render('media/watch');
        } else {
            $this->setFlashmessage($this->lang['shownotfound'], 'danger');
            if ($episode){
                error_log("Episode not found: " . $episode->location);
            }
            $this->redirect('series/index');
        }
   }

    public function index($id=false)
    {
        $prefix = substr($id, 0, 2);
        if (strcmp($prefix, 'ss') == 0){
            #custom id, so tv show
            $this->watchShow(substr($id, 2));
        } else {
            $this->watchMovie($id);
        }
    }


}
