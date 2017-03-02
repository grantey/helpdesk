<?php
/**
 * 
 * 
 */

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;

//$this->params['breadcrumbs'][] = $this->title;

$modal ? $isModal = '1' : $isModal = '0';    

$script = <<< JS
    $('form#{$formOptions["id"]} .agreement > span').on('click', function(e) {
        $(this).toggleClass('active');
        if ($(this).hasClass('active')) {
            $('form#{$formOptions["id"]} button').prop('disabled', false).removeClass('disabled');
        }
        else {
            $('form#{$formOptions["id"]} button').prop('disabled', 'disabled').addClass('disabled');
        }
    });
    $('form#{$formOptions["id"]}').on('beforeSubmit', function(e) {
        var form = $(this);        
        $.post(
            form.attr("action"),            
            form.serialize()
        )
            .done(function (data) {
                console.log(data);
                form.trigger('reset');
                //$.pjax.reload({container:"#contact-form-container"});
                if (data) {
                    if (!{$isModal}) {
                        $('#{$formOptions["id"]}-modal').modal('show');
                        $('#{$formOptions["id"]}-success-modal').show();
                    }
                    else {                        
                        $('#{$formOptions["id"]}-success').show();
                    }
                }
                else {
                    if (!{$isModal}) {
                        $('#{$formOptions["id"]}-modal').modal('show');
                        $('#{$formOptions["id"]}-danger-modal').show();
                    }
                    else {                        
                        $('#{$formOptions["id"]}-danger').show();
                    }
                }
            })
            .fail(function () {
                alert('Ошибка отправки');
            });                
    return false;        
    });
    $('input[id={$formOptions["id"]}-phone]').mask("+7 (999) 999-99-99");
JS;

$this->registerJs($script, yii\web\View::POS_READY);
?>

    <?php
    if ($modal):
        if ($modalOptions['modalLink']) {
            Modal::begin([
                'id' => $modalOptions['id'],
                'size' => $modalOptions['size'],
                'toggleButton' => ['tag' => $modalOptions['modalTag'], 'label' => $modalOptions['modalLabel'], 'class' => $modalOptions['modalLabelClass']],
            ]); 
        }
        else {
            Modal::begin([
                'id' => $modalOptions['id'],
                'size' => $modalOptions['size'],            
            ]); 
        }
    ?>    

        <div class="modal-body">            
            <div class="modal-form-header"><?=$header?></div>       
            
    <?php endif; ?>

        <?php $form = ActiveForm::begin([
            'id' => $formOptions['id'],
            'action' => ['site/sendform'],
            'options' => ['class' => $formOptions['class']],
            'fieldConfig' => [
                'template' => "<div class=\"col-sm-12\">{input}</div>\n<div class=\"col-sm-12\">{error}</div>",
                'labelOptions' => ['class' => 'col-sm-3 control-label'],
            ],
        ]); ?>
   
            <?php
            foreach ($fields as $field) {
                
                switch($field['name']) {
                    case 'name': echo $form->field($model, 'name')->textInput(['placeholder' => $field['label']]); break;
                    case 'phone': echo $form->field($model, 'phone')//->widget(\yii\widgets\MaskedInput::className(), ['mask' => '+7(999) 999-99-99'])
                            ->textInput(['placeholder' => $field['label'], 'id' => $formOptions['id'].'-phone']); break;
                    case 'email': echo $form->field($model, 'email')->textInput(['placeholder' => $field['label']]); break;
                    case 'time': echo $form->field($model, 'time')->textInput(['placeholder' => $field['label']]); break;
                    case 'text': echo $form->field($model, 'text')->textarea(['rows' => 6, 'placeholder' => $field['label']]); break;
                    default: break;
                }
            } 
            ?>

            <div class="hidden">
                <?= $form->field($model, 'header')->textInput(['value' => $header]); ?>
            </div>            
            
            <?php if ($agreement) {
                echo '<div class="agreement"><span class="active"></span><p data-toggle="modal" data-target="#agreement-modal">Согласен на обработку персональных данных</p></div>';
            }
            
            echo Html::submitButton($formOptions['buttonText'], ['class' => 'btn btn-primary']);
            
            if ($agreement) {
                Modal::begin([
                    'id' => 'agreement-modal',            
                ]);
            ?>
            
            <p><b>НАСТОЯЩИМ ВЫРАЖАЮ СОГЛАСИЕ</b></p>
            <p>Ипотечный кредитный потребительский кооператив «Соодейсвие Развитию Взаимного Кредитованию», рас­по­ло­жен­ный по ад­ре­су: 119034, г. Москва, ул. Льва Тол­сто­го, д. 5/1, стр.1 (да­лее – «Кооператив»)</p>
            <p>Об­ра­ба­ты­вать сле­ду­ю­щие мои пер­со­наль­ные дан­ные: фа­ми­лия, имя, от­че­ство; пол; да­та и ме­сто рож­де­ния; пас­порт­ные дан­ные, в том чис­ле, све­де­ния об ад­ре­се ре­ги­стра­ции; иден­ти­фи­ка­ци­он­ный но­мер на­ло­го­пла­тель­щи­ка; но­мер стра­хо­во­го сви­де­тель­ства обя­за­тель­но­го пен­си­он­но­го стра­хо­ва­ния; ме­сто фак­ти­че­ско­го про­жи­ва­ния; се­мей­ное по­ло­же­ние и ко­ли­че­ство де­тей; све­де­ния о по­лу­чен­ном об­ра­зо­ва­нии; све­де­ния о фор­ме за­ня­то­сти и сред­нем раз­ме­ре ме­сяч­но­го до­хо­да и рас­хо­да;; но­ме­ра кон­такт­ных те­ле­фо­нов; ад­рес элек­трон­ной по­чты; све­де­ния о на­име­но­ва­нии ра­бо­то­да­те­ля, ад­ре­се ме­ста ра­бо­ты и долж­но­сти; тру­до­вом ста­же; а так­же иные дан­ные, предо­став­ля­е­мые мной Кооперативу в про­цес­се за­пол­не­ния ан­ке­ты на сай­те Кооператива.</p>
            <p>В слу­чае предо­став­ле­ния мною Кооперативу пер­со­наль­ных дан­ных тре­тьих лиц, я за­яв­ляю и га­ран­ти­рую, что мною по­лу­че­но со­гла­сие этих лиц на пе­ре­да­чу их пер­со­наль­ных дан­ных Кооперативу и об­ра­бот­ку этих пер­со­наль­ных дан­ных Кооперативом.</p>
            <p>Мое со­гла­сие рас­про­стра­ня­ет­ся на об­ра­бот­ку мо­их пер­со­наль­ных дан­ных Кооперативом в сле­ду­ю­щих це­лях:</p>
            <p>- рас­смот­ре­ние Кооперативом мо­их за­явок, при ко­то­ром про­из­во­дит­ся оцен­ка мо­ей по­тен­ци­аль­ной кре­ди­то­спо­соб­но­сти и пла­тё­же­спо­соб­но­сти;</p>
            <p>- осу­ществ­ле­ние и вы­пол­не­ние функ­ций, пол­но­мо­чий и обя­зан­но­стей Кооператива, воз­ло­жен­ных на не­го за­ко­но­да­тель­ством Рос­сий­ской Фе­де­ра­ции, а так­же прав и за­кон­ных ин­те­ре­сов Кооператива;</p>
            <p>- ока­за­ние мне Кооперативом фи­нан­со­вых и иных кон­суль­та­ций;</p>
            <p>Мое со­гла­сие рас­про­стра­ня­ет­ся на сле­ду­ю­щие дей­ствия об­ще­ства по об­ра­бот­ке мо­их пер­со­наль­ных дан­ных, осу­ществ­лен­ные в ука­зан­ных вы­ше це­лях: сбор, за­пись, хра­не­ние, уточ­не­ние (об­нов­ле­ние, из­ме­не­ние), ис­поль­зо­ва­ние, пе­ре­да­ча тре­тьим ли­цам (предо­став­ле­ние, до­ступ), обез­ли­чи­ва­ние, бло­ки­ро­ва­ние, уда­ле­ние и уни­что­же­ние, как с ис­поль­зо­ва­ни­ем средств ав­то­ма­ти­за­ции, так и без ис­поль­зо­ва­ния та­ких средств.</p>
            <p>На­сто­я­щее Со­гла­сие дей­ству­ет в те­че­ние 1 (один) год.</p>
            <p>На­сто­я­щее Со­гла­сие мо­жет быть ото­зва­но мной пу­тем по­да­чи Кооперативу со­от­вет­ству­ю­ще­го пись­мен­но­го за­яв­ле­ния. За­яв­ле­ние об от­зы­ве на­сто­я­ще­го Со­гла­сия мо­жет быть по­да­но толь­ко мной лич­но, для че­го я дол­жен (долж­на) явить­ся в Кооператив с до­ку­мен­том, удо­сто­ве­ря­ю­щим лич­ность, и по­дать со­труд­ни­ку Кооператива со­от­вет­ству­ю­щее за­яв­ле­ние, ли­бо на­пра­вить за­яв­ле­ние на от­зыв Со­гла­сия на юри­ди­че­ский ад­рес Кооператива, в та­ком за­яв­ле­нии долж­ны быть ука­за­ны мои пас­порт­ные дан­ные, а моя под­пись за­ве­ре­на но­та­ри­аль­но.</p>
            <p>Меж­ду мной и Кооперативом до­стиг­ну­то со­гла­ше­ние о том, что в слу­чае от­зы­ва мною на­сто­я­ще­го Со­гла­сия Кооператив впра­ве про­дол­жать об­ра­ба­ты­вать мои пер­со­наль­ные дан­ные в це­лях ис­пол­не­ния Кооперативом тре­бо­ва­ний за­ко­но­да­тель­ства.</p>
            <p>На­сто­я­щим я при­знаю и под­твер­ждаю, что в слу­чае не­об­хо­ди­мо­сти предо­став­ле­ния мо­их пер­со­наль­ных дан­ных для до­сти­же­ния ука­зан­ных вы­ше це­лей тре­тье­му ли­цу, пе­ре­да­чи Кооперативом при­над­ле­жа­щих ему функ­ций и пол­но­мо­чий ино­му ли­цу, а рав­но при при­вле­че­нии тре­тьих лиц к ока­за­нию услуг в ука­зан­ных це­лях Кооператив впра­ве в не­об­хо­ди­мом объ­е­ме рас­кры­вать для со­вер­ше­ния вы­ше­ука­зан­ных дей­ствий ин­фор­ма­цию обо мне лич­но (вклю­чая мои пер­со­наль­ные дан­ные) та­ким тре­тьим ли­цам, а так­же предо­став­лять та­ким ли­цам со­от­вет­ству­ю­щие до­ку­мен­ты, со­дер­жа­щие та­кую ин­фор­ма­цию.</p>

            <?php
                Modal::end();            
            } ?>

        <?php ActiveForm::end();
    
    //\yii\widgets\Pjax::end(); ?>
    <div class="contact-form-alerts">
        <div class="alert alert-success" id="<?=$formOptions["id"]?>-success">Спасибо за обращение!</div>
        <div class="alert alert-danger" id="<?=$formOptions["id"]?>-danger">Ошибка при отправке сообщения</div>
    </div>
    
    <div id="<?=$formOptions["id"]?>-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>            
                </div>
                <div class="modal-body">
                    <div class="contact-form-alerts contact-form-alerts-modal">
                        <div class="alert alert-success" id="<?=$formOptions["id"]?>-success-modal">Спасибо за обращение!</div>
                        <div class="alert alert-danger" id="<?=$formOptions["id"]?>-danger-modal">Ошибка при отправке сообщения</div>
                    </div>         
                </div>
            </div>
        </div>
    </div>

    <?php if ($modal) {
        
        echo '</div>';
        
        Modal::end(); 
    }
    ?>
