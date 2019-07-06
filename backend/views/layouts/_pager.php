<ul class="pagination" >
    <li ><a href = "#" > 共<?php echo $Pager->pageTotal ?>页</a></li>
<?php if ($Pager->pagePrev) { ?>
    <li><a href="<?php echo $Pager->url($Pager->pagePrev) ?>">Prev</a></li>
<?php } ?>
<?php for ($i = $Pager->pageStart; $i <= $Pager->pageEnd; $i++) { ?>
    <li <?php if ($Pager->pageCurrent == $i){ ?>class="active"<?php } ?>>
        <a href="<?php echo $Pager->url($i) ?>"><?php echo $i ?></a>
    </li>
<?php } ?>
<?php if ($Pager->pageNext) { ?>
    <li><a href="<?php echo $Pager->url($Pager->pageNext) ?>">Next</a></li>
<?php } ?>
<input type="text" class="form-control" id="inputPage" style="width:10%;display:inline">
<button type="button" class="btn btn-default" style="vertical-align:top">跳转</button>
</ul>
<script type="text/javascript">
    $(function () {
        $('.pagination :button').on('click', function () {
            inputPage = $('#inputPage').val();
            if (!isNaN(inputPage)) {
                //获取当前url
                var oUrl = window.location.href.toString();
                var re = eval('/(p=)([^&]*)/gi');
                if (oUrl.match(re)) {
                    var nUrl = oUrl.replace(re, 'p=' + inputPage);
                } else {
                    if (oUrl.indexOf('?') == -1) {
                        var nUrl = oUrl + '?p=' + inputPage;
                    } else {
                        var nUrl = oUrl + '&p=' + inputPage;
                    }
                }
                window.location = nUrl;
            } else {
                $('#inputPage').val('');
            }
        });
    });

</script>