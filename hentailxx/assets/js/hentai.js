window.addEventListener('scroll', function() {
  if (window.pageYOffset > 0)
    $('#goTop').fadeIn();
  else
    $('#goTop').fadeOut();
});

$('#goTop').click(function() {
  var body = $("html, body");
  body.stop().animate({
    scrollTop: 0
  }, 300, 'swing');
});

function home(folder, mobile)
{
	if(folder == 'new')
	{
		$('#home_more').attr('href', '/story/');
	} else {
		$('#home_more').attr('href', '/story/cat.php?id='+folder);
		var e = $('#pills-'+folder+' .row');
		if(e.html().trim() == '')
		{
			toastr['info']('Chờ lấy danh sách truyện...');
			$.ajax({
				url: '/dashboard/api.php?act=get_home_tab&id='+folder,
				success: function(r)
				{
					var data = $.parseJSON(r);
					var html = '';
					
					for(value of data){
						if(!mobile)
						html += '<div class="col-md-3 col-6 py-2"><div onclick="window.location.href=\'/story/view.php?id='+value.id+'\'" style="background: url(\'/assets/hentai/'+value.thumb+'.jpg?\'); background-size: cover; height: 200px; border: 1px solid #ddd; background-position: center; position: relative">'
            + (value.chapter_id != null ? '<div class="newestChapter"><a href="/story/chapter.php?id='+value.chapter_id+'">'+value.chapter_name+'</a></div>' : '')+'</div><a href="/story/view.php?id='+value.id+'">'+value.name+'</div>';
						else
						html += '<div class="col-4 px-1 py-2"><div class="thumb_mob" onclick="window.location.href=\'/story/view.php?id='+value.id+'\'" style="background: url(\'//lxhentai.com/assets/hentai/'+value.thumb+'.jpg?\'); background-size: cover; background-position: center; ">'
            +'</div><a href="/story/view.php?id='+value.id+'" class="text-black">'+value.name+'<br/><small>' + (value.chapter_id != null ? '<a href="/story/chapter.php?id='+value.chapter_id+'" class="text-black">'+value.chapter_name+'</a></small></div>' : '</small></div>');
					}
					
					$('#pills-'+folder+' .row').html(html);
				}
			});
			console.log('loaded !');
		}
	}
}

function showMenu(obj){
    $(obj).hide();
    $('.headerUserBar .fa-times').show();
    $('#menuMobile').show();
  }
  
  function hideMenu(obj){
    $(obj).hide();
    $('.headerUserBar .fa-bars').show();
    $('#menuMobile').hide();
  }
  
  function db_toggle(){
    $('.db_utils').toggle();
    if($('.db_utils').is(':visible'))
        $('.db_toggle').html('<i class="fa active fa-angle-down"></i>');
      else 
        $('.db_toggle').html('<i class="fa active fa-angle-up"></i>');
  }
  
  function delete_category(id)
  {
    var wait = confirm('Bạn có chắc chắn muốn xóa thư mục này ?!');
    if(wait === true)
      window.location.href = 'admin.php?page=category&delete='+id;
  }
  
  function edit_category(id, name)
  {
    var wait = prompt('Nhập tên mới', name);
    if(wait.trim() != '')
      {
        window.location.href = 'admin.php?page=category&id='+id+'&name='+wait;
      }
  }
  
  function add_category()
  {
    var wait = prompt('Tạo chuyên mục mới', '');
    if(wait.trim() != '')
    {
      window.location.href= 'admin.php?page=category&newFolder='+wait;
    }
  }
  
  function user_ban(id)
  {
       var wait = confirm('Bạn có muốn Ban/Unban thành viên ?');
    if(wait === true)
      window.location.href = 'admin.php?page=users&ban='+id;
  }
  
  function user_delete_story(id)
  {
      var wait = confirm('Bạn có chắc chắn muốn xóa truyện này ?');
      if(wait === true)
      {
          $.ajax({
              url: '/dashboard/api.php?act=user_delete_story&id='+id,
              success: function(){
                  $('#story_'+id).remove();
                  toastr["success"]("Xóa thành công!");
              }
          })
      }
  }

  function admin_delete_comment(id)
  {
      var wait = confirm('Bạn có chắc chắn muốn xóa bình luận này ?');
      if(wait === true)
      {
          $.ajax({
              url: '/dashboard/api.php?act=admin_delete_comment&id='+id,
              success: function(){
                  $('#bl_'+id).remove();
                  toastr["success"]("Xóa thành công!");
              }
          })
      }
  }

  
  function admin_duyet_story(id)
  {
    var wait = confirm('Bạn có chắc chắn muốn DUYỆT truyện này ?');
    if(wait === true)
    {
        $.ajax({
            url: '/dashboard/api.php?act=admin_duyet_story&id='+id,
            success: function(){
                $('#story_'+id).remove();
                toastr["success"]("Duyệt thành công!");
            }
        })
    }
  }
  
function divideFile(e)
{
    var html = '';
    for(var i = 0; i < e.target.files.length; i++)
    {   
        var obj = e.target.files[i];
        try {
            if (obj.type != 'image/png' && obj.type != "image/jpeg" && obj.type != "image/gif") {
                $(obj).val('');
                toastr['error']('Trang '+(i+1)+' không hợp lệ !');
                html += '<div class="col-md-3 px-1 py-1">File không hợp lệ. ('+obj.name+')</div>';
            } else
                html += '<div class="col-md-3 text-center px-1 py-1"><img src="'+URL.createObjectURL(obj)+'" /></div>';
        } catch(e) {
            html += '<div class="col-md-3 px-1 py-1">Trang lỗi ('+obj.name+')</div>';
        }   
    }
    $('#mangaPreview').html(html);
}

function admin_switch_post()
{
	if($('#htmlMode').is(':visible'))
	{
        $('#htmlMode').hide();
        $('#uploadMode').show();
	} else {
        $('#htmlMode').show();
        $('#uploadMode').hide();
    }
}

function user_follow_story(id)
{
    $.ajax({
        url: '/dashboard/api.php?act=user_follow_story&id='+id,
        success: function(r)
        {
            if(r == 0)
            {
                toastr['error']('Bạn cần đăng nhập để theo dõi truyện này !');
            } else if (r == 1)
            {
                toastr['success']('Bỏ theo dõi truyện thành công !');
                $('#story_follow_btn').show();
                $('#story_unfollow_btn').hide();
                $('#story_follow_count').html(Number($('#story_follow_count').html())-1);
            } else {
                toastr['success']('Theo dõi truyện thành công !');
                $('#story_follow_btn').hide();
                $('#story_unfollow_btn').show();
                $('#story_follow_count').html(Number($('#story_follow_count').html())+1);
            }
        }
    })
}

function insertComment(content)
{
content = ' :'+content+': ';
document.getElementById('bigComment').value += content;
$('#bigComment').focus();
}

function viewmore(){
$('#listChuong').css('max-height', 'initial');
$('.viewmore').hide();
}

  $(function(){
    $('[data-toggle="tooltip"]').tooltip();
    for(var i = 0; i < document.querySelectorAll('a').length; i++)
    {
        if(document.querySelectorAll('a')[i].href.match(/\?/))
            document.querySelectorAll('a')[i].href += '&token='+btoa(Math.random()).replace(/=/g,'v')+btoa(Math.random()).replace(/=/g,'v');
    }
  })
  
function printSubCommentForm(id) {
    return ('<form onsubmit="postSubComment(event, '+id+')" class="subCommentForm"><div class="flexRow"><div class="flex1"><input type="text" class="w-100" placeholder="Nhập câu trả lời..."></div>' 
    + '<div class="pl-2"><button class="btn btn-warning"><i class="fa fa-paper-plane fa-fw"></i></button></div></div></form>');
}

function toggleSubCommentForm(id)
{
    $('#bigComment_'+id+' form').toggle();
    if($('#bigComment_'+id+' form').is(':visible'))
    {
       $('#bigComment_'+id+' form input').focus();
    }
}

function printBigComment(id, user_id, name, rights, comment, chapters, time)
{
    return ('<div class="flexRow" id="bigComment_'+id+'"><div class="text-center">'
+ '<img src="//lxhentai.com/assets/images/avatar.php?id='+user_id+'" class="avatar">'
+ '<span class="cmreply" onclick="toggleSubCommentForm('+id+')">Trả lời</span></div><div class="pl-2 flex1"><div class="text-comment"><i class="fal fa-angle-left"></i>' 
+ '<div class="mb-2"><b class="name">'+name+'</b> <span class="'+rights+'"></span> <abbr><i class="fal fa-clock fa-fw"></i> <span>'+time+'</span></abbr>'
+ ' <i class="at">'+chapters+'</i></div>'+comment+'</div><div id="subcomment_'+id+'"></div>'+printSubCommentForm(id)+'</div></div>');
}

function printSubComment(id, user_id, name, rights, comment, time)
{
    return ('<div class="flexRow" id="bigComment_'+id+'"><div class="text-center">'
+ '<img src="//lxhentai.com/assets/images/avatar.php?id='+user_id+'" class="avatar">'
+ '</div><div class="pl-2 flex1"><div class="text-comment"><i class="fal fa-angle-left"></i>' 
+ '<div class="mb-2"><b class="name">'+name+'</b> <span class="'+rights+'"></span> <abbr><i class="fal fa-clock fa-fw"></i> <span>'+time+'</span></abbr>'
+ '</div>'+comment+'</div></div></div>');
}

function postBigComment(e, id, cid){
    e.preventDefault();
    $.ajax({
        url: '/dashboard/api.php?act=user_comment&id='+id,
        type: 'POST',
        data: {
            comment: $('#bigComment').val(),
            cid: cid
        },
        success: function(r)
        {
            var data = $.parseJSON(r);
            $('#bigComment').val('');
            $('#count_comment').html(Number($('#count_comment').html())+1);
            if(data.error)
            {
                toastr['error']('Bạn cần đăng nhập trước !');
            } else {
                $('#listComment').prepend(printBigComment(
                data.id,
                data.user_id,
                data.name,
                data.rights,
                data.comment,
                data.chapters,
                data.time
                ));
            }
        }
    });
}

function postSubComment(e, id){
    e.preventDefault();
    $.ajax({
        url: '/dashboard/api.php?act=user_sub_comment&id='+id,
        type: 'POST',
        data: {
            comment: $('#bigComment_'+id+' form input').val(),
        },
        success: function(r)
        {
            var data = $.parseJSON(r);
            $('#bigComment_'+id+' form input').val('');
            if(data.error)
            {
                toastr['error']('Bạn cần đăng nhập trước !');
            } else {
                $('#subcomment_'+id).append(printSubComment(
                data.id,
                data.user_id,
                data.name,
                data.rights,
                data.comment,
                data.time
                ));
            }
        }
    });
}

var lastId = 0;

function showComment(id)
{
    $.ajax({
        url: '/dashboard/api.php?act=show_comment&id='+id+'&lid='+lastId,
        success: function(r)
        {
            var dataX = $.parseJSON(r);
            if(dataX.length < 30)
            	$('#load_comment_more').hide();
            for(var data of dataX)
            {
                $('#listComment').append(printBigComment(
                data.id,
                data.user_id,
                data.name,
                data.rights,
                data.comment,
                data.chapters,
                data.time
                ));

                for(var data1 of data.subcomment)
                {
                    $('#subcomment_'+data.id).append(printSubComment(
                    data1.id,
                    data1.user_id,
                    data1.name,
                    data1.rights,
                    data1.comment,
                    data1.time
                    ));
                }
                lastId = data.id;
            }

        }
    })
}

$('#postTruyen input[name=name]').on('keypress', function(){
   var item = function(id, name){
       return ('<div><a href="/story/view.php?id='+id+'" target="_blank">'+name+'</a></div>');
   }
   $.ajax({
       url: '/dashboard/api.php?act=user_similar&type=name&key='+this.value,
       success: function(r)
       {
           var data = $.parseJSON(r);
           var html = '';
           if(!data.length)
           html = '<font color=green><i class="fa fa-check"></i> Từ khóa duy nhất.</font>';
           else {
               for(var value of data)
               {
                   html += item(value.id, value.name);
               }
           }
           $('#listTrungTruyen').html(html);
           console.log(html);
       }
   })
});

$('#postTruyen input[name=authors]').on('keypress', function(){
   var item = function(name){
       return ('<div><a href="/story/search.php?key='+name+'&type=tacgia" target="_blank">'+name+'</a></div>');
   }
   $.ajax({
       url: '/dashboard/api.php?act=user_similar&type=authors&key='+this.value,
       success: function(r)
       {
           var data = $.parseJSON(r);
           var html = '';
           if(!data.length)
               html = '<font color=green><i class="fa fa-check"></i> Từ khóa duy nhất.</font>';
           else {
               for(var value of data)
               {
                   html += item(value.authors);
               }
           }
           $('#listTrungTacGia').html(html);
       }
   })
});

$('#postTruyen input[name=doujinshi]').on('keypress', function(){
   var item = function(name){
       return ('<div><a href="/story/search.php?type=doujinshi&key='+name+'" target="_blank">'+name+'</a></div>');
   }
   $.ajax({
       url: '/dashboard/api.php?act=user_similar&type=doujinshi&key='+this.value,
       success: function(r)
       {
           var data = $.parseJSON(r);
           var html = '';
           if(!data.length)
           html = '<font color=green><i class="fa fa-check"></i> Từ khóa duy nhất.</font>';
           else {
               for(var value of data)
               {
                   html += item(value.doujinshi);
               }
           }
           $('#listTrungDoujinshi').html(html);
          
       }
   })
});

$('#postTruyen input[name=nhomdich]').on('keypress', function(){
   var item = function(nhomdich){
       return ('<div><i class="fa fa-mouse-pointer fa-fw"></i> '+nhomdich+'</div>');
   }
   $.ajax({
       url: '/dashboard/api.php?act=user_similar&type=nhomdich&key='+this.value,
       success: function(r)
       {
           var data = $.parseJSON(r);
           var html = '';
           if(!data.length)
           html = '<font color=green><i class="fa fa-check"></i> Từ khóa duy nhất.</font>';
           else {
               for(var value of data)
               {
                   html += item(value.nhomdich);
               }
           }
           $('#listTrungNhomDich').html(html);
           
       }
   })
});

$('#postTruyen input[name=name]').focus(function(){
    $('input[name=name] ~ .checkTrung').slideDown(); 
})

$('#postTruyen input[name=name]').blur(function(){
    $('input[name=name] ~ .checkTrung').slideUp(); 
})

$('#postTruyen input[name=authors]').focus(function(){
    $('input[name=authors] ~ .checkTrung').slideDown(); 
})

$('#postTruyen input[name=authors]').blur(function(){
    $('input[name=authors] ~ .checkTrung').slideUp(); 
})

$('#postTruyen input[name=doujinshi]').focus(function(){
    $('input[name=doujinshi] ~ .checkTrung').slideDown(); 
})

$('#postTruyen input[name=doujinshi]').blur(function(){
    $('input[name=doujinshi] ~ .checkTrung').slideUp(); 
})

$('#postTruyen input[name=nhomdich]').focus(function(){
    $('input[name=nhomdich] ~ .checkTrung').slideDown(); 
})

$('#postTruyen input[name=nhomdich]').blur(function(){
    $('input[name=nhomdich] ~ .checkTrung').slideUp(); 
})
