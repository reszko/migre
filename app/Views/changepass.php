<?php echo $this->extend('layout') ?>
<?php echo $this->section('content') ?>
<main class="container">
    <div class="row">
        <div class="col-sm-6">
            <h1>Alteração de Senha</h1>
            <?php echo form_open('user/updatePass') ?>
            <div class="form-group">
                <label for="senha">Nova Senha</label>
                <input type="password" name="senha" id="senha" class="form-control" autofocus>
                <?php if (!empty($errors['senha'])) : ?>
                    <div class="alert alert-danger mt-2"><?php echo $errors['senha'] ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="senha_confirm">Repita a Senha</label>
                <input type="password" name="senha_confirm" id="senha_confirm" class="form-control">
                <?php if (!empty($errors['senha_confirm'])) : ?>
                    <div class="alert alert-danger mt-2"><?php echo $errors['senha_confirm'] ?></div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-secondary">Alterar</button>
            <input type="hidden" name="id" value="<?php echo session()->id ?>">
            <?php echo form_close() ?>
        </div>
    </div>
</main><!-- /.container -->
<?php echo $this->endSection() ?>