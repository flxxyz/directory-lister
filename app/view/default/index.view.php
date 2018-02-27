<?php v('layout/header')?>

<div>
    <?php foreach ($data as $item): ?>
        <a href="<?php _e($root . urlencode($item['name'])) ?>"><?php _e($item['name']) ?></a>
    <?php endforeach; ?>
</div>

<?php v('layout/footer')?>
