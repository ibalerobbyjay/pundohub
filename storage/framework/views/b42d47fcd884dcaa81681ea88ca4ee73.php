<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'PundoHub'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
     body {
  overflow-x: hidden;
  font-family: "Poppins", sans-serif;
  background: url("<?php echo e(asset('images/background.jpg')); ?>") no-repeat center center fixed;
  background-size: cover;
  background-attachment: fixed;
  background-position: center;
  background-repeat: no-repeat;
}
</style>
</head>
<body class="bg-dark text-light">

    <?php echo $__env->yieldContent('content'); ?>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\pundohub\resources\views/layouts/auth.blade.php ENDPATH**/ ?>