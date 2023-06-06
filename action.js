function toggleNotifications() {

  var container = document.getElementById('notificationsContainer');
  if (container.style.display === 'block') {
    container.style.display = 'none';
  } else {
    container.style.display = 'block';
  }
}

$(document).ready(function(){
 
  $('.accept').on('click',function(){
    let from_id = $(this).prev().prev().text(); 
    let to_id = $(this).prev().text();
    // let parent = $(this).parent().parent().find('#enes') ;
    // console.log(parent);
      $.ajax({
        url: 'userPage.php',
        type: 'post',
        data: {
          'accept': 1,
          'from_id': from_id,
          'to_id': to_id
        },
        success: function(data) {
          // parent.html(data);
        }
      })
  })
});