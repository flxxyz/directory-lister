<?php v('layout/header')?>
<style>
  a:hover {
    background-color: #efefef
  }
  .directory {
    margin-top: 15px;
    margin-bottom: 15px;
  }
  .directory-link {
    margin-bottom: 24px;
  }
  .directory-file-name {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    width: 625px;
    display: inline-block;
    line-height: 20px;
  }
  .directory-size-small, .directory-last-modify-small {
    display: none;
  }
  .directory-mobile-head {
    display: none;
  }
  @media screen and (min-width: 1500px), print {
    .directory-file-name {
      width: 60rem;
    }
  }
  @media screen and (min-width: 1200px), print {
    .directory-file-name {
      width: 50rem;
    }
  }
  @media screen and (max-width: 1024px), print {
    .directory-file-name {
      width: 33rem;
    }
  }
  @media screen and (min-width: 769px), print {
    .directory-file-name {
      width: 525px;
    }
  }
  @media screen and (max-width: 769px), print {
    .directory-head, .directory-foot {
      display: none;
    }
    .directory-mobile-head {
      display: block;
    }
    .directory-link {
      display: block;
    }
    .directory-file {
      padding-left: 42px;
      padding-bottom: 0;
    }
    .directory-file-name {
      width: 300px;
    }
    .directory-size {
      display: inline-block;
      font-size: 0.8rem;
      padding: 0 0 0 72px;
    }
    .directory-last-modify {
      display: inline-block;
      font-size: 0.8rem;
      padding: 0 0 0 10px;
    }
    .directory-size-small, .directory-last-modify-small {
      display: inline-block;
    }
  }
</style>
<div class="directory container is-size-5">
  <div class="directory-mobile-head column has-text-weight-semibold">文件列表</div>
  <div class="directory-head columns has-text-weight-semibold">
    <div class="directory-file column has-text-left">文件</div>
    <div class="directory-size column is-1 has-text-right">大小</div>
        <div class="directory-last-modify column is-2 has-text-centered">最后修改时间</div>
    </div>
    <?php foreach ($data as $item): ?>
        <a class="directory-link columns has-text-weight-light"
           data-type="<?=$item['is_dir']?'dir':'file'?>"
           title="<?=$item['name']?>">
            <div class="directory-file column">
                <span class="directory-file-icon icon">
                    <i class="fas <?=$item['icon']?>"></i>
                </span>
                <span class="directory-file-name"><?=$item['name']?></span>
            </div>
            <div class="directory-size column is-1 has-text-right">
              <span class="directory-size-small">大小: </span><?=$item['size']?>
            </div>
            <div class="directory-last-modify column is-2 has-text-centered">
                <span class="directory-last-modify-small">最后修改时间: </span><?=$item['time']?>
            </div>
        </a>
    <?php endforeach; ?>
    <div class="directory-foot columns has-text-weight-semibold">
        <div class="directory-size column">文件</div>
        <div class="directory-size column is-1 has-text-right">大小</div>
        <div class="directory-last-modify column is-2 has-text-centered">最后修改时间</div>
    </div>
    <div id="dplayer"></div>
</div>

<script>
    $(function () {
        function getUrlItem(name, query) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
            if (query) {
                var r = query.match(reg);
            } else {
                var r = window.location.search.substr(1).match(reg);
            }
            if (r != null) return decodeURIComponent(r[2]);
            return null;
        }
        function files(data = []) {
            this.data = data;
        }
        files.prototype = {
            search: function (type, name) {
                var file = this.find(name)
                if (file != null) {
                    return file[type];
                }

                return null;
            },
            find: function (name) {
                for (var index in this.data) {
                    if (name === this.data[index].name) {
                        return this.data[index];
                    }
                }

                return null;
            }
        };
        var files = new files();
        function in_video_type(needle) {
            var haystack = ['mp4', 'flv'];
            var length = haystack.length;
            for(var i = 0; i < length; i++) {
                if(haystack[i] == needle) {
                    return true;
                }
            }

            return false;
        }
        function resize() {
            var ua = navigator.userAgent;
            var isMobile = ua.indexOf('Android') > -1 || ua.indexOf('iPhone') > -1 || ua.indexOf('iPad') > -1 || ua.indexOf('iPod') > -1 || ua.indexOf('Symbian') > -1;
            if (isMobile) {
                $('.directory-link').each(function (index, e) {
                    if ($(window).width() <= 414) {
                        if ($(e).data('type') === 'dir') {
                            $('.directory-size-small', e).hide();
                            $('.directory-last-modify', e).hide();
                            $('.directory-mobile-head').show();
                        }
                    } else {
                        if ($(e).data('type') === 'dir') {
                            $('.directory-size-small', e).show();
                            $('.directory-last-modify', e).show();
                            $('.directory-mobile-head').hide();
                        }
                    }
                })
            }
        }
        resize();

        $.ajax({
            url: window.location.origin,
            data: {ajax: 'json', path: getUrlItem('path')},
            success: function (result) {
                files.data = result.data;
                console.log(files);
            }
        })
        
        $('.directory-link').click(function () {
            var name = $(this).attr('title');
            var file = files.find(name);
            // console.log(name, file);

            if ($(this).data('type') != 'dir') {
                if (in_video_type(file.ext)) {
                    new DPlayer({
                        container: $('#dplayer').get(0),
                        video: {
                            url: file.url,
                            type: file.ext,
                        }
                    });
                    return;
                }

                window.open(file.url);
            } else {
                window.location.href = file.url;
            }
        })
    })
</script>

<?php v('layout/footer', ['storage' => $storage])?>
