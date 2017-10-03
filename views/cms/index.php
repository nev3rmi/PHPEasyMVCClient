<div id="cms-content" style="z-index:10000;">
    <?php 
        echo $this -> cms -> content -> code; 
    ?>
</div>
<div id="footer">
    <div class="pull-left" style="z-index:10000;">
        <div class="btn-group btn-group-lg">
            <button type="button" style="z-index:10000;" class="btn btn-default" onclick="PHPEasy.Page.Sitemap.Admin.Pages.Page.CMS.Content().Save(<?php echo $this->stageId?>)"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
            <button type="button" style="z-index:10000;" class="btn btn-success" onclick="PHPEasy.Page.Sitemap.Admin.Pages.Page.CMS.Content().Apply(<?php echo $this->stageId?>)"><i class="fa fa-check" aria-hidden="true"></i> Apply</button>
        </div>
    </div>
</div>