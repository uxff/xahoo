<div class="page-content-area">
    <div class="page-header">
        <h1> 所有{$data.name}查看页面
            <small><i class="ace-icon fa fa-angle-double-right"></i> 列表</small>
        </h1>
    </div>
    <!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">

                    <div class="table-responsive">
                        <table id="idTable" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    {*<th class="center"><label class="position-relative">*}
                                            {*<input type="checkbox" class="ace"/>*}
                                            {*<span class="lbl"></span> </label>*}
                                    {*</th>*}

                                    <th>用户编号</th>
                                    <th>用户名</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                {foreach from=$data->users key=i item=objModel}
                                    <tr>
                                        {*<td></td>*}
                                        <td>{$objModel.id}</td>
                                        <td>{$objModel.name}</td>
                                        <td>--</td>
                                    </tr>
                                {/foreach}
                            </tbody>
                        </table>
                    </div>
                    <div class="dataTables_paginate">
                        <!-- #section:widgets/pagination -->
                        {include file="../widgets/pagination.tpl"}
                        <!-- /section:widgets/pagination -->
                    </div>
                </div>
                <!-- /.col-xs-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.ol-xs-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.page-content-area --> 