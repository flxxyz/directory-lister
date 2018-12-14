<?php v('layout/header')?>

<style>
    .directory {
        margin-top: 15px;
        margin-bottom: 15px;
    }
    @media screen and (min-width: 769px), print {
        .column.info {
            -webkit-box-flex: 0;
            -ms-flex: none;
            flex: none;
            width: 42px;
        }
    }
</style>
<div class="directory container is-size-5">
    <div class="head columns has-text-weight-semibold">
        <div class="column is-1"></div>
        <div class="column has-text-left">文件</div>
        <div class="column is-1 has-text-right">大小</div>
        <div class="column is-3 has-text-centered">最后修改时间</div>
        <div class="column is-1"> </div>
    </div>
    <?php foreach ($data as $item): ?>
        <a class="columns has-text-weight-light"
           data-type="<?=$item['is_dir']?'dir':'file'?>"
           data-href="<?=$item['url']?>"
           href="<?=$item['url']?>">
            <div class="column is-1"></div>
            <div class="column">
                <span class="icon">
                    <i class="fas <?=$item['ext']?>"></i>
                </span>
                <span class="name"><?php _e($item['name']) ?></span>
            </div>
            <div class="column is-1 has-text-right"><?=$item['size']?></div>
            <div class="column is-3 has-text-centered"><?=$item['time']?></div>
            <div class="column is-1"></div>
        </a>
    <?php endforeach; ?>
    <div class="foot columns has-text-weight-semibold">
        <div class="column is-1"></div>
        <div class="column">文件</div>
        <div class="column is-1 has-text-right">大小</div>
        <div class="column is-3 has-text-centered">最后修改时间</div>
        <div class="column is-1"> </div>
    </div>
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

        $('a').click(function (e) {
            e = $(this)
            // console.log(e.data())

            if (e.data('type') === 'dir') {
                var path = $('.name', e).text()
                console.log(path)
                console.log('path=', getUrlItem('path'))
            }

            console.log(e.data('href'))
            // window.location.href = $(this).data('href')
        })
    })
</script>

<?php v('layout/footer', ['storage' => $storage])?>
