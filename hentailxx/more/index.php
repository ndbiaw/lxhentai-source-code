<?php

if(isset($_GET['check']) && $my['rights'] === 'admin')
{
  $path = ROOT.'/assets/hentai/';
  foreach (glob(ROOT.'/assets/hentai/*.jpg') as $filename) {
    $ten = preg_replace('/(.jpg)$/', '', explode('/', $filename)[6]);
    if(preg_match('/\:/', $ten)) {
      echo "{$ten}<br/>";
      $ten = mysqli_real_escape_string($conn, $ten);
      echo 'total : ', mysqli_num_rows(mysqli_query($conn, "select id from stories where thumb = '{$ten}'")), '<br/>';

      $thumb = str_replace(':', '', $ten);
      $from = $path.$ten.'.jpg';
      $to = $path.$thumb.'.jpg';
      if ($from != $to) {
        $rename = rename($from, $to);
        $update = mysqli_query($conn, "update stories set thumb = '{$thumb}' where thumb = '{$ten}'");
        cache_delete('stories');
        
        echo 'rename : ', ($rename?'ok':''), '<br/>';
        echo 'update : ', ($update?'ok':''), '<br/>';
      } else {
        echo 'khong thay doi', '<br/>';
      }      
    }
  }
  echo 'done!';
  exitx();
}


function swiper_html() {
  $html = '';
  $stories = do_cache('(stories)_stories_hot_30', function() {
      return query_mysql("select * from stories order by hot desc limit 30");
  }, 86400);        
  foreach(array_chunk($stories, 10) as $loop) {
      $card = '';
      foreach($loop as $s) {
          $card .= 
          '<div>
              <div class="itemSlide" onclick="window.location.href=\'/story/view.php?id='.$s['id'].'\'" style="background: url(\'/assets/hentai/'.$s['thumb'].'.jpg?\'); background-size: cover;">
                  <div class="newestChapter"><a href="/story/chapter.php?id='.$s['chapter_id'].'">'.sanitize_xss(character_by_id($s['chapter_id'])['name']).'</a></div>
              </div>
              <div class="slideName">
                  <a href="/story/view.php?id='.$s['id'].'">'. show_text(sanitize_xss($s['name'])) .'</a>
              </div>    
          </div>';
      }
      $html .= 
          '<div class="swiper-slide">
              <div class="gridSlide">'.$card.'</div>
          </div>';
  }

  if (!$html) return '';
  return 
  '<div class="truyenHot">
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
  $card = '';
  $story_duyet_60 = do_cache('(stories)_stories:duyet:1:60', function() {
      return query_mysql("select * from stories where duyet = 1 order by time desc limit 60");
  }, 86400);

  foreach($story_duyet_60 as $s) {
      $card .= 
      '<div class="col-md-3 col-6 py-2">
          <div onclick="window.location.href=\'/story/view.php?id='.$s['id'].'\'" style="background: url(\'/assets/hentai/'.$s['thumb'].'.jpg?\'); background-size: cover; height: 200px; border: 1px solid #ddd; background-position: center; position: relative">
              <div class="newestChapter"><a href="/story/chapter.php?id='.$s['chapter_id'].'">'.sanitize_xss(character_by_id($s['chapter_id'])['name']).'</a></div>
          </div>
          <a href="/story/view.php?id='.$s['id'].'">'.show_text(sanitize_xss($s['name'])).'</a>
      </div>';
  }
  return $card;
}

function comment_html() {
  $html = '';
  $comment = do_cache('(comment)_comment:0:15', function() {
      return query_mysql("select * from comment where sub = 0 order by id desc limit 15");
  }, 86400);
  
  foreach($comment as $c) {
      $html .= 
      '<div class="py-2" style="border-bottom: 1px solid #eee">
          <div class="ellipsis"><a href="/story/view.php?id='.$c['story_id'].'" style="">'.sanitize_xss(stories_by_id($c['story_id'])['name']).'</a></div>
          <div class="text-right ellipsis"><small style="color: #03f"><a href="/story/chapter.php?id='.$c['chapter_id'].'">'.sanitize_xss(character_by_id($c['chapter_id'])['name']).'</a></small></div>
          <div class="flexRow mt-2">
              <div><img src="/assets/images/avatar.php?id='.$c['user_id'].'" width="50px" style="border: 1px solid #eee"></div>
              <div class="pl-2 flex1">
                  <div class="flexRow">
                      <div class="flex1"><b style="">'.ucfirst(user_by_id($c['user_id'])['username']).'</b></div>
                      <div><abbr><i class="far fa-clock fa-fw"></i> <span>'.date('H:i d/m/y', $c['time']).'</span></abbr></div>
                  </div>
                  '.smileys($c['text']).'
              </div>
          </div>
      </div>';
  }
  return $html;
}