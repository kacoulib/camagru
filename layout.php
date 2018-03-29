<!DOCTYPE html>
<html>
  <head>
      <title><?php echo $title; ?></title>
      <meta charset="utf-8"/>
      <link rel="stylesheet" href="stylesheet/app.css" type="text/css">
      <style>
      .quantity
      {
        width: 100px;
      }
			#admin_curd span
			{
			  display: inline-block;
			  padding-left: 10px;
			  width: 50px;
			  min-width: 70px;
			}
      a
      {
        cursor: pointer;
      }
      #sort
      {
        position: relative;
        display: inline-block;
      }
      #sort:hover ul
      {
        display: block;
      }

      #sort p
      {
        background: rgba(167, 160, 160, 0.48);
      }
      #sort ul
      {
        display: none;
      }
      #sort p,
      #sort ul
      {
        margin: 0;
        padding: 0;
      }
      </style>
  </head>
  <body>
    <?php include('views/_header.php'); ?>
    <?php include($childView); ?>
    <?php include('views/_footer.php'); ?>
  </body>
</html>
