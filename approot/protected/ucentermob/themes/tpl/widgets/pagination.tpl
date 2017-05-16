{if $pages.totalPage >1}
        <ul class="pagination pull-right">
                <li {if $pages.curPage==1}class="disabled"{/if}> <a href="{$pages.url}1" title="第一页"> <i class="ace-icon fa fa-angle-double-left"></i> </a> </li>
                        {if $pages.curPage>1}
                        <li class="disabled"> <a href="{$pages.url}{$pages.curPage-1}" title="前一页"> <i class="ace-icon fa fa-angle-left"></i> </a> </li>
                        {/if}
                        {if $pages.totalPage<=5}
                                {section name=one loop=$pages.totalPage start=0 step=1 max=5} 
                                <li {if $pages.curPage ==($smarty.section.one.index+1)}class="active"{/if}> <a href="{if $pages.curPage !=($smarty.section.one.index+1)}{$pages.url}{$smarty.section.one.index+1}{else}#{/if}">{$smarty.section.one.index+1}</a> </li>
                                {/section}
                        {else}
                                {if $pages.curPage<5}

                                {section name=one loop=$pages.totalPage start=0 step=1 max=5} 
                                        <li {if $pages.curPage ==($smarty.section.one.index+1)}class="active"{/if}> <a href="{if $pages.curPage !=($smarty.section.one.index+1)}{$pages.url}{$smarty.section.one.index+1}{else}#{/if}">{$smarty.section.one.index+1}</a> </li>
                                        {/section}

                        {else}
                                {if $pages.curPage>$pages.totalPage}
                                        {section name=one loop=$pages.totalPage start=0 step=1 max=5}
                                                <li {if $pages.curPage ==($smarty.section.one.index+1)}class="active"{/if}> <a href="{if $pages.curPage !=($smarty.section.one.index+1)}{$pages.url}{$smarty.section.one.index+1}{else}#{/if}">{$smarty.section.one.index+1}</a> </li>
                                                {/section}
                                        {else}
                                                {if $pages.curPage==$pages.totalPage}
                                                        {section name=one loop=$pages.totalPage start=$pages.curPage-5 step=1 max=5} 
                                                        <li {if $pages.curPage ==($smarty.section.one.index+1)}class="active"{/if}> <a href="{if $pages.curPage !=($smarty.section.one.index+1)}{$pages.url}{$smarty.section.one.index+1}{else}#{/if}">{$smarty.section.one.index+1}</a> </li>
                                                        {/section}
                                                {else}
                                                        {section name=one loop=$pages.totalPage start=$pages.curPage-4 step=1 max=5} 
                                                        <li {if $pages.curPage ==($smarty.section.one.index+1)}class="active"{/if}> <a href="{if $pages.curPage !=($smarty.section.one.index+1)}{$pages.url}{$smarty.section.one.index+1}{else}#{/if}">{$smarty.section.one.index+1}</a> </li>
                                                        {/section}
                                                {/if}

                                {/if}
                        {/if}
                {/if}
                {if $pages.curPage<$pages.totalPage}
                        <li> <a href="{$pages.url}{$pages.curPage+1}" title="后一页"> <i class="ace-icon fa fa-angle-right"></i> </a> </li>
                        {/if}
                <li {if $pages.curPage==$pages.totalPage}class="disabled"{/if} title="末页"> <a href="{$pages.url}{$pages.totalPage}"> <i class="ace-icon fa fa-angle-double-right"></i> </a> </li>
        </ul>
{/if}