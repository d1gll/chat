<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\Json;
use yii\helpers\HtmlPurifier;
?>
<?php Pjax::begin(); ?>


    <div class="container">

        <div class="row">

            <div class="col-md-6">

                <div class="row justify-content-center">

                        <div class="card card-bordered">

                            <div class="jumbotron">

                                <div class="card-header">

                            <h4 class="card-title"><strong>Чат</strong></h4>

                        </div>

                        </div>

                        <div class="ps-container ps-theme-default ps-active-y" id="chat-content" style="overflow-y: scroll !important; height:400px !important;">

                            <?php foreach (Json::decode($chat) as $chats => $value){?>

                            <div class="media media-chat">

                                <img class="avatar" src="https://img.icons8.com/color/36/000000/administrator-male.png" alt="...">

                                <?php echo $value['username'] ?>

                                <div class="media-body">

                                    <?php if ($value['rules'] == "admin") :?>

                                    <div class="alert-danger">

                                        <?php endif;?>

                                    <p class="meta">

                                        <span class="direct-chat-timestamp pull-right">

                                            <?php echo $value['tdata'] ?>

                                        </span>

                                            <?php if (Yii::$app->user->can('admin')) :?>

                                            <?= Html::beginForm() ?>

                                            <?=Html::a('На проверку', ['chats/check-chat'], [
                                                    'data' => [
                                                        'method' => 'post',
                                                        'params' => [
                                                            'id' => $value['id'],
                                                        ],
                                                    ],
                                                ]);?>

                                            <?= Html::endForm() ?>

                                            <?php endif;?>


                                    </p>

                                    <p><?php echo Html::encode($value['text'])  ?></p>

                                    <hr>

                                        <?php if ($value['rules'] == "admin") :?>

                                    </div>

                                        <?php endif;?>

                                </div>

                            </div>

                            <?php } ?>

                        </div>

                        <div class="box-footer">

                            <?php $form = ActiveForm::begin([
                                'options' => [
                                    'data-pjax' => true,
                                    'id'=>'form-text'
                                ]
                            ]); ?>

                            <div class="row">

                                <div class="col-md-8">

                                <?php  if (!Yii::$app->user->isGuest)  :?>

                                <?= $form->field($model, 'text')
                                        ->textInput(['autocomplete' => 'off', 'class'=>'form-control', 'type'=>'text','placeholder'=>'Введите сообщение...'])
                                        ->label(false)
                                ?>

                                <?php else : ?>

                                <div class="input-group info">
                                    <p>
                                        Авторизируйтесь, чтобы писать сообщения!
                                    </p>
                                </div>

                                <?php endif; ?>

                                </div>

                                    <div class="col-md-4">

                                        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary mb-2', 'id' =>'btn_send', 'name' => 'btn_send']) ?>

                                    </div>

                                <?php ActiveForm::end(); ?>

                            </div>

                        </div>

                </div>

        </div>

        </div>

        <?php if (Yii::$app->user->can('admin')) {?>

            <div class="col-md-6">

                <div class="row justify-content-center">

                        <div class="card card-bordered">

                            <div class="jumbotron">

                                <div class="card-header">

                                    <h4 class="card-title"><strong>На проверке</strong></h4>

                                </div>
                            </div>

                            <div class="ps-container ps-theme-default ps-active-y" id="chat-content" style="overflow-y: scroll !important; height:400px !important;">

                                <?php foreach (Json::decode($fault) as $name => $faults){?>

                                    <div class="media media-chat">

                                        <img class="avatar" src="https://img.icons8.com/color/36/000000/administrator-male.png" alt="...">

                                        <?php echo $faults['username'] ?>

                                        <div class="media-body">

                                            <p class="meta">
                                                <span class="direct-chat-timestamp pull-right">
                                                    <?php echo $faults['tdata'] ?>
                                                </span>
                                            </p>

                                            <?= Html::beginForm() ?>

                                            <?=Html::a('Вернуть', ['chats/add-chat'], [
                                                'data' => [
                                                    'method' => 'post',
                                                    'params' => [
                                                        'add_id' => $faults['id'],
                                                    ],
                                                ],
                                            ]);?>
                                            <?= Html::endForm() ?>


                                            <?= Html::beginForm() ?>

                                            <?=Html::a('Удалить', ['chats/delete-chat'], [
                                                'data' => [
                                                    'method' => 'post',
                                                    'params' => [
                                                        'del_id' => $faults['id'],
                                                    ],
                                                ],
                                            ]);?>

                                            <?= Html::endForm() ?>

                                            <p><?php echo $faults['text'] ?></p>

                                            <hr>

                                        </div>

                                    </div>

                                <?php }?>

                            </div>

                        </div>

                </div>

                <?php } ?>

    </div>

    </div>

</div>


    <?php Pjax::end(); ?>

