<h1>Contato</h1>
<p>Preencha os dados do nosso Formulário de Contato.</p>

<form class="form-horizontal" action="index.php?menu=contato-form.php" method="post">

    <!-- nome -->
    <div class="form-group">
        <label class="control-label col-xs-3" for="inputNome">Nome:</label>
        <div class="col-xs-9">
            <input type="text" class="form-control" id="inputNome" name="inputNome" placeholder="Nome">
        </div>
    </div>
    <!-- email -->
    <div class="form-group">
        <label class="control-label col-xs-3" for="inputEmail">Email:</label>
        <div class="col-xs-9">
            <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="Email">
        </div>
    </div>
    <!-- Assunto -->
    <div class="form-group">
        <label class="control-label col-xs-3" for="inputAssunto">Assunto:</label>
        <div class="col-xs-9">
            <input type="text" class="form-control" id="inputAssunto" name="inputAssunto" placeholder="Assunto">
        </div>
    </div>
    <!-- Contato -->
    <div class="form-group">
        <label class="control-label col-xs-3" for="textMensagem">Mensagem:</label>
        <div class="col-xs-9">
            <textarea rows="3" class="form-control" id="textMensagem" name="textMensagem" placeholder="Mensagem"></textarea>
        </div>
    </div>
    <br>
    <!-- Botões Enviar e Limpar -->
    <div class="form-group">
        <div class="col-xs-offset-3 col-xs-9">
            <input type="submit" class="btn btn-primary" value="Enviar">
            <input type="reset" class="btn btn-default" value="Limpar">
        </div>
    </div>

</form>