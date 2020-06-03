<?php

namespace App;

use Nette;

/**
 * Class ComputationPresenter
 * @package App\Presenters
 */
class ComputationPresenter extends BasePresenter
{
    public function startup()
    {
        parent::startup();
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:');
        }
    }

    public function renderDefault()
    {

    }
}
