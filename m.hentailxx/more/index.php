<?php

function swiper_html() {
  $html = '';

  $stories = do_cache('(stories)_stories_hot_18', function() {
      return query_mysql("select * from stories order by hot desc limit 18");
  }, 86400);     
  
  foreach(array_chunk($stories, 6) as $loop) {
      $card = '';
      foreach($loop as $s) {
          $card .= 
          '<div>
              <div class="itemSlide" onclick="window.location.href=\'/story/view.php?id='.$s['id'].'\'" style="background: url(\'//lxhentai.com/assets/hentai/'.$s['thumb'].'.jpg?\'); background-size: cover;">
                  <div class="newestChapter"><a href="/story/chapter.php?id='.$s['chapter_id'].'">'.sanitize_xss(character_by_id($s['chapter_id'])['name']).'</a></div>
              </div>
              <div class="slideName">
                  <a href="/story/view.php?id='.$s['id'].'">'. show_text(sanitize_xss($s['name'])) .'</a>
              </div>    
          </div>';
      }
      $html .= 
          '<div class="swiper-slide">
              <div class="gridSlideMob">'.$card.'</div>
          </div>';
  }

  if (!$html) return '';
  return 
  '<div class="truyenHot" style="background: #ffe9c8">
      <span><i class="fab fa-hotjar"></i> TRUYỆN HOT</span>
      <div class="hot">
          <div class="swiper-container">
          <div class="swiper-wrapper">      
          '.$html.'
          </div>
          <div class="swiper-pagination"></div>
          </div>
      </div>
  </div>';
}

function story_duyet_60_html() {  
  $story_duyet_60 = do_cache('(stories)_stories:duyet:1:60', function() {
      return query_mysql("select * from stories where duyet = 1 order by time desc limit 60");
  }, 86400);
  $card = '';
  foreach($story_duyet_60 as $s) {
      $card .= 
      '<div class="col-4 py-2 px-1">
            <div class="thumb_mob" onclick="window.location.href=\'/story/view.php?id='.$s['id'].'\'" style="background: url(\'//lxhentai.com/assets/hentai/'.$s['thumb'].'.jpg?\'); background-position: center; background-size: cover; ">
            </div>
            <a href="/story/view.php?id='.$s['id'].'">
                <b class="text-black">'.show_text(sanitize_xss($s['name'])).'</b><br/>
                <small><a href="/story/chapter.php?id='.$s['chapter_id'].'" class="text-black">'.sanitize_xss(character_by_id($s['chapter_id'])['name']).'</a></small>
            </a>
        </div>';
  }
  return $card;
}