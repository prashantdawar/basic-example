<?php // $item is from actionItemDetail?>
<?= $this->context->renderPartial('_copyright'); ?>

<h2>News Item Detail</h2>
<br>
<p>
    <span>Title:</span><b><?= $item['title'] ?></b>
    <br>
    <span>Date:</span><b><?= $item['date'] ?></b>
</p>