<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;

/**
 * Class ComputationPresenter
 * @package App\Presenters
 */
final class ComputationPresenter extends Nette\Application\UI\Presenter
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
