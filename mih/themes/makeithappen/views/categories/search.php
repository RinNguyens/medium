<?php

foreach($model->search()->getData() as $categories){
    echo 
    "
    <div class='col-md-4'>
        <a href='{$categories->url}' class='title'>{$categories->title}</a> <br/>
    </div>
    ";
}

?>