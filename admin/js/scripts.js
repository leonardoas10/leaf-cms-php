$(document).ready(function(){
   // EDITOR CKEDITOR
    ClassicEditor
        .create( document.querySelector( '#body' ) )
        .catch( error => {
            console.error( error );
    } );
});

$(document).ready(function(){
    $('#selectAllBoxes').click(function(event){
        if(this.checked) {
            $('.checkBoxes').each(function() {
                this.checked = true;
            }); 
        } else {
             $('.checkBoxes').each(function() {
                this.checked = false;
            }); 
        }
    });
})

var div_box = "<div id='load-screen'><div id='loading'></div></div>";

$("body").prepend(div_box);

$('#load-screen').delay(700).fadeOut(600, function(){
    $(this).remove();
});


function loadUsersOnline() {
    
    $.get("functions.php?onlineusers", function(data) {
        $(".usersonline").text(data);
    });
}

setInterval(function() {
    loadUsersOnline();
},500);

// MODAL DELETE BUTTON
$(document).ready(function() {
    $(".del_link").on('click', function(e) {
        e.preventDefault();
        const p_id = $(this).attr("rel");
        $(".modal_delete_link").val(p_id);
        $(".modal-body").html("<h4 class='text-center'>Are you sure you want to delete id: " + p_id + "? </h4>");
        $("#myModal").modal('show');
    });
    // EDIT BUTTON
    $(".edit_link").on('click', function(e) {
        e.preventDefault();
        const p_id = $(this).attr("rel");
        $("._id").val(p_id);
        $("#actions").trigger("submit");
    });
});












