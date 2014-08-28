
      <div class="row-fluid">
        <div class="span12">
<?php
$params = $this->Paginator->params();
if ($params['pageCount'] > 1) {
?>
<div class="pagination pagination pagination-right">
 <ul>
<?php
    echo $this->Paginator->prev('&larr; ', array(
        'class' => 'prev',
        'tag' => 'li',
         'escape' => false
    ), '<a onclick="return false;">&larr; </a>', array(
        'class' => 'prev disabled',
        'tag' => 'li',
        'escape' => false
    ));
    echo $this->Paginator->numbers(array(
        'separator' => '',
        'tag' => 'li',
        'currentClass' => 'active',
        'currentTag' => 'a'
    ));
    echo $this->Paginator->next(' &rarr;', array(
        'class' => 'next',
        'tag' => 'li',
        'escape' => false
    ), '<a onclick="return false;"> &rarr;</a>', array(
        'class' => 'next disabled',
        'tag' => 'li',
        'escape' => false
    )); ?>
 </ul>
</div>
<?php } ?>


        </div>
      </div>