<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Chronos\Date;
use Cake\I18n\FrozenDate;

/**
 * Advancements Controller
 *
 * @property \App\Model\Table\AdvancementsTable $Advancements
 * @method \App\Model\Entity\Advancement[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AdvancementsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = ['contain' => ['Books']];
        $advancements = $this->paginate($this->Advancements->find()
            ->where([
                'user_id' => $this->Authentication->getIdentity()->getIdentifier(),
                'date >=' => '2023-01-01',
                'date <=' => '2023-01-08',
            ]));

        $allDates = $this->getBetweenDates('2023-01-01', '2023-01-08');
        $advancementsDates = $advancements->extract('date')->toArray();
        $missingDates = array_diff($allDates, $advancementsDates);

        $advancements = $advancements->toArray();

        foreach ($missingDates as $missingDate) {
            $advancements[] = ["date" => $missingDate, "pages" => 0];
        }

        $this->set(compact('advancements'));
        $this->viewBuilder()->setOption('serialize', ['advancements']);
    }

    private function getBetweenDates($startDate, $endDate)
    {
        $rangArray = [];

        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);

        for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate += (86400)) {

            $rangArray[] = new FrozenDate($currentDate);
        }

        return $rangArray;
    }

    /**
     * View method
     *
     * @param string|null $id Advancement id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $advancement = $this->Advancements->get($id, [
            'contain' => ['Users', 'Books'],
        ]);

        $this->set(compact('advancement'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $advancement = $this->Advancements->newEmptyEntity();
        if ($this->request->is('post')) {
            $advancement = $this->Advancements->patchEntity($advancement, $this->request->getData());
            if ($this->Advancements->save($advancement)) {
                $this->Flash->success(__('The advancement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The advancement could not be saved. Please, try again.'));
        }
        $users = $this->Advancements->Users->find('list', ['limit' => 200])->all();
        $books = $this->Advancements->Books->find('list', ['limit' => 200])->all();
        $this->set(compact('advancement', 'users', 'books'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Advancement id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $advancement = $this->Advancements->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $advancement = $this->Advancements->patchEntity($advancement, $this->request->getData());
            if ($this->Advancements->save($advancement)) {
                $this->Flash->success(__('The advancement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The advancement could not be saved. Please, try again.'));
        }
        $users = $this->Advancements->Users->find('list', ['limit' => 200])->all();
        $books = $this->Advancements->Books->find('list', ['limit' => 200])->all();
        $this->set(compact('advancement', 'users', 'books'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Advancement id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $advancement = $this->Advancements->get($id);
        if ($this->Advancements->delete($advancement)) {
            $this->Flash->success(__('The advancement has been deleted.'));
        } else {
            $this->Flash->error(__('The advancement could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
