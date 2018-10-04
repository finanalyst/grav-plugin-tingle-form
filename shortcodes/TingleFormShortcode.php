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
            $twig = $this->grav['twig'];
            $popCont = $twig->processTemplate('partials/tingle-content.html.twig', ['tform' => $params['form'] ]);
            $popCont = preg_replace( '/\s+/', ' ', $popCont);
            $output = $twig->processTemplate('partials/tingle-form.html.twig',
                [
                    'tform' => $params['form'],
                    'popCont' => $popCont,
                    'btnText' => $sc->getContent(),
                    'closeText' => isset($params['closeText'])? $params['closeText'] : '',
                    'classes' => isset($params['classes'])? $params['classes'] : '',
                    'btnClass' => isset($params['btnClass'])? $params['btnClass'] : ''
                ]);
            return $output;
        });
    }
}
