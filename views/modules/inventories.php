<style>
    .table td{
        padding: .5em;
    }
</style>

<?php $inventories = ControllerGeneral::ctrRecord('all','inventories','where site='.$user['site'] ) ?>

<div class="content-wrapper">
    <section class="content pt-2">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover w-100 text-sm" id="tbl_inventories">
                    <thead class="text-center">
                    <th>ref</th>
                    <th>Producto</th>
                    <th>Cargues</th>
                    <th>Ventas</th>
                    <th>Devoluciones</th>
                    <th>Cambios</th>
                    <th>Existencias</th>
                    </thead>
                    <tbody>
                    <?php foreach ( $inventories as $row ){ echo '
            <tr>
            <td>'.$row['reference'].'</td>
            <td>'.$row['product'].'</td>
            <td class="text-center">'.$row['loads'].'</td>
            <td class="text-center">'.$row['sales'].'</td>
            <td class="text-center">'.$row['returns'].'</td>
            <td class="text-center">'.$row['changes'].'</td>
            <td class="text-center">'.$row['stock'].'</td>
            </tr>
            '; }?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>