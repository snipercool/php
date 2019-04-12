$("#email").on("keyup", function(e){
    let email = $("#email").val();
    console.log(email);
    $.ajax({
        method: "POST",
        url: "ajax/check_email.php",
        data: { email: email},
        dataType:'json'
    })
        .done(function( res ) {
            if(res.status =="success"){
                let availability = $(".availabilityCheck");
                availability.css("display", "none");
            } else {
                let availability = $(".availabilityCheck");
                availability.css("display", "block");
                availability.css("color", "red");
                availability.css("font-weight", "bold");
                availability.html("This email is not available");
            }
        });
    e.preventDefault();
});

