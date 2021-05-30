<?php declare(strict_types=1);

namespace Cspray\StdBlog\Component;

use Illuminate\View\Component;
use Laminas\Escaper\Escaper;

abstract class AbstractComponent extends Component {

    protected Escaper $escaper;

    protected function __construct() {
        $this->escaper = new Escaper('utf-8');
    }

}