$("#txtLinkFoto").change(function(e)
{

    var fileName = e.target.files[0].name;

    $("#nomeFile").text(fileName);
});


$(".send-icon").click(function(event)
{
    $("#modifica-news-form" + event.target.id).submit();
});


function checkFormNews()
{
    if($("#txtTitolo").val() == "")
    {
        $(".alert").remove();
        $(".container").prepend("<div class='modal alert my-alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Ops!</strong> Non hai inserito il titolo!</div>");
        return false;
    }
    
    
    if($("#txtCategorie").val() == "")
    {
        $(".alert").remove();
        $(".container").prepend("<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Ops!</strong> Non hai inserito nessuna categoria!</div>")
        return false;
    }

    
    if($("#txtNews").val() == "")
    {
        $(".alert").remove();
        $(".container").prepend("<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Ops!</strong> Non hai inserito il testo!</div>")
        return false;
    }


    return true;
}