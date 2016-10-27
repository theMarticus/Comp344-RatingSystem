<?php
//Includes the application header
include '../layouts/header.php';
//Allows function calls and connection database
include '../controller/controller.php';
?>
<script src="/js/stars.js" type="text/javascript"></script>

<div class = "container">
      <?php displayProduct($dbo);?>
      <!--Form-->
      <form class = "form-inline">
        <div class="form-group">
          <label for="ex1">Qty:</label>
          <input class="form-control" id="quantity" name = "quantity" type="text"><br/><br/>
          <?php displayProductAttributes($dbo); ?>
          <button type="submit" class="btn btn-default btn-lg">Add To Cart</button>
        </div>
      </form>
      <br/>
    </div>
  </div>
   <div class = "row">
    <?php displayProductReviews($dbo); ?>
  </div>
  <div class = "row">
    <?php displayProductRecommendations($dbo); ?>
  </div>
</div>


<?php

//includes the footer of the application
include '../layouts/footer.php';
?>
