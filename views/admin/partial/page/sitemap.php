<?php
// TODO: sau nay de cho ngta co the add, edit, update, delete tren nay luon khong can phai de ben kia nua :)
function _multilevel($categories, $parentId = 0, $char = '', $level = 0){

    $cate_child = array();

    foreach ($categories as $key => $item)
    {
        // Nếu là chuyên mục con thì hiển thị
        if ($item['ParentId'] == $parentId)
        {
            $cate_child[] = $item;
            unset($categories[$key]);
            // echo $char.$item['PageUrl'];
             
            // // Xóa chuyên mục đã lặp
            // unset($categories[$key]);
             
            // // Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
            // _multilevel($categories, $item['FunctionId'], $char.'|---');
        }
    }

    if ($cate_child)
    {
        if ($level == 0){
            echo '<ul class="sitemap">';
        }else{
            echo '<ul>';
        }
        
        foreach ($cate_child as $key => $item)
        {
            // Hiển thị tiêu đề chuyên mục
            echo '<li>';
            
            echo '<a href="'.$item['PageUrl'].'">'.$item['FunctionName'].'</a>';
             
            // Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
            _multilevel($categories, $item['FunctionId'], $char.'|---', $level++);
            echo '</li>';
        }
        echo '</ul>';
    }
} 
?>
<div class="wrapper">
    <?php
        _multilevel($this -> data);
    ?>
</div>