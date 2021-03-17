<?php echo $this->extend('layout') ?>
<?php echo $this->section('content') ?>
<main class="container">

    <div class="row no-gutters mb-3">
        <h3 class=" mx-auto">Para acessar as estatísticas dos links encurtados, logue-se ou crie uma conta</h3>
    </div>
    <div class="row">
        <div class="col-sm-6 mx-auto">
            <h1>Logue-se</h1>
            <?php echo form_open('login/signin') ?>
            <div class="form-group">
                <label for="email_login">E-mail</label>
                <input type="email" name="email_login" id="email_login" class="form-control">
            </div>
            <div class="form-group">
                <label for="senha_login">Senha</label>
                <input type="password" name="senha_login" id="senha_login" class="form-control">
            </div>
            <p><?php echo anchor('user/esqueciSenha', 'Esqueci minha senha...') ?></p>
            <button type="submit" class="btn btn-primary">Entrar</button>
            </form>
            <?php $error_login = session()->getFlashdata('error_login'); ?>
            <?php if (!empty($error_login)) : ?>
                <div class="alert alert-danger mt-2">
                    <?php echo $error_login; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-sm-6 mx-auto">
            <h1>Cadastre-se</h1>
            <?php echo form_open('user/store') ?>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" class="form-control">
                <?php if (!empty($errors['email'])) : ?>
                    <div class="alert alert-danger mt-2"><?php echo $errors['email'] ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" class="form-control">
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
            <button type="submit" class="btn btn-secondary">Cadastrar</button>
            </form>
            <?php if (!empty($errors['url'])) : ?>
                <div class="alert alert-danger mt-2"><?php echo $errors['url'] ?></div>
            <?php endif; ?>
        </div>
    </div>



</main><!-- /.container -->
<?php echo $this->endSection() ?>