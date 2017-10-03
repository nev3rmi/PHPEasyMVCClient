<form method="post" class="form-horizontal permission-group-form">
<?php foreach ($this -> data as $key => $value) { ?>
<div class="form-group">
    <label class="col-xs-4 control-label"><?php echo $key;?>: </label>
    <div class="col-xs-8">
        <input 
            type="checkbox" 
            data-toggle="toggle" 
            value="<?php echo $this -> permissionData[$key]?>"
            <?php echo ($value === true)?'checked':''; ?>
            data-on="Allow" 
            data-off="Not Allow"
            data-onstyle="success" 
            data-offstyle="default"
            data-page="<?php echo $this -> page;?>"
            data-group="<?php echo $this -> group;?>"
            class="permission-group-input"
        >    
    </div>
</div>
<?php } ?>
</form>