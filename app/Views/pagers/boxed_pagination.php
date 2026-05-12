<?php $pager->setSurroundCount(2) ?>

<style>
    .pagination-boxed {
        display: flex;
        padding-left: 0;
        list-style: none;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        overflow: hidden;
        width: fit-content;
    }
    .pagination-boxed .page-item {
        margin: 0;
        border-right: 1px solid #dee2e6;
    }
    .pagination-boxed .page-item:last-child {
        border-right: none;
    }
    .pagination-boxed .page-link {
        position: relative;
        display: block;
        padding: 0.5rem 1rem;
        color: #495057;
        text-decoration: none;
        background-color: #f8f9fa;
        border: none;
        font-size: 0.875rem;
        transition: all 0.2s;
    }
    .pagination-boxed .page-link:hover {
        background-color: #e9ecef;
        color: #000;
    }
    .pagination-boxed .page-item.active .page-link {
        z-index: 3;
        color: #333;
        background-color: #fff;
        font-weight: bold;
    }
    .pagination-boxed .page-item.disabled .page-link {
        color: #adb5bd;
        pointer-events: none;
        background-color: #f8f9fa;
    }
</style>

<nav aria-label="Page navigation">
    <ul class="pagination-boxed mb-0 shadow-sm">
        <?php if ($pager->hasPrevious()) : ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getFirst() ?>" aria-label="First">
                    <span>First</span>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getPrevious() ?>" aria-label="Previous">
                    <span>Previous</span>
                </a>
            </li>
        <?php else : ?>
            <li class="page-item disabled">
                <a class="page-link" href="#">First</a>
            </li>
            <li class="page-item disabled">
                <a class="page-link" href="#">Previous</a>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a class="page-link" href="<?= $link['uri'] ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()) : ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getNext() ?>" aria-label="Next">
                    <span>Next</span>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getLast() ?>" aria-label="Last">
                    <span>Last</span>
                </a>
            </li>
        <?php else : ?>
            <li class="page-item disabled">
                <a class="page-link" href="#">Next</a>
            </li>
            <li class="page-item disabled">
                <a class="page-link" href="#">Last</a>
            </li>
        <?php endif ?>
    </ul>
</nav>
