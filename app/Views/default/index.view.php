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
<div class="directory container is-size-7">
    <div class="head columns has-text-weight-semibold">
        <div class="column">文件</div>
        <div class="column is-1 has-text-right">大小</div>
        <div class="column is-2 has-text-centered">创建时间</div>
        <div class="column info"> </div>
    </div>
    <?php foreach ($data as $item): ?>
        <a class="columns has-text-weight-light" href="<?php _e($root . urlencode($item['name'])) ?>">
            <div class="column">
                <span class="icon"><i class="fas <?php _e($item['ext']) ?>"></i></span><?php _e($item['name']) ?>
            </div>
            <div class="column is-1 has-text-right"><?php _e($item['size']) ?></div>
            <div class="column is-2 has-text-centered"><?php _e($item['time']) ?></div>
            <div class="column info"></div>
        </a>
    <?php endforeach; ?>
    <div class="foot columns has-text-weight-semibold">
        <div class="column">文件</div>
        <div class="column is-1 has-text-right">大小</div>
        <div class="column is-2 has-text-centered">创建时间</div>
        <div class="column info"> </div>
    </div>
</div>

<?php v('layout/footer')?>
