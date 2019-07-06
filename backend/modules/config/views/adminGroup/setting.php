<?php
//$this->pageCss('../resources/plugins/ztree/css/zTreeStyle.css');
//$this->pageJs('../resources/plugins/ztree/js/jquery.ztree.core-3.5.min.js');
//$this->pageJs('../resources/plugins/ztree/js/jquery.ztree.excheck-3.5.min.js');
?>



<input type="hidden" id="ag_id" value="<?php echo $agInfo['ag_id']; ?>"/>
<!--<link href="/plugins/ztree/css/zTreeStyle.css" rel="stylesheet">-->
<!--<script type="text/javascript" src="/plugins/ztree/js/jquery.ztree.core-3.5.min.js"></script>-->
<!--<script type="text/javascript" src="/plugins/ztree/js/jquery.ztree.excheck-3.5.min.js"></script>-->
<SCRIPT LANGUAGE="JavaScript">
    var zTreeObj;
    // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
    var setting = {
        check: {
            enable: true
        },
    };
    // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
    var zNodes =
        <?php echo $data; ?>
        ;
    $(document).ready(function () {
        zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
    });

</SCRIPT>
<h4>用户组ID:<?php echo $agInfo['ag_id']; ?>
    &nbsp;&nbsp;&nbsp;&nbsp;用户组名称:<?php echo $agInfo['name']; ?></h4>

<div>
    <ul id="treeDemo" class="ztree"></ul>
</div>