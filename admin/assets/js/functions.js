$(document).ready(function(){ 
	$(function() {
		$("#sort_category ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
			var order = $(this).sortable("serialize") + '&action=sort_category'; 
			$.post("ajax.php", order, function(theResponse){}); 															 
		}								  
		});
	});
});
$(document).ready(function(){ 
	$(function() {
		$("#sort_links ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
			var order = $(this).sortable("serialize") + '&action=sort_links'; 
			$.post("ajax.php", order, function(theResponse){}); 															 
		}								  
		});
	});
});
$(document).ready(function(){ 
	$(function() {
		$("#sort_pages ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
			var order = $(this).sortable("serialize") + '&action=sort_pages'; 
			$.post("ajax.php", order, function(theResponse){
				
			}); 															 
		}								  
		});
	});
});
function changePage(newLoc)
{
   nextPage = newLoc.options[newLoc.selectedIndex].value
		
   if (nextPage != "")
   {
      document.location.href = nextPage
   }
}

$(function(){
$('[data-toggle="tooltip"]').tooltip({html:true});
$('[data-toggle="popover"]').popover({html:true});
});


$(function() {
$(".news_grab").click(function() {
var id = $(this).attr("id");
var dataString = 'id='+ id +'&action=news_grab';
$("a#"+id+" span").removeClass('fa fa-refresh');		
$("a#"+id+" span").addClass('fa fa-spinner fa-spin');
$.ajax({
   type: "POST",
   url: "ajax.php",
   data: dataString,
   dataType: "html",
   cache: false,
   success: function()
   {
	$("a#"+id+" span").removeClass('fa fa-spinner fa-spin');		
	$("a#"+id+" span").addClass('fa fa-refresh');
	document.location.href = './sources.php';
  }  
  });  
});
});

$(function() {
$(".delete-image").click(function() {
	if(confirm('Proceed To Delete Image ?'))
		{
var id = $(this).attr("id");
var dataString = 'id='+ id +'&action=remove_image';
$(".delete-image span").removeClass('fa fa-close');		
$(".delete-image span").addClass('fa fa-spinner fa-spin');
$.ajax({
   type: "POST",
   url: "ajax.php",
   data: dataString,
   dataType: "html",
   cache: false,
   success: function()
   {
	$(".delete-image span").removeClass('fa fa-spinner fa-spin');		
	$(".delete-image span").addClass('fa fa-close');
	document.location.href = 'news.php?case=edit&id='+id;
  }  
  });  
  } else {
	confirm.close();
	}
});
});

function ConfirmLogOut() {
	if(confirm('Proceed To Logout ?'))
		{
		document.location.href = 'logout.php';
	} else {
		confirm.close();
	}
}

function AddMoreInputs() {
	var input = '<input type="text" class="form-control" name="answer[]" />';
	$('.another_answer').append(input);
}