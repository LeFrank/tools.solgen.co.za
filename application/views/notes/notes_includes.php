<?php ?>
<script src="/js/third_party/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css"/ >
<script src="/js/jquery.datetimepicker.js"></script>
<script src="/js/third_party/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/js/third_party/jquery.ui.widget.js" type="text/javascript" charset="utf-8"></script>
<script src="/js/third_party/" type="text/javascript" charset="utf-8"></script>
<script src="/js/third_party/tag-it/tag-it.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/css/third_party/tag-it/tag-it.css"/ >
<script type="text/javascript">
    CKEDITOR.replace( 'body' );
    $(function() {
        $("#noteDate").datetimepicker();
    });
    $("#noteTaggs").tagit({
        availableTags: tagsVar,
        allowSpaces: true,
        singleField: true,
        fieldName: 'tags'
    });
</script>
<script type="text/javascript" src="/js/notes/index.js" ></script>