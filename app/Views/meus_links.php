<?php echo $this->extend('layout') ?>
<?php echo $this->section('content') ?>
<script>
    function confirma() {
        if (!confirm('Confirma a exclusão deste link?')) {
            return false;
        }

        return true;

    }
</script>
<main class="container">
    <h1>Meus links</h1>
    <p><small>Links ordenados por <strong>clicks</strong> e <strong>data de criação</strong> descrescentes.</small></p>
    <p class="text-right"><?php echo anchor(base_url(), 'Encurtar novo link...') ?></p>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Link Original</th>
                    <th>Link Encurtado</th>
                    <th>Clicks</th>
                    <th>Criado em</th>
                    <th>Último click</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($links) > 0) : ?>
                    <?php foreach ($links as $link) : ?>
                        <tr>
                            <td><?php echo $link['link_original'] ?></td>
                            <td><?php echo anchor($link['link_encurtado'], $link['link_encurtado'], ['target' => '_blank']) ?></td>
                            <td><?php echo $link['clicks'] ?></td>
                            <td><?php echo date('d/m/Y H:i:s', strtotime($link['created_at'])) ?></td>
                            <td><?php echo date('d/m/Y H:i:s', strtotime($link['updated_at'])) ?></td>
                            <td><?php echo anchor('link/delete/' . $link['id'], 'Excluir', ['onclick' => 'return confirma()']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="text-center">Nenhum link cadastrado. <?php echo anchor(base_url(), 'Encurtar um link...') ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</main><!-- /.container -->
<?php echo $this->endSection() ?>