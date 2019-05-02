$("a.like").on("click", function(e) {
    var postId = $(this).data("id");
    var link = $(this);

    $.ajax({
        method: "POST",
        url: "ajax/like.php",
        data: { postId: postId }, 
        dataType: 'json'
    })
    .done(function( res ) {
        if (res.status == "liked") {
            var likes = link.next().html();
            likes++;
            link.next().html(likes);	
        } else if (res.status == "unliked") {
            var likes = link.next().html();
            likes--;
            link.next().html(likes);	
        }
    });

    e.preventDefault();
    
});