<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View
 * @var $model \frontend\models\UserCard
 */

$this->title = 'My Yii Application';
?>
<?php if(!empty($user_card)) { ?>
<?php foreach ($user_card as $item) {
    $user_data = $item;
} ?>
    <div class="site-index">

        <div class="container">
            <div class="col-md-3">
                <h2>Card data</h2>
                <table class="table table-hov   er">
                    <tbody>
                    <tr>
                        <td><?php echo $user_data->user->username; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $user_data->card_number; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $user_data->card_amount; ?> грн</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <div class="row">

                    <?php $form = ActiveForm::begin([
                        'id' => 'transaction',
                        'method' => 'post',
                        'action' => 'card/transaction',
                    ]); ?>
                    <?php $model = new \frontend\models\UserCard(); ?>
                        <br><br><br>
                        <div class="input-group-md">
                            <label for="sum">Sum</label>
                            <?= Html::input('text', 'sum', '', [
                                'id' => 'send_currency',
                                'class' => 'form-control',
                                'pattern' => '^[\d]*\.?[0-9]{0,2}$'
                            ]); ?><br>
                        </div>

                        <div class="input-group-md">
                            <?= $form->field($model, 'card_number')->textInput([
                                'autofocus' => true,
                                'placeholder' => 'XXXX XXXX XXXX XXXX'
                            ]); ?>
                        </div>

                        <div class="input-group-md">
                            <label for="sum">Receiver card number</label>
                            <?= Html::input('text', 'receiver_card_number', '', [
                                'placeholder' => 'XXXX XXXX XXXX XXXX',
                                'id' => 'send_currency',
                                'class' => 'form-control',
                                'pattern' => '^[\d]{16}$'
                            ]); ?><br>
                        </div>

                        <div class="input-group-md">
                            <?= $form->field($model, 'expiration_date')->textInput([
                                'autofocus' => true,
                                'placeholder' => 'Format yyyy-m'
                            ]); ?>
                        </div>

                        <div class="input-group-md">
                            <?= $form->field($model, 'cv2')->textInput([
                                'autofocus' => false,
                                'autocomplete' => 'false',
                                'placeholder' => '***'
                            ]); ?>
                        </div>

                        <div class="form-group">
                            <?= Html::submitButton('Send', [
                                'class' => 'btn btn-primary',
                                'name' => 'signup-button'
                            ]); ?>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
<div class="site-index">
    <div class="container">
        <h1>You have not any card.</h1>
    </div>
</div>
<?php } ?>