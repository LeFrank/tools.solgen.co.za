<?php
if ($this->session->flashdata("success") !== FALSE) {
    echo $this->session->flashdata("success");
}
?>
<div class="row expanded">
    <div class="large-12 columns">
        <h2>Lists</h2>
        <div id="div1" ondrop="drop(event, this)" ondragover="allowDrop(event)" data-order-val="1">
            <div id="items[]" name="items[]" 
                 data-order="1" 
             draggable="true" ondragstart="drag(event)" 
             >Go and get Biometrics</div>
        </div>
        <br>
        <div id="div2" ondrop="drop(event, this)" ondragover="allowDrop(event)" data-order-val="2">
            <div id="items[]" name="items[]" 
                 data-order="2" 
             draggable="true" ondragstart="drag(event)" >
                Call Paarl Home affairs
            </div>
        </div>
        <br>
        <div id="div3" ondrop="drop(event, this)" ondragover="allowDrop(event)" data-order-val="3">
            <div 
                id="items[]" 
                name="items[]" 
                data-order="3" 
                draggable="true" ondragstart="drag(event)" >
                Get Muchacho a gift
            </div>
        </div>
        <br>
        <img id="drag1" data-order="0" 
             class="nav-icon-long" src="http://localhost/images/third_party/icons/home.svg" 
             draggable="true" ondragstart="drag(event)" 
             width="336" height="69"
            >
    </div>
</div>
<script src="/js/third_party/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css" />
<script src="/js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="/js/third_party/jquery.tablesorter.min.js"></script>
<script src="/js/third_party/jquery/ui/1.12.1/jquery-ui.js"></script>
<script src="/js/lists/index.js"></script>