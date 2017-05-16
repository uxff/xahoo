{include file="tpl.header.html"}

    <div class="span-19">
        <div id="content">

            <h1>Create <?php echo $this->modelClass; ?></h1>

            {include file="<?php echo strtolower($this->controllerID);?>/_form.php"}
        </div><!-- content -->
    </div>

    {include file="tpl.sidebar.html"}

</div><!-- page -->

{include file="tpl.footer.html"}