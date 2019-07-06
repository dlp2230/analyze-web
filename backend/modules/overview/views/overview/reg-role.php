<form action="/overview/overview/reg-role" method="get" class="form-inline well" role="form" id="search_form_ajax">
    <div class="form-group">
        <lable>起始日期：</lable>
        <input type="text" value="" readonly class="form-control" id="start_time" name="start_time">
    </div>
    <div class="form-group">
        <lable>结束日期：</lable>
        <input type="text" value="" readonly class="form-control" id="end_time" name="end_time">
    </div>
    <button type="submit" class="btn btn-sm btn-info">检索</button>
</form>
<div class="row" id="ajax-content">

</div>
<script type="text/javascript">
    $("#start_time").datetimepicker({
        //format: 'yyyy-mm-dd hh:ii',
        format: 'yyyy-mm-dd',
        language:'zh-CN',
        minView:'2',
    });
    $("#end_time").datetimepicker({
        format: 'yyyy-mm-dd',
        language:'zh-CN',
        minView:'2',
    });

</script>