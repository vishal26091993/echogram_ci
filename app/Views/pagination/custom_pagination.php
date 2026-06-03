<?php $pager->setSurroundCount(2); ?>

<ul class="pagination">
    <?php if ($pager->hasPrevious()) : ?>
        <li class="paginate_button page-item previous">
            <a href="<?= $pager->getFirst() ?>" aria-controls="site_list" class="page-link"><?= lang('Pager.first') ?></a>
        </li>
        <li class="paginate_button page-item previous">
            <a href="<?= $pager->getPrevious() ?>" aria-controls="site_list" class="page-link"><?= lang('Pager.previous') ?></a>
        </li>
    <?php else : ?>
        <li class="paginate_button page-item previous disabled">
            <a href="#" aria-controls="site_list" class="page-link"><?= lang('Pager.previous') ?></a>
        </li>
    <?php endif ?>

    <?php foreach ($pager->links() as $link) : ?>
        <li class="paginate_button page-item <?= $link['active'] ? 'active' : '' ?>">
            <a href="<?= $link['uri'] ?>" aria-controls="site_list" class="page-link"><?= $link['title'] ?></a>
        </li>
    <?php endforeach ?>

    <?php if ($pager->hasNext()) : ?>
        <li class="paginate_button page-item next">
            <a href="<?= $pager->getNext() ?>" aria-controls="site_list" class="page-link"><?= lang('Pager.next') ?></a>
        </li>
        <li class="paginate_button page-item next">
            <a href="<?= $pager->getLast() ?>" aria-controls="site_list" class="page-link"><?= lang('Pager.last') ?></a>
        </li>
    <?php else : ?>
        <li class="paginate_button page-item next disabled">
            <a href="#" aria-controls="site_list" class="page-link"><?= lang('Pager.next') ?></a>
        </li>
    <?php endif ?>
</ul>
