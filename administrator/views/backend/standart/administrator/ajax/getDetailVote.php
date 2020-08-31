<table style="width: 100%;">
    <tr>
        <td colspan="3">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4><?=$one['title']?></h4>    
        </td>
    </tr>
    <?php
        $total = 1;
        if ($result) {
            foreach ($result as $one) {
                $total+=$one;
            }
        }
        if ($answers) {
            foreach ($answers as $key=>$one) {
                $percent = ($result[$key]/$total)*100; ?>
    <tr>
        <td style="width: 30%;"><?=$one?></td>
        <td style="width: 50%;">
            <div class="progress progress-striped" title="<?=toString($percent)?>%"><div style="width: <?=$percent?>%;" class="bar"></div></div>
        </td>
        <td style="width: 20%;"><?=$result[$key]?> phiếu</td>
    </tr>
    <?php
            }
        } ?>
</table>
<div class="controls controls-row">
<a href="/vote/delete?id=<?=$id?>" onclick="return confirm('Bạn có chắc chắn muốn xóa bản ghi này?');" class="btn_trash">Xóa bản ghi này</a>
</div>