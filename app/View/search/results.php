<?php
/**
 * Created by PhpStorm.
 * User: pgk
 * Date: 3/1/18
 * Time: 11:48 AM
 */

use Pgk\Core\Config;

?>
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    td {
        border: 1px solid;
        padding: 2px;
    }
</style>

<div class="container">
<?php

    $this->renderFeedbackMessages(); ?>

    <div class="container-header">
		<h1>Index page</h1>
		<?php require Config::get('template_path') . 'navigation.php';?>
    </div>

    <?php if( !empty($this->data) ): ?>
    <div class="box" style="min-height: 350px;">
        <table>
            <?php foreach ($this->data as $result): ?>
                <tr>
                    <?php foreach ($result as $key => $item): ?>
                        <td><?= $item ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>


</div>