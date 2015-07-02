<?php

namespace roman444uk\magnificPopup;

use yii;
use yii\web\JsExpression;
use yii\helpers\Json;

class MagnificPopup extends \yii\base\Widget
{
    /**
     * Jquery selector to which element should apply the magnific-popup.
     * @var string jQuery Selector
     */
    public $target;
    
    /**
     * Options in the documentation for magnific-popup
     * @see http://dimsemenov.com/plugins/magnific-popup/documentation.html
     * @var array Magnific-Popup Option
     */
    public $options = array();
    
    /**
     * @var type 
     */
    public $defaultOptions = array(
        'type' => 'image'
    );
    /**
     * Language for internationalization.
     * Null for auto detect.
     * @var string 
     */
    public $language;
    
    /**
     * Effects in http://codepen.io/dimsemenov/pen/GAIkt
     * @var string  
     */
    public $effect;
    
    /**
     * Alias for 'type' in option;
     * 
     * <li>ajax</li>
     * <li>iframe</li>
     * <li>image</li>
     * <li>inline</li>
     * 
     * @var type string
     */
    public $type;
    
    /**
     * @var string asset class
     */
    public $asset = '\roman444uk\magnificPopup\MagnificPopupAsset';
    
    /**
     * Run this widget.
     * This method registers necessary javascript.
     */
    public function run() {
        $effectList = ['fade', 'with-zoom', 'zoom-in', 'newspaper',
            'move-horizontal', 'move-from-top', '3d-unfold', 'zoom-out'];
        
        if ($this->effect && in_array($this->effect, $effectList)) {
            $this->defaultOptions['mainClass'] = 'mfp-' . $this->effect;
            $this->defaultOptions['removalDelay'] = 500;
            $this->defaultOptions['callbacks'] = array(
                'beforeOpen' => new JsExpression("function(){this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');}")
            );
            if ($this->effect == 'with-zoom') {
                $this->defaultOptions = array_merge($this->defaultOptions, array(
                    'zoom' => array(
                        'enabled' => true,
                    ),
                ));
            }
        }
        if ($this->type !== null) {
            $this->options['type'] = $this->type;
        }
        $options = array_merge($this->defaultOptions, $this->options);
        $optionsJs = Json::encode($options);
        $js = "jQuery('{$this->target}').magnificPopup($optionsJs);";
        
        $this->publishAssets();
        $this->getView()->registerJs($js);
    }
    
    /**
     * Function to publish and register assets on page 
     * @throws Exception
     */
    public function publishAssets() {
        $assets = dirname(__FILE__) . '/assets';
        //$baseUrl = Yii::$app->assetManager->publish($assets);
        
        $assetClass = $this->asset;
        $assetClass::register($this->getView());
        /*if (is_dir($assets)) {
            Yii::$app->clientScript->registerroman444uk\coreScript('jquery');
            Yii::$app->clientScript->registerScriptFile(
                $baseUrl . '/jquery.magnific-popup' . (!YII_DEBUG ? '.min' : '') . '.js',
                CClientScript::POS_HEAD
            );
            
            if ($this->language == null) {
                $this->language = strtolower(Yii::app()->language);
            }
            
            if ($this->language) {
                $avaliableLanguages = array('pt-br');
                if (in_array($this->language, $avaliableLanguages)) {
                    Yii::app()->clientScript->registerScriptFile($baseUrl . '/locales/jquery.magnific-popup.' . $this->language . '.js', CClientScript::POS_HEAD);
                } elseif (in_array(substr($this->language, 0, 2), $avaliableLanguages)) {
                    Yii::app()->clientScript->registerScriptFile($baseUrl . '/locales/jquery.magnific-popup.' . substr($this->language, 0, 2) . '.js', CClientScript::POS_HEAD);
                }
            }
            
            Yii::$app->clientScript->registerCssFile($baseUrl . '/magnific-popup.css');
            
            if ($this->effect && (isset($this->defaultOptions['mainClass']) && $this->defaultOptions['mainClass'])) {
                Yii::app()->clientScript->registerCssFile($baseUrl . '/magnific-popup.effects.css');
            }
        } else {
            throw new Exception('EBaseMagnificPopup - Error: Couldn\'t find assets to publish.');
        }*/
    }
}