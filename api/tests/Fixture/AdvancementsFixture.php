<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AdvancementsFixture
 */
class AdvancementsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'user_id' => 1,
                'book_id' => 1,
                'date' => '2023-01-15',
                'pages' => 1,
            ],
        ];
        parent::init();
    }
}
