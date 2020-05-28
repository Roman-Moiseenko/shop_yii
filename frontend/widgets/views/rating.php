<?php
/* @var $rating integer */
?>

<?php for ($i = 1; $i <= 5; $i++): ?>
    <span class="fa fa-stack">
    <?php $star = '-o'; ?>
    <?php if ($i <= $rating) {
        $star = '';
    } elseif ((0.20 < $i - $rating) && ($i - $rating < 0.80)) {
        $star = '-half-o';
    } ?>
        <i class="fa fa-star<?= $star; ?> fa-stack-1x"></i>
    </span>&nbsp
<?php endfor; ?>
