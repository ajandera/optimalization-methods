<?php

namespace App;

/**
 * Class HomepagePresenter
 * @package App\Presenters
 */

class HomepagePresenter extends BasePresenter
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
