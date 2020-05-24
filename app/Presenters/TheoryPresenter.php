<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;

/**
 * Class TheoryPresenter
 * @package App\Presenters
 */
final class TheoryPresenter extends Nette\Application\UI\Presenter
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
