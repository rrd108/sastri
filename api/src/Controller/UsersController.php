<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Chronos\Chronos;
use Cake\Utility\Security;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function login()
    {
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $userIdentity = $this->Authentication->getIdentity();

            $user = $userIdentity->getOriginalData();
            list($user->token, $user->token_expiration) = $this->generateToken();
            $user->last_login = Chronos::now();
            $user = $this->Users->save($user);

            $this->set(compact('user'));
            $this->viewBuilder()->setOption('serialize', ['user']);

            // delete all expired tokens
            $this->Users->updateAll(
                ['token' => null, 'token_expiration' => null],
                ['token_expiration <' => Chronos::now()]
            );
        }
    }

    private function generateToken()
    {
        $length = 36;
        $random = base64_encode(Security::randomBytes(36));
        $cleaned = preg_replace('/[^A-Za-z0-9]/', '', $random);
        return [$cleaned, strtotime('+6 hours')];
    }
}
