<?php

namespace Modules\Main\Http\Controllers;

use Modules\Core\Http\Controllers\CoreController;

class MainController extends CoreController
{
    public function __invoke()
    {
        title('Welcome');

        throw new \Exception('my error');

        return view('main::pages.home.index');
    }
}
