<form id="formAddUpdatePages" method="post" onsubmit="return false;">
  <div class="form-group">
    <label for="controllerId">Select Controller Name: *</label>
    <select class="form-control selectController" name="controllerId">
      <?php 
        if (!empty($this -> data)){
      ?>
          <option value="<?php echo $this -> data["ControllerId"]?>"><?php echo $this -> data["ControllerName"]?></option>
      <?php } ?>
    </select>
  </div>
  <div class="form-group">
    <label for="functionName">Page Name: *</label>
    <input type="text" class="form-control" id="functionName" name="functionName" value="<?php echo $this -> data["FunctionName"]?>">
  </div>
  <div class="form-group">
    <label for="pageUrl">Page Url: *</label>
    <input type="text" class="form-control" id="pageUrl" name="pageUrl" value="<?php echo $this -> data["PageUrl"]?>">
  </div>
  <div class="form-group">
    <label for="pagePassword">Password:  
    <?php 
      if(!empty($this -> data["Password"])){
    ?>
      <b>Yes</b>
    <?php    
      }else{
    ?>
      <b>No</b>
    <?php
      }
    ?>
    - (Type "^Delete" to delete password)
    </label>
    <input type="password" class="form-control" id="pagePassword" name="pagePassword" value="">
  </div>
  <div class="form-group">
    <label for="parentId">Parent Page URL:</label>
    <select class="form-control parentId" name="parentId">
    <?php 
        if (!empty($this -> data)){
      ?>
          <option value="<?php echo $this -> data["ParentId"]?>"><?php echo $this -> data["ParentUrl"]?></option>
      <?php } ?>
    </select>
  </div>
</form>