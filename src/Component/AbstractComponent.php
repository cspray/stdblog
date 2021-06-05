<?php declare(strict_types=1);

namespace Cspray\StdBlog\Component;

use Illuminate\Container\Container;
use Illuminate\View\Component;
use Illuminate\View\Factory;

abstract class AbstractComponent extends Component {

    private string $templatePath;

    public function __construct() {
        $this->templatePath = dirname(__DIR__, 2) . '/resources/template/components';
    }

    final public function render() {
        /** @var Factory $view */
        $view = Container::getInstance()->get('view');
        $templatePath = sprintf('%s/%s.blade.php', $this->templatePath, $this->getTemplateName());

        return $view->file($templatePath, $this->data());
    }

    abstract protected function getTemplateName() : string;

}