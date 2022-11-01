<?php 
//vd($tpl['busStops']);
?>


<table class="pj-table" style="width: 100%;" cellspacing="0" cellpadding="0">
    <tbody>
        
        <?php foreach($tpl['busStops']  as $index => $busStop):?>
       
        <tr class="<?php echo $index & 1 ? 'pj-table-row-odd' : 'pj-table-row-even' ?>">
            <td><input type="checkbox" <?php if(in_array($busStop['id'], $tpl['cityBusStops'])):?>checked=""<?php endif?> name="bus_stops[]" value="<?=$busStop['id']?>" class="pj-table-select-row"></td>
            <td><span class="pj-table-cell-label"><?= $busStop['name'] ?></span></td>
            <td><span class="pj-table-cell-label"><?= $busStop['city'] . '  ' . $busStop['address'] ?></span></td>
        </tr>
         <?php endforeach;?>
    </tbody>
</table>