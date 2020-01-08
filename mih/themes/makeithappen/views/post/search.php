<?php

foreach($model->search()->getData() as $post){
    echo 
    "
    <div class='col-md-4'>
        <a href='{$post->url}'>  
            <img style='width:100%' src='/img/{$post->image}' alt='{$post->title} />
        <a/> <br/>
        <a href='{$post->url}' class='title'>{$post->title}</a> <br/>
        <p class='content'>{$post->content}</p>
    </div>
    ";
}

?>