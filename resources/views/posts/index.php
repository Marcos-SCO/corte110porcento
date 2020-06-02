<article>
    <header>Últimas postagens</header>
    <?php
    Core\Controller::createMore($BASE, 'posts', 'Adicionar mais postagens');
    ?>
    <?php if (count($posts) > 0) { ?>
        <section class="blog flex-wrap card-group">
            <?php foreach ($posts as $data) { ?>
                <figure class="d-flex justify-content-center blogFig card">
                    <a href="<?= $BASE ?>/posts/show/<?= $data->id ?>">
                        <div class="imgMax">
                            <img class="card-img-top" src="<?= $BASE ?>/public/img/posts/id_<?= $data->id ?>/<?= $data->img ?>" alt="<?= $data->img ?>" title="<?= $data->title ?>">
                        </div>
                        <figcaption class="blogBody card-body">
                            <h5 class="blogTitle card-title"><?= $data->title ?></h5>
                            <span class="blogSpan card-text"><?= $data->body ?></span>
                            <small class="updated card-text">Atualizado em <?= dateFormat($data->updated_at) ?></small>
                        </figcaption>
                    </a>
                    <?php
                    Core\Controller::editDelete($BASE, 'posts', $data, 'Quer mesmo deletar essa postagem?');
                    ?>
                </figure>
            <?php } ?>
        </section>
</article>
<?php } ?>