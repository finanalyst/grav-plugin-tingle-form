<?php
namespace Grav\Plugin\Shortcodes;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

class TingleFormShortcode extends Shortcode {
    public function init() {
        $this->shortcode->getHandlers()->add('popup-form', function(ShortcodeInterface $sc) {
            $params = $sc->getParameters();
            if ( ! isset($params['form'] ) ) {
                return '<div style="color: red;">Error in Tingle Form Shortcode: No form name is given.</div>';
            }
            //add assets
            $assets = $this->grav['assets'];
            $assets->addJs("plugin://tingle-form/assets/tingle.min.js");
            $assets->addCss("plugin://tingle-form/assets/tingle.min.css");
            $twig = $this->grav['twig'];
            $popCont = $twig->processTemplate('partials/tingle-content.html.twig', ['tform' => $params['form'] ]);
            $popCont = preg_replace( '/\s+/', ' ', $popCont);
            $output = $twig->processTemplate('partials/tingle-form.html.twig',
                [
                    'tform' => $params['form'],
                    'popCont' => $popCont,
                    'btnText' => $sc->getContent(),
                    'closeText' => $closeText,
                    'classes' => isset($params['classes'])? $params['classes'] : ''
                ]);
            return $output;
        });
    }
}
