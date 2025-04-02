$('.togglerUpdateAssets').click(function (e) { 
    e.preventDefault();

    let id = $(this).data('id');
    let asset_code = $(this).data('asset_code');
    let name = $(this).data('name');
    let description = $(this).data('description');
    let price = $(this).data('price');
    let category_id = $(this).data('category_id');
    let subcategory_id = $(this).data('subcategory_id');
    let condition_status = $(this).data('condition_status');
    let office_id = $(this).data('office_id');
    let quantity = $(this).data('quantity');
    let status = $(this).data('status');

   console.log(id);

    // Set values in the modal form
    $("#assets_id").val(id);
    $("#update_assets_code").val(asset_code);
    $("#update_assets_name").val(name);
    $("#update_assets_description").val(description);
    $("#update_assets_price").val(price);
    
    $("#update_assets_category").val(category_id);
    $("#update_assets_subcategory").val(subcategory_id);
    $("#update_assets_condition").val(condition_status);
    $("#update_assets_Office").val(office_id);

    $("#update_assets_qty").val(quantity);
    $("#update_assets_status").val(status);

    // Show the modal
    $('#updateAssetsModal').fadeIn();
});

// Close modal functionality
$('.updateUserModalClose').click(function () {
    $('#updateAssetsModal').fadeOut();
});




  $('.addUserModalClose').click(function (e) { 
    e.preventDefault();
    $('#updateAssetsModal').fadeOut();
  });  

   // Close Modal when clicking outside the modal content
   $("#updateAssetsModal").click(function(event) {
        if ($(event.target).is("#updateAssetsModal")) {
            $("#updateAssetsModal").fadeOut();
        }
    });




$('#addAssetsButton').click(function (e) { 
    e.preventDefault();
    $('#addAssetsModal').fadeIn();
  });  

  $('.addUserModalClose').click(function (e) { 
    e.preventDefault();
    $('#addAssetsModal').fadeOut();
  });  

   // Close Modal when clicking outside the modal content
   $("#addAssetsModal").click(function(event) {
        if ($(event.target).is("#addAssetsModal")) {
            $("#addAssetsModal").fadeOut();
        }
    });








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
      var user_id =$(this).data('user_id');
      var user_fullname =$(this).data('fullname');
      var user_nickname =$(this).data('nickname');
      var user_email =$(this).data('email');
      var user_role =$(this).data('role');
      var user_designation =$(this).data('designation');
  
   
      console.log(user_id);
  
      $('#update_id').val(id)
      $('#update_user_id').val(user_id)
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
                    alertify.error(response.message);
                }
            }
        });
    });







    $("#frmMaintenance").submit(function (e) {
        e.preventDefault();
    
        $('.spinner').show();
        $('#BtnMaintenance').prop('disabled', true);
    
        var formData = new FormData(this);
        formData.append('requestType', 'UpdateMaintenance');
        
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
                $('#BtnMaintenance').prop('disabled', false);
    
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





    $("#addAssetFrm").submit(function (e) {
        e.preventDefault();
  
      
        $('.spinner').show();
        $('#btnAddAssets').prop('disabled', true);
    
        var formData = new FormData(this); 
        formData.append('requestType', 'AddAssets');
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
                    $('#btnAddAssets').prop('disabled', false);
                    alertify.error(response.message);
                }
            },
            complete: function () {
                $("#submitBtn").prop("disabled", false).text("Submit");
            }
        });
    });






    $("#updateAssetFrm").submit(function (e) {
        e.preventDefault();
  
      
        $('.spinner').show();
        $('#btnUpdateAssets').prop('disabled', true);
    
        var formData = new FormData(this); 
        formData.append('requestType', 'UpdateAssets');
        $.ajax({
            type: "POST",
            url: "backend/end-points/controller.php",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json", // Expect JSON response
            beforeSend: function () {
                $("#btnUpdateAssets").prop("disabled", true).text("Processing...");
            },
            success: function (response) {
                console.log(response); // Debugging
                
                if (response.status === 200) {
                    alertify.success(response.message);
                    setTimeout(function () { location.reload(); }, 1000);
                } else {
                    $('.spinner').hide();
                    $('#btnUpdateAssets').prop('disabled', false);
                    alertify.error(response.message);
                }
            },
            complete: function () {
                $("#btnUpdateAssets").prop("disabled", false).text("Submit");
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







  $(document).on('click', '.togglerDeleteAssets', function(e) {
    e.preventDefault();
    var assets_id = $(this).data('id');

    console.log(assets_id);
    
    Swal.fire({
        title: 'Are you sure?',
        text: 'Delete This Record',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "backend/end-points/controller.php",
                type: 'POST',
                data: { assets_id: assets_id, requestType: 'DeleteAssets' },
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





$(document).on('change', '.togglerRequest', function(e) {
    e.preventDefault();
    
    var request_id = $(this).data('request_id');
    var action = $(this).val(); // Get action type (Approve/Decline)
    
    // Modify your confirmation text and success message based on the selected action
    var confirmText = action === 'Approve' ? 'Approve this request?' :
                      action === 'Decline' ? 'Decline this request?' :
                      action === 'Ongoing' ? 'Mark this request as ongoing?' :
                      action === 'Recieved' ? 'Mark this request as received?' : '';

    var successMessage = action === 'Approve' ? 'Request Approved!' :
                         action === 'Decline' ? 'Request Declined!' :
                         action === 'Ongoing' ? 'Request is now ongoing!' :
                         action === 'Recieved' ? 'Request marked as received!' : '';

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
                data: { request_id: request_id, action: action,requestType:'UpdateReqStatus'},
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








// LOGOUT HERE
$(document).on('click', '.btnLogout', function(e) {
    e.preventDefault();
    var assets_id = $(this).data('id');

    console.log(assets_id);
    
    Swal.fire({
        title: 'Are you sure?',
        text: 'You want to logout',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'logout.php';

        }
    });
});
