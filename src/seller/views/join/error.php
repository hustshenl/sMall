<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="site-error">

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        The above error occurred while the Web server was processing your request.
    <br />
        服务器在处理您的请求时发生了上述错误！
    </p>
    <p>
        Please contact us if you think this is a server error. Thank you.
        <br />
        如果您认为这是服务器问题，请联系管理员。谢谢！
    </p>

</div>
