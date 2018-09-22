<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 22.09.18
 * Time: 14:59
 */

namespace Service;


use Core\App;

class Templater
{

    /**
     * todo::rewrite
     * @param string $template
     * @param array $data
     *
     * @return mixed|string
     */
    public function render(string $template, $data = [])
    {
        $content  = $this->getTemplate($template);
        preg_match_all('/\%\%(.*?)\%\%/si', $content, $patterns);
        if ($patterns[1]) {
            foreach ($patterns[1] as $element) {
                $content = str_ireplace('%%' . $element . '%%', $data[$element], $content);
            }
        }

        return $content;
    }

    private function getTemplate($template): string
    {
        return file_get_contents(sprintf('%s/%s.html', App::getTemplateDir(), $template));
    }
}