<?php foreach ($this->groups as $groupId => $groupItem): ?>
    <section class="sky-form">
        <h4><?= $groupItem; ?></h4>
        <div class="row1 scroll-pane">
            <div class="col col-4">
                <?php foreach ($this->attrs[$groupId] as $attrId => $value): ?>
                    <label class="checkbox">
                        <input type="checkbox" name="checkbox" value="<?= $attrId; ?>"><i></i>
                        <?= $value; ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endforeach; ?>
