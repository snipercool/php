$("#follow").on("click", function(e){
    var id = $("#follow").data("index");
    console.log(id);
    
    if ($("#follow").html() == "Follow") {
        $("#follow").html("Unfollow");
        $.ajax({
            method: "POST",
            url: "ajax/follow.php",
            data: {followUserId: id},
            dataType:'json'
        })
        .done(function (res) {
            console.log(id);
            console.log("succes follow");
            
            
        });
        e.preventDefault();
    }
    else{
        $("#follow").html("Follow");
        $.ajax({
            method: "POST",
            url: "ajax/unfollow.php",
            data: {followUserId: id},
            dataType:'json'
        })
        .done(function (res) {
            console.log(id);
            console.log("succes unfollow");
            
        });
        e.preventDefault();
    }
    
});