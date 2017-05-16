<div class="form">

    <form id="news-form" action="/index.php?r=newsSmarty/create" method="post">
        <p class="note">包含 <span class="required">*</span> 的表单项为必填项.</p>
        {$errormsgs}
        {foreach from=$attributes key=key item=value}
        <div class="row">
            <label for="{$model}_{$key}">{$attributes_label[$key]}</label>		
            <input size="60" maxlength="200" name="{$model}[{$key}]" id="{$model}_{$key}" type="text" value="" />			
        </div>
        {/foreach}
        
        <div class="row buttons">
            <input type="submit" name="yt0" value="{$action}" />	
        </div>

    </form>
</div><!-- form -->