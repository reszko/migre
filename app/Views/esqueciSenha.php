<?php echo $this->extend('layout') ?>
<?php echo $this->section('content') ?>
<main class="container">
    <div class="row">
        <div class="col-sm-8">
            <h1>Esqueci minha senha</h1>
            <p>Digite o e-mail utilizado no cadastro para que uma nova senha seja enviada ao seu e-mail.</p>
            <?php echo form_open('user/checkSenha', ['onsubmit' => "$('#btn_submit').text('Aguarde...').attr('disabled', true);"]) ?>
            <div class="form-group">
                <label for="email">E-mail utilizado no cadastro</label>
                <input type="email" name="email" id="email" class="form-control" autofocus>
                <?php if (!empty($errors['email'])) : ?>
                    <div class="alert alert-danger mt-2"><?php echo $errors['email'] ?></div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary" id="btn_submit">Verificar</button>
            <?php echo form_close() ?>
        </div>
    </div>
</main><!-- /.container -->
<?php echo $this->endSection() ?>