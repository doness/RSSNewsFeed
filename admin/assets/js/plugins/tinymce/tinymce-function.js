tinymce.init({
    selector: ".wysiwyg",
	plugins: [
         "advlist autolink link image lists charmap preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor"
   ],
	menubar: "edit insert format table view tools",
    toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview media fullpage | forecolor backcolor emoticons",
	content_css : "assets/css/editor-font.css"	
   
 });
