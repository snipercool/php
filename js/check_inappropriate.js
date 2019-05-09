$("a.inappropriate").on("click", function(e) {
    var postId = $(this).data("id");
    var link = $(this);

    $.ajax({
        method: "POST",
        url: "ajax/check_inappropriate.php",
        data: { postId: postId }, 
        dataType: 'json'
    })
    .done(function( res ) {
        if (res.status == "flagged") {
            var reports = link.next().html();
            reports++;
            link.next().html(reports);	
        } else if (res.status == "unflagged") {
            var reports = link.next().html();
            reports--;
            link.next().html(reports);	
        }
    });

    e.preventDefault();
    
});