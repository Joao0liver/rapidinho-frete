<?php

    while ($row = mysqli_fetch_array($sql)){
        echo '<tr>
        <th scope="row">'.$row['id_user'].'</th>
        <td>'.$row['nome_user'].'</td>
        <td>'.$row['email_user'].'</td>
        <td>'.$row['cpf_user'].'</td>
        <td>'.$row['ende_user'].'</td>
        <td>'.status($row['status_user']).'</td>
        <td>
        <a href="editar_cliente_adm.php?id_cliente='.$row['id_user'].'"><img src="../layout/img/lapis.png" height="18px" width="18px" style="margin-right: 8px;"></a>';
        if ($row['status_user'] == 1){
        echo '<a href="excluir_cliente_adm.php?id_cliente='.$row['id_user'].'" onclick="confirmaDel(event, '.$row['id_user'].')"><img src="../layout/img/lixo.png" height="18px" width="18px"></a>
        </td>
        </tr>';
        }

    }

?>