$("#username").on("keyup", function(u){
    let username = $("#username").val();
    console.log(username);
    $.ajax({
        method: "POST",
        url: "ajax/check_username.php",
        data: { username: username},
        dataType:'json'
    })
        .done(function( res ) {
            if(res.status =="success"){
                let availability = $(".availabilityCheck2");
                availability.css("display", "none");
            } else {
                let availability = $(".availabilityCheck2");
                availability.css("display", "block");
                availability.css("color", "red");
                availability.css("font-weight", "bold");
                availability.html("This username is not available");
            }
        });
    u.preventDefault();
});