<div id="right">
    <div class="classList">
        <div class="title">版块列表</div>
        <ul class="listWrap">
            <?php
            $query="select * from sfk_father_module";
            $result_father=execute($link,$query);
            while ($data_father=mysqli_fetch_assoc($result_father)){
                ?>
                <li>
                    <h2><a href="list_father.php?id=<?php echo $data_father['id'];?>"><?php echo $data_father['module_name']?></a></h2>
                    <ul>
                        <?php
                        $query="select * from sfk_son_module where father_module_id={$data_father['id']}";
                        $result_son=execute($link,$query);
                        while($data_son=mysqli_fetch_assoc($result_son)){
                            echo "<li><h3><a href='list_son.php?id={$data_son['id']}'>{$data_son['module_name']}</a></h3></li>";
                        }
                        ?>
                    </ul>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>
</div>