<?php
session_start();
include('../../db/bancodedados.php');

$id = $_POST['id'];
$nome = $_POST['nome'];

echo "<script>
    if(confirm('Deseja deletar a categoria  $nome ?')){
		var deletar = true;
    }
</script>";

$deletar = "<script>document.write(deletar);</script>";

try {
    if ($deletar == true) {
        unset($deletar);
        $instrucaoSQL = "DELETE FROM Produto WHERE idProduto = ?";
        $params = array( $id );
        $consulta = sqlsrv_query($conn, $instrucaoSQL, $params);
        $rows_affected = sqlsrv_rows_affected($consulta);

        if($rows_affected > 0){
            $_SESSION['msg'] = 'Produto deletado com sucesso';
			header('Location: /management-page-structure/product-management.php');
            
        }else{
            $_SESSION['erro'] = 'Erro ao deletar o produto';
			header('Location: /management-page-structure/product-management.php');
        }

    }else{
		header('Location: /management-page-structure/product-management.php');
	}

} catch (Exception $e) {
    die($e);
    $_SESSION['erro'] = 'Erro ao deletar o produto';
	header('Location: /management-page-structure/product-management.php');
}
?>
