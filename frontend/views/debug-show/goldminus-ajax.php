<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
           （金币）非正常扣除
        </div>

        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>字段名</th>
                            <th>值</th>
                            <th>是否正确</th>
                            <th>备注(例子
                                )</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(!empty($resultArr)){
                        list($result,$FieldConfig,$fieldMap,$example,$verif) = $resultArr;
                        foreach($result as $key=>$item){
                            if($key != 0){
                                echo '<tr style="background-color: #9AC0CD;"><td colspan="4">&nbsp;&nbsp;</td></tr>';
                            }
                            foreach($FieldConfig as $field) {
                                echo '<td>'.$fieldMap[$field].'</td>';
                                if(in_array($field,['timestamp'])){
                                   echo '<td>'.date('Y-m-d H:i:s',$item[$field]).'</td>';
                                }else{
                                    echo '<td>'.$item[$field].'</td>';
                                }
                                echo '<td>';
                                if(!empty($item[$field]) || $item[$field] === 0){
                                    if(isset($verif[$field]) && in_array($item[$field],$verif[$field])){
                                        echo '<span class="glyphicon glyphicon-remove" style="color: rgb(255, 0, 0);"></span> 错误!';
                                    }else{
                                        echo '<span class="glyphicon glyphicon-ok" style="color: rgb(0, 187, 0);"></span> 正确';
                                    }

                                }else{
                                    echo '<span class="glyphicon glyphicon-ok" style="color: rgb(0, 187, 0);"></span> 正确';
                                }
                                echo '</td>';
                                echo '<td>'.$example[$field].'</td>';
                                echo '</tr>';


                            }

                        }
                    }else{
                        echo '<tr><td colspan="4" style="color:red;">暂无数据！</td></tr>';
                    }
                    ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>


