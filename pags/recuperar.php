<form method="POST">
    <h4>Recuperar Senha</h4>
    <label for="">Insira um email cadastrado</label>
    <input type="text" name="email" class="form-control" required>
    <code>Insira o email cadastrado para receber o código por email.</code>
    <input type="submit" value="Enviar dados" class="btn btn-outline-success btn-lg btn-block">
    <input type="hidden" name="env" value="form">

</form>
<?php echo verifica_dados($con);?>