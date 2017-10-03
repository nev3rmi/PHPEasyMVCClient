<form id="formAddUpdatePagesContent" method="post" onsubmit="return false;">
  <div class="form-group">
    <label for="stageName">Stage Name:</label>
    <input type="text" class="form-control" id="stageName" name="stageName" value="<?php echo $this -> data['StageName'] ?>">
  </div>
  <div class="form-group">
    <label for="language">Language:</label>
    <select class="form-control selectlanguage" name="language">
      <?php if (!empty($this -> data)){?>
        <option value="<?php echo $this -> data["LanguageId"]?>"><?php echo $this -> data["LanguageName"]?></option>
        <option value="n/a" disabled>--------------------------------</option>
      <?php }?>
      <?php foreach ($this -> language as $lang){ ?>
        <option value="<?php echo $lang["LanguageId"]?>"><?php echo $lang["LanguageName"]?></option>
      <?php } ?>
    </select>
  </div>
  <div class="form-group">
    <label for="description">Description:</label>
    <textarea class="form-control" rows="5" id="description" name="description"><?php echo $this -> data['StageDescription'] ?></textarea>
  </div>
  <div class="form-group">
    <label for="display">Hide:</label>
    <div class="checkbox">
      <label class="checkbox-inline"><input type="checkbox" value="1" name="hide[0]" <?php echo (($this -> data['HideNavigationBar'])? "checked" : "")?>>Navigation Bar</label>
      <label class="checkbox-inline"><input type="checkbox" value="1" name="hide[1]" <?php echo (($this -> data['HideFooter'])? "checked" : "")?>>Footer</label>
    </div>
  </div>
  <div class="form-group">
    <label for="navigation">Navigation Bar Config:</label>
    <div class="radio">
      <label class="radio-inline"><input type="radio" value="2" name="navigation[0]" <?php echo (($this -> data['NavbarConfig']) == 2? "checked" : "")?>>Sticky</label>
      <label class="radio-inline"><input type="radio" value="1" name="navigation[0]" <?php echo (($this -> data['NavbarConfig']) == 1? "checked" : "")?>>Fixed</label>
      <label class="radio-inline"><input type="radio" value="0" name="navigation[0]" <?php echo (($this -> data['NavbarConfig']) == 0? "checked" : "")?>>None</label>
    </div>
    <label for="navigation">Navigation Bar Transparent:</label>
    <div class="checkbox">
      <label class="checkbox-inline"><input type="checkbox" value="1" name="navigation[1]" <?php echo (($this -> data['NavbarTransparent'])? "checked" : "")?>>Transparent</label>
    </div>
  </div>
</form>