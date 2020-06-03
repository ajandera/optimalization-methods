<?php

namespace App;

use Nette;

/**
 * Class BasePresenter
 * @package App
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

    /**
     * Applicarion startap method
     */
    protected function startup()
    {
        parent::startup();
    }
}
