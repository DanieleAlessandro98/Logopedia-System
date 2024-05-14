<?php include '_form_esercizio.php'; ?>
<?=
$form->field($model, 'tipologia')->dropDownList([
    '0' => 'Denominazione immagini',
    '1' => 'Coppie minime',
    '2' => 'Ripetizione parole',
], ['disabled' => 'disabled', 'options' => [ 2 => ['Selected'=>'selected']]]);
?>