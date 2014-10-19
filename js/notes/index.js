$(document).ready(function() {
	$("div .editable_content").on('click', function() {
		console.log(this.id);
		if(this.id.substring("body_")){
			CKEDITOR.replace( this.id );
		}
	});
});