<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>

<b>Filter data by year:</b>
<br>
<ul>
    <?php $currentYear = date('Y'); ?>
    <?php for($year=$currentYear; $year > ($currentYear-5); $year--) {?>
        <li><?= 
                Html::a('List items by year ' . $year, 
                        Url::to(['news/items-list', 'year' => $year])) 
            ?>
        </li>
    <?php } ?>
</ul>

<br>


<b>Filter data by category: </b>
<br>
<ul>
    <?php $catergories = ['business', 'shopping']; ?>
    <?php foreach ($catergories as $category) { ?>
        <li><?= 
                Html::a('List item by category ' . $category,
                        Url::to(['news/items-list', 'category' => $category]))
            ?>
        </li>
    <?php } ?>
</ul>
<br><br>