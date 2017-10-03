<div>
Your current version: <span><?php echo $this -> version -> site?></span>
</div>
<div>
Server version: <span><?php echo end($this -> version -> server)?></span>
</div>
<?php if ($this -> version -> update){?>
    <div>
    List to update: <ul>
    <?php foreach($this -> version -> list as $version){?>
        <li><?php echo $version ?></li>
    <?php } ?>
    </ul>
    </div>
    <div>
        <span> 
            <a href="/api/version/doupdate">Click to update!</a>
        </span>
    </div>
<?php }else{?>
    <div>
        <span> 
            Your Version is up to date!
        </span>
    </div>
<?php }?>