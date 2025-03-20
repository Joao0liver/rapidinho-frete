<?php

session_start();

if($_SESSION['id_user'] == '' || $_SESSION['email_user'] == null){
    
    header('Location: ../index.php');
    exit();
    
}else{

include_once("../layout/header_cliente.php");

?>

<!-- Blank Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row vh-100 bg-light rounded align-items-center justify-content-center mx-0">
                    <div class="col-md-6 text-center">
                        <h3>Olá, xxxxxx...</h3>
                        <h5>Seja bem-vindo ao Rapidinho Frete!</h5>
                    </div>
                </div>
            </div>
<!-- Blank End -->

<?php

include_once("../layout/footer.php");
}   

?>