<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;

/**
 * Class ExamplePresenter
 * @package App\Presenters
 */
final class ExamplePresenter extends Nette\Application\UI\Presenter
{
    public function startup(): void
    {
        parent::startup();
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:');
        }
    }

    public function renderDefault(): void
    {

    }
}
