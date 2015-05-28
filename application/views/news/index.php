<hr/>

<?php foreach($news as $news_item): ?>
<h2><?php echo $news_item['title']?></h2>
<div id='Main' >
    <?php echo $news_item['text']; ?>
</div>
<p>
    <a href="news/<?php echo $news_item['slug']?>">
        View article
    </a>
    <br/>
    <a href="news/delete/<?php echo $news_item['id']?>">
        Delete ?
    </a>
</p>
<?php endforeach; ?>
<hr/>