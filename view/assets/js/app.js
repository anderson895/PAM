
$('#CreateRequestButton').click(function (e) { 
    e.preventDefault();
    $('#CreateRequestModal').fadeIn();
  });  

  $('.addUserModalClose').click(function (e) { 
    e.preventDefault();
    $('#CreateRequestModal').fadeOut();
  });  

   // Close Modal when clicking outside the modal content
   $("#CreateRequestModal").click(function(event) {
        if ($(event.target).is("#CreateRequestModal")) {
            $("#CreateRequestModal").fadeOut();
        }
    });










$('#adduserButton').click(function (e) { 
    e.preventDefault();
    $('#addUserModal').fadeIn();
  });  

  $('.addUserModalClose').click(function (e) { 
    e.preventDefault();
    $('#addUserModal').fadeOut();
  });  

   // Close Modal when clicking outside the modal content
   $("#addUserModal").click(function(event) {
        if ($(event.target).is("#addUserModal")) {
            $("#addUserModal").fadeOut();
        }
    });








    $('.togglerUpdateUser').click(function (e) { 
      var id =$(this).data('id');
      var user_fullname =$(this).data('fullname');
      var user_nickname =$(this).data('nickname');
      var user_email =$(this).data('email');
      var user_role =$(this).data('role');
      var user_designation =$(this).data('designation');
  
      console.log(user_role);
  
      $('#update_id').val(id)
      $('#update_user_fullname').val(user_fullname)
      $('#update_user_nickname').val(user_nickname)
      $('#update_user_email').val(user_email)
      $('#update_user_type').val(user_role)
      $('#update_user_designation').val(user_designation)
     
      
      e.preventDefault();
      $('#updateUserModal').fadeIn();
    });  
  
    $('.UpdateBranchModalClose').click(function (e) { 
      e.preventDefault();
      $('#updateUserModal').fadeOut();
    });  
  
      // Close Modal when clicking outside the modal content
      $("#updateUserModal").click(function(event) {
          if ($(event.target).is("#updateUserModal")) {
              $("#updateUserModal").fadeOut();
          }
      });








$("#createRequestFrm").submit(function (e) {
        e.preventDefault();
    
        $('.spinner').show();
        $('#btnCreateRequest').prop('disabled', true);
    
        var formData = new FormData(this);
        formData.append('requestType', 'CreateRequest');
        
        $.ajax({
            type: "POST",
            url: "backend/end-points/controller.php",
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                $('.spinner').hide();
                $('#btnCreateRequest').prop('disabled', false);
    
                if (response.status == 200) {
                    alertify.success('Success');
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else {
                    alertify.error('Sending failed, please try again.');
                }
            }
        });
    });






      $("#updateUserForm").submit(function (e) {
        e.preventDefault();
    
        $('.spinner').show();
        $('#btnUpdateUser').prop('disabled', true);
    
        var formData = new FormData(this);
        formData.append('requestType', 'UpdateUser');
        
        $.ajax({
            type: "POST",
            url: "backend/end-points/controller.php",
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                $('.spinner').hide();
                $('#btnUpdateUser').prop('disabled', false);
    
                if (response.status == 200) {
                    alertify.success('Update Successful');
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else {
                    alertify.error('Sending failed, please try again.');
                }
            }
        });
    });

















    $("#adduserForm").submit(function (e) {
      e.preventDefault();

    
      $('.spinner').show();
      $('#btnAdduser').prop('disabled', true);
  
      var formData = new FormData(this); 
      formData.append('requestType', 'Adduser');
      $.ajax({
          type: "POST",
          url: "backend/end-points/controller.php",
          data: formData,
          contentType: false,
          processData: false,
          dataType: "json", // Expect JSON response
          beforeSend: function () {
              $("#submitBtn").prop("disabled", true).text("Processing...");
          },
          success: function (response) {
              console.log(response); // Debugging
              
              if (response.status === 200) {
                  alertify.success(response.message);
                  setTimeout(function () { location.reload(); }, 1000);
              } else {
                  $('.spinner').hide();
                  $('#btnAdduser').prop('disabled', false);
                  alertify.error(response.message);
              }
          },
          error: function (xhr, status, error) {
              console.error("AJAX Error:", xhr.responseText); // Log detailed error response
              alertify.error("Something went wrong. Please try again.");
          },
          complete: function () {
              $("#submitBtn").prop("disabled", false).text("Submit");
          }
      });
  });










  $(document).on('click', '.togglerDeleteUser', function(e) {
    e.preventDefault();
    var userId = $(this).data('id');

    console.log(userId);
    
    Swal.fire({
        title: 'Are you sure?',
        text: 'Archive This',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "backend/end-points/controller.php",
                type: 'POST',
                data: { userId: userId, requestType: 'DeleteUser' },
                dataType: 'json',  // Expect a JSON response
                success: function(response) {
                    if (response.status === 200) {
                        Swal.fire(
                            'Deleted!',
                            response.message,  // Show the success message from the response
                            'success'
                        ).then(() => {
                            location.reload(); 
                        });
                    } else {
                        Swal.fire(
                            'Error!',
                            response.message,  // Show the error message from the response
                            'error'
                        );
                    }
                },
                error: function() {
                    Swal.fire(
                        'Error!',
                        'There was a problem with the request.',
                        'error'
                    );
                }
            });
        }
    });
});




$(document).on('click', '.togglerRequest', function(e) {
    e.preventDefault();
    
    var request_id = $(this).data('request_id');
    var action = $(this).data('action'); // Get action type (Approve/Decline)
    var confirmText = action === 'ApproveUser' ? 'Approve this request?' : 'Decline this request?';
    var successMessage = action === 'ApproveUser' ? 'Request Approved!' : 'Request Declined!';
    
    Swal.fire({
        title: 'Are you sure?',
        text: confirmText,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, proceed!',
        cancelButtonText: 'No, cancel!',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "backend/end-points/controller.php",
                type: 'POST',
                data: { request_id: request_id, requestType: action },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 200) {
                        Swal.fire(
                            'Success!',
                            successMessage,
                            'success'
                        ).then(() => {
                            location.reload(); 
                        });
                    } else {
                        Swal.fire(
                            'Error!',
                            response.message,
                            'error'
                        );
                    }
                },
                error: function() {
                    Swal.fire(
                        'Error!',
                        'There was a problem with the request.',
                        'error'
                    );
                }
            });
        }
    });
});
