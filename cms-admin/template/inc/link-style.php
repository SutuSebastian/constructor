    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
    <?php if (!LOGGED_IN) { ?>
    <!-- Login CSS -->
    <link rel="stylesheet" href="template/assets/css/login.css">
    <?php } else { ?>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="template/assets/css/style.css">
    <?php } ?>
