<?php declare(strict_types=1);

namespace Cspray\StdBlog\Component;

use Illuminate\View\Component;
use Laminas\Escaper\Escaper;

abstract class AbstractComponent extends Component {

    private static Escaper $escaper;

    protected static function escaper() : Escaper {
        if (!isset(self::$escaper)) {
            self::$escaper = new Escaper('utf-8');
        }

        return self::$escaper;
    }

}