// alert("it works!")
const apiURL = "friends-api.php" ;

$(function(){
    $("#searchPart").on("click", "i.fa-plus", function(){
        let idSender =  userData.id; // access the id to send notification
        let idReceiver = $(this).prev().prev().text() ; 
        let type = "Friendship Request";
        let content = "Can we be friends?";
        $.ajax( {
             type: "POST",
             url : apiURL,
             data : JSON.stringify({idSender,idReceiver,type,content}),
             contentType: "application/json",
             success: function(result){
                 if (result.error) {
                     showError(result.error, 3000) ;
                 } else {
                    sendFriendRequest(result.id,result.user_id,result.type,result.content) ;
                 }
             },
             error: function() {
                 showError("Error: API is not accessible, check api path.", 5000) ;
             }
         }) 
     })
 })

function showError(msg,duration) {
    $("#error").text(msg).stop(true, true).fadeIn(1000).fadeOut(duration);
 }