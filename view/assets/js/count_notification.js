$(document).ready(function () {

    const getCount = () => {
        $.ajax({
        url: "backend/end-points/count_notification.php",
          type: 'GET',
          dataType: 'json',
          success: function(response) {
              console.log(response.pendingCount);
    
              let TotalPending = response.TotalPending;
              $('#TotalPending').text(TotalPending);
    
              if (unseenCount > 0) {
                $('#TotalPending').show();
            } else {
                $('#TotalPending').hide();
            }
       
              
              
          },
          error: function(xhr, status, error) {
              console.error("Error fetching order status counts:", error);
          }
      });
    };
    
    setInterval(() => {
        getCount();
      }, 3000);
    
    
      getCount();
    });