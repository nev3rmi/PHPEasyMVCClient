<form id="formAddUpdateGroups" method="post" onsubmit="return false;">
  <div class="form-group">
    <label for="groupName">Group Name:</label>
    <input type="text" class="form-control" id="groupName" name="groupName" value="<?php echo $this -> data['GroupName']?>">
  </div>
  <div class="form-group">
    <label for="description">Description:</label>
    <input type="text" class="form-control" id="description" name="description" value="<?php echo $this -> data['GroupDescription']?>">
  </div>
</form>