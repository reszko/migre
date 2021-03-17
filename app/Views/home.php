<?php echo $this->extend('layout') ?>
<?php echo $this->section('content') ?>

<main class="container">
    <?php $link_encurtado = session()->getFlashdata('link_encurtado'); ?>
    <?php $messages = session()->getFlashdata('messages'); ?>
    <div class="starter-template text-center py-5 px-3">
        <img src="<?php echo base_url('assets/imagens/logotipo.png') ?>" alt="Logotipo mig.re" style="width: 200px;">
        <p><small>Para estatísticas, logue-se antes de encurtar a URL</small></p>
        <?php echo form_open('link/store', ['autocomplete' => 'off', 'onsubmit' => "$('#btn_submit').text('Aguarde...').attr('disabled', true);"]) ?>
        <div class="form-row d-flex justify-content-center">
            <div class="form-group col-md-6">
                <input type="url" class="form-control" autofocus required name="link_original" id="link_original" placeholder="Cole aqui a URL que deseja encurtar" value="<?php echo !empty($messages['link_original']) ? $messages['link_original'] : '' ?>">
            </div>
            <div class="form-group col-md-1">
                <button type='submit' class="btn btn-primary" id="btn_submit">Encurtar</button>
            </div>
        </div>


        <?php if (!empty($errors['link_original'])) : ?>
            <div class="alert alert-danger mt-2"><?php echo $errors['link_original'] ?></div>
        <?php endif; ?>

        <?php echo form_close() ?>
        <?php if (is_array($messages) && count($messages) > 0) : ?>
            <div class="alert alert-success col-sm-6 mx-auto">
                <?php echo $messages['message']; ?>
            </div>
            <div class="form-group col-sm-4 mx-auto">
                <input type="text" value="<?php echo $messages['link_encurtado']; ?>" readonly class="form-control text-center" onclick="this.select()">
            </div>
        <?php endif; ?>
    </div>

</main><!-- /.container -->
<?php echo $this->endSection() ?>