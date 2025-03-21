



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PAM</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" type="image/png" href="assets/logo/logo.jpg">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.css" integrity="sha512-MpdEaY2YQ3EokN6lCD6bnWMl5Gwk7RjBbpKLovlrH6X+DRokrPRAF3zQJl1hZUiLXfo2e9MrOt+udOnHCAmi5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js" integrity="sha512-JnjG+Wt53GspUQXQhc+c4j8SBERsgJAoHeehagKHlxQN+MtCCmFDghX9/AcbkkNRZptyZU4zC8utK59M5L45Iw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gradient-to-br from-red-900 to-red-700 px-4">

  
<?php include "function/PageSpinner.php"; ?>

  <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-6 sm:p-8 relative">
    
     <!-- Spinner -->
     <div class="spinner" id="spinner" style="display:none;">
                <div class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center">
                    <div class="w-10 h-10 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>
                </div>
            </div>

    <!-- Logo -->
    <div class="flex justify-center mb-5 sm:mb-6">
      <img src="assets/logo/logo.jpg" alt="" class="w-20 h-20 sm:w-24 sm:h-24 object-contain rounded-full shadow-md">
    </div>

    <h2 class="text-2xl sm:text-3xl font-extrabold text-center text-gray-800 mb-5">Procurement & Assets Management System</h2>

    <form id="frmLogin" class="space-y-4 sm:space-y-5">
      <div>
        <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
        <input type="text" id="email" name="email" 
               class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
      </div>

      <div>
        <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
        <input type="password" id="password" name="password" 
               class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
      </div>

     

      <div>
      <button type="submit" id="btnLogin" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-semibold text-white bg-red-800 hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-700 transition duration-200">
        Sign in
        </button>

      </div>
    </form>
  </div>

  <script src="assets/js/app.js"></script>
</body>
</html>