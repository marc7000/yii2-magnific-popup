<?php

namespace roman444uk\magnificPopup;

class MagnificPopupAsset extends \yii\web\AssetBundle
{
    public function init()
    {
        $this->sourcePath = '@roman444uk\core/assets';
        $this->js = [
            'js/jquery.magnific-popup.js',
        ];
        $this->css = [
            'css/magnific-popup.css'
        ];

        parent::init();
    }
}