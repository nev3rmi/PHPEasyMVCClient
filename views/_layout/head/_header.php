<?php if (!empty($thisPageUpperContent)){ ?>
  <div class="upper-containner">
    <?php require_once $thisPageUpperContent;?>
  </div>
<?php } ?>

<?php if ($thisPageBreadCrumbUse == 1){?>
  <header class="business-header">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="tagline"><?php echo $thisPageHeading?> <small><?php echo $thisPageSubHeading?></small></h1>
          <ol class="breadcrumb">
            <?php 
              echo generateLinkPath($_documentPath, $_url);
            ?>
          </ol>
        </div>
      </div>
    </div>
  </header>
<?php } ?>